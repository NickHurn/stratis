<?php

namespace AppBundle\Controller;

use AppBundle\Entity\ApplicantDisclosureData;
use AppBundle\Entity\ApplicantDisclosureVerification;
use AppBundle\Entity\Users;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use AppBundle\Model\FPDF;
use AppBundle\Model\FPDF2;


class PDFIDController extends Controller
{
    /**
     * @Route("/pdfid/generate/{userid}/{jobcode}", name="generate_pdfid_report")
     */
    public function generateAction(Request $request) //, $user_id, $job_id)
    {
		$userid = $request->get('userid');
		$job_code = $request->get('jobcode');

		$em = $this->getDoctrine()->getManager();		
		$employer_id = $this->getUser()->getEmployerId();

		//  Make sure there is a job relating to this user and jobid (if not, die)
		$job = $em->getRepository('AppBundle:Jobs')->findOneBy(['uniqueid'=>$job_code, 'employerId'=>$employer_id]);

		if($job)
		{
			$usersjob = $em->getRepository('AppBundle:UsersJob')->findOneBy(['jobId'=>$job_code, 'userId'=>$userid]);
		}

		if(!$usersjob)
		{
			return $this->render('@App/error/usererror.html.twig', array(
				'title' => 'Invalid Report Requested',
				'msg' => 'The report you are requesting is not a valid URL.',
			));
		}
		

        //-------------------------------------------------------------------
		//  Grab report data
        //-------------------------------------------------------------------
		
		$aml = $em->getRepository('AppBundle:AMLData')->findOneBy(['userId'=>$userid, 'jobCode'=>$job_code]);
		if(!$aml)
		{
			return $this->render('@App/error/error.html.twig', array(
			'title' => 'No AML Check Completed',
			'msg' => 'PDF reports are only available for candidates that have completed an AML check.',
			'hideextra' => 1,
		));

		}
		$x = $aml->getTestinfo();
		$sections = unserialize($x);
		$gc = new \AppBundle\Model\GbgCleanup();
		$sections = $gc->fixdata($sections);



		$ec = $em->getRepository("AppBundle:ExtraChecks")->createQueryBuilder('ec')
			->where('ec.userId = :uid')
			->andWhere('ec.jobCode = :jid')
			->andWhere('ec.checkType LIKE :chk')
			->setParameter('uid', $userid)
			->setParameter('jid', $job_code)
			->setParameter('chk', 'KYC%')
			->getQuery()
			->getResult(\Doctrine\ORM\Query::HYDRATE_ARRAY);
		$reportType = $ec[0]['checkType'];
		

		//-------------------------------------------------------------------
		//  Add in photo identity check if requested
		//-------------------------------------------------------------------

		$fc = $em->getRepository('AppBundle:FaceCompareChecks')->findOneBy(['userId'=>$userid, 'jobCode'=>$job_code]);
		if($fc)
		{
			$media = $em->getRepository('AppBundle:Media');
			$leftphoto = $media->getMediaFilename('PHOTO', $userid, $job_code, $fc->getSource(), 1); // PASSPORT or DRIVING
			$rightphoto = $media->getMediaFilename('PHOTO', $userid, $job_code, 'VISUALID', 1);

			$sections['Face Comparison'] = array(
				'LEFTPHOTO' => $leftphoto,
				'RIGHTPHOTO' => $rightphoto,
				'SCORE' => $fc->getResult(),
			);
		}
		
		
		//-------------------------------------------------------------------
		//  Add in directorships if requested
		//-------------------------------------------------------------------
		
		$dc = $em->getRepository('AppBundle:DirectorChecks')->findOneBy(['userId'=>$userid, 'jobCode'=>$job_code]);
		if($dc)
		{
			$txt = trim($dc->getCompanies());
			if($txt)
			{
				$result = 'G';
			}
			else
			{
				$result = 'A';
				$txt = 'None found';
			}
			$sections['Directorships'] = array(
				'LINES' => $txt,
				'RESULT' => $result,
			);
		}

		
		//-------------------------------------------------------------------
		//  If driving licence section and we have driving licence photo,
		//  include the photo.
		//-------------------------------------------------------------------
		
		$driving_licence_image = '';
		if(!empty($sections['UK Driving Licence (Full)']))
		{
			$media = $em->getRepository('AppBundle:Media');

			$filename = $media->getMediaFilename('PHOTO',$userid,$job_code,'DRIVING');
			if(!empty($filename))
			{
				if(substr($filename,0,1)=='/') $filename = substr($filename,1); // remove any leading slash
				$driving_licence_image = $filename;
			}
		}


		//-------------------------------------------------------------------
		//  If passport section and we have a passport photo, include it.
		//-------------------------------------------------------------------
		
		$passport_image = '';
		if(!empty($sections['International Passport']))
		{
			$media = $em->getRepository('AppBundle:Media');
			$filename = $media->getMediaFilename('PHOTO',$userid,$job_code,'PASSPORT');
			if(!empty($filename))
			{
				if(substr($filename,0,1)=='/') $filename = substr($filename,1); // remove any leading slash
				$passport_image = $filename;
			}
		}

		
		//-------------------------------------------------------------------
		//  Get colour scheme info
		//-------------------------------------------------------------------
		
		$client = $em->getRepository('AppBundle:CssSchemes')->findOneBy(['employer_id'=>$employer_id]);
		if($client)
		{
			$clientName = $client->getCompanyName();
			$bgcolor = $client->getHeaderBackground();
			$logo = $client->getDomain() . "_logo.png";
		}
		else
		{
			$clientName = 'Hireabl';
			$bgcolor = '#e9bc11';
			$logo = "hireabl.co.uk_logo.png";
		}


		//-------------------------------------------------------------------
		//  Get candidate info
		//-------------------------------------------------------------------
		
		$candidate = $em->getRepository('AppBundle:users')->findOneBy(['id'=>$userid]);
		$candidateName = $candidate->getFirstname() . ' ' . $candidate->getSurname();
		$address = $aml->getAddress();
		if(!$address) $address = 'Unknown';
		$filename = 'KYC-AML-' . $candidate->getFirstname() . $candidate->getSurname() . '.pdf';
		
		// Date Of Birth
		$dob = null;
		$passport = $em->getRepository('AppBundle:PassportData')->findOneBy(['userId'=>$userid]);
		if($passport) { $dob = $passport->getDob(); }
		if(!$dob)
		{
			$driving = $em->getRepository('AppBundle:DrivingData')->findOneBy(['userId'=>$userid]);
			if($driving) { $dob = $driving->getDob(); }
		}
		if(!$dob)
		{
			$dob = 'Unknown';
		}
		else
		{
			$dob = date("jS F, Y",strtotime($dob));
		}
		
		
		//-------------------------------------------------------------------
        //  Send all info to the PDF generator
        //-------------------------------------------------------------------

		$this->generatePDF(array(
			'clientName'		=> $clientName,
			'candidateName'		=> $candidateName,
			'dob'				=> $dob,
			'address'			=> $address,
			'sections'			=> $sections,
			'reportType'		=> $reportType,
			'filename'			=> $filename,
			'logo'				=> $logo,
			'bgcolor'			=> $bgcolor,
			'driving_licence'	=> $driving_licence_image,
			'passport_image'	=> $passport_image,
		));
	}

	//----------------------------------------------------------------------------------
	//  Generate a PDF from the passed data and output it to the browser
	//----------------------------------------------------------------------------------
	
	private function generatePDF($data)
	{
		define('FPDF_FONTPATH', $this->getParameter('FPDF_FONTPATH'));
		$pdf = new FPDF2('P','mm','A4');
		$pdf->setHeaderFooterData($data);
        $pdf->setImagePath($this->getParameter('webPath'));

		$pdf->AddFont('HFontMed','B','NHaasGroteskDSPro-65Md.php');
		$pdf->AddFont('HFontLite','','NHaasGroteskDSPro-35XLt.php');

		$pdf->logo = $data['logo'];
		$pdf->backgroundColour = $data['bgcolor'];
		
		$pdf->SetMargins(5,5,5);
		$pdf->AddPage();


		$pdf->SetFont('HFontLite','',10);
        $pdf->Text(20,80,'Candidate Full Name');
        $pdf->Text(20,95,'Date Of Birth');
        $pdf->Text(20,110,'Address');

        $pdf->SetFont('HFontMed','B',12);
        $pdf->Text(20,85, $data['candidateName']);
        $pdf->Text(20,100, $data['dob']);
        $pdf->Text(20,115, $data['address']);

        $y=140;

		foreach($data['sections'] as $title=>$section)
		{
			if($title=='OVERALL') continue;
			if($y>=260) { $pdf->AddPage(); $y=80; }
            
			$pdf->SetDrawColor(200,200,200);
            $pdf->SetLineWidth(0.1);
            $pdf->Line(20, $y, 190, $y);
            $pdf->SetFont('HFontMed', 'B', 13);
            $pdf->Text(30, $y + 8, $title);
			
			
			//------------------------------------------------------
			//  Face Comparison
			//------------------------------------------------------
			
			if($title == 'Face Comparison')
			{
				if($y>=200) { $pdf->AddPage(); $y=80; }
				$pdf->SetFont('HFontLite', '', 8);
				$pdf->Text(45, $y+15, "Confidence: {$section['SCORE']}%");
				$pdf->Image($section['LEFTPHOTO'], 45, $y+20, 42, 27);
				$pdf->Image($section['RIGHTPHOTO'], 100, $y+20, 42, 27);
				$pcnt = $section['SCORE'];
				$image='pdf/cross.png';
				if($pcnt>=50 and $pcnt<75) $image='pdf/na.png';
				if($pcnt>=75) $image='pdf/tick.png';
				$pdf->Image($image, 180, $y+5, 8, 8);
				$y+= 60;
			}
			else
			{
				//------------------------------------------------------
				//  Standard Types
				//------------------------------------------------------

				switch ($section['RESULT'])
				{
					case 'G':   $image='pdf/tick.png'; break;
					case 'R':   $image='pdf/cross.png'; break;
					case 'A':   $image='pdf/na.png'; break;
					default:   $image=null;
				}
				if($image) $pdf->Image($image, 180, $y+5, 8, 8);


				$pdf->SetFont('HFontLite', '', 8);
				$y+=10;

				$sublines = explode("\n", $section['LINES']);
				foreach($sublines as $subline)
				{
					if($y>=270) { $pdf->AddPage(); $y=80; }
					$icon = substr($subline,0,1);
					$subtext = substr($subline,1);
					$pdf->Text(45,$y+2.5, $subline);
					$y+=4;
				}

				$y+=3;
				$pdf->SetDrawColor(200,200,200);
				$pdf->SetLineWidth(0.1);
				$y+=5;


				//-------------------------------------------------------------------
				//  If this section is driving licence and we have a photo, show it
				//-------------------------------------------------------------------

				if($title=='UK Driving Licence (Full)')
				{
					if(!empty($data['driving_licence']))
					{
						if($y>=270) { $pdf->AddPage(); $y=80; }
						$pdf->Image($data['driving_licence'], 40, $y-20, 85, 54);

						$y+=60;
					}
				}


				//-------------------------------------------------------------------
				//  If this section is passport and we have a photo, show it
				//-------------------------------------------------------------------

				if($title=='International Passport')
				{
					if(!empty($data['passport_image']))
					{
						if($y>=270) { $pdf->AddPage(); $y=80; }
						$pdf->Image($data['passport_image'], 40, $y-10, 85, 54);
						$y+=60;
					}
				}
			}
		}
		

		//-------------------------------------------------------------------
		//  Output to browser
		//-------------------------------------------------------------------
		
		$f = $data['filename'];
		$data = $pdf->Output('S');
		header('Content-Type: application/octet-stream');
		header("Content-Disposition: attachment; filename=$f");
		print $data;
		die;
	}
}
