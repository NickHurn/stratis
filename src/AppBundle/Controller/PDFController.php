<?php

namespace AppBundle\Controller;

use AppBundle\Entity\ApplicantDisclosureData;
use AppBundle\Entity\ApplicantDisclosureVerification;
use AppBundle\Entity\Users;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class PDFController extends Controller
{
    /**
     * @Route("/pdf/generate/{user_id}/{job_id}/{unique_id}", name="generate_pdf_report")
     */
    public function generateAction(Request $request, $user_id, $job_id, $unique_id)
    {
//        $em = $this->getDoctrine()->getManager();
//        $dbs = $em->getRepository('AppBundle:ApplicantDisclosures')->findOneBy(['code'=>$code]);
		$this->_helper->viewRenderer->setNoRender(true);

///		$user_id = $this->getRequest()->getParam('u');
///		$job_id = $this->getRequest()->getParam('j');
///		$unique_id = $this->getRequest()->getParam('ui');

		$pdf = new PDF($user_id, $job_id, $unique_id);
		
		$clientName = $pdf->getEmployerNameFromJobId($job_id);
		$candidate = $pdf->getCandidateInfo($user_id);


        //-------------------------------------------------------------------
		//  Define section name headers
        //-------------------------------------------------------------------

        $checkNames = array(
            0=>'Basic Disclosure (DBS) Check',
            'Qualification Check',
            'Identity Check',
            'Passport Check',
            'Directorship Check (UK)',
            'Employee Credit Check',
            'Enhanced Politically Exposed Person\'s Check',
            'Enhanced Sanctions and Enforcements Check',
        );


        //-------------------------------------------------------------------
        //  Get status of each section header
        //-------------------------------------------------------------------

        $dbs	= $pdf->getDBSCheck();
		$qual	= $pdf->getQualificationCheck();
		$id		= $pdf->getIDCheck();
		$pass	= $pdf->getPassportCheck();
		$dir	= $pdf->getDirectorshipCheck();
		$cred	= $pdf->getCreditCheck();
		$pep	= $pdf->getPEPCheck();
		$sanc	= $pdf->getSanctionsCheck();
		$checkValues = array($dbs,$qual,$id,$pass,$dir,$cred,$pep,$sanc);


        //-------------------------------------------------------------------
        //  Get subline text for each header
        //-------------------------------------------------------------------

        $checkSublines[0] = $pdf->getDBSDetails($dbs);
        $checkSublines[1] = $pdf->getQualificationDetails();
        $checkSublines[2] = $pdf->getIDCheckDetails($id);
        $checkSublines[3] = $pdf->getPassportCheckDetails($pass);
        $checkSublines[4] = $pdf->getDirectorshipDetails();
        $checkSublines[5] = $pdf->getCreditCheckDetails($cred);
        $checkSublines[6] = $pdf->getSanctionsDetails();
        $checkSublines[7] = $pdf->getPEPDetails();



        //-------------------------------------------------------------------
        //  Send all info to the PDF generator
        //-------------------------------------------------------------------

		$this->generatePDF(array(
			'clientName'		=> $clientName,
			'candidateName'		=> $candidate['name'],
			'dob'				=> date('jS M, Y', strtotime($candidate['dob'])),
			'address'			=> $candidate['address'],
			'checkNames'        => $checkNames,
			'checkValues'		=> $checkValues,
			'checkSublines'		=> $checkSublines,
		));
	}

	
	//----------------------------------------------------------------------------------
	//  Generate a PDF from the passed data and output it to the browser
	//----------------------------------------------------------------------------------
	
	private function generatePDF($data)
	{
		$config = Zend_Registry::get('config');
		define('FPDF_FONTPATH', $config->pdf_path);
		$pdf = new Model_FPDF2('P','mm','A4');
		$pdf->setHeaderFooterData($data);
		$pdf->setImagePath($config->pdf_path);
		
		$pdf->AddFont('HFontMed','B','NHaasGroteskDSPro-65Md.php');
		$pdf->AddFont('HFontLite','','NHaasGroteskDSPro-35XLt.php');
		$pdf->SetMargins(5,5,5);
		$pdf->AddPage();


		$checkNames = $data['checkNames'];
		$checkValues = $data['checkValues'];
        $checkSublines = $data['checkSublines'];


        $pdf->SetFont('HFontLite','',10);
        $pdf->Text(20,80,'Candidate Full Name');
        $pdf->Text(20,95,'Date Of Birth');
        $pdf->Text(20,110,'Address');

        $pdf->SetFont('HFontMed','B',12);
        $pdf->Text(20,85, $data['candidateName']);
        $pdf->Text(20,100, $data['dob']);
        $pdf->Text(20,115, $data['address']);

        $y=140;

		for($row=0; $row<=7; $row++)
		{
            if($row==6) { $pdf->AddPage(); $y=80; }
            switch ($checkValues[$row])
            {
                case 'R':
                    $image = 'cross.png';
                    break;
                case 'A':
                    $image = 'na.png';
                    break;
                case 'G':
                    $image = 'tick.png';
                    break;
                default:
                    $image = 'notchecked.png';
                    break;
            }


            $pdf->SetDrawColor(200,200,200);
            $pdf->SetLineWidth(0.1);
            $pdf->Line(20, $y, 190, $y);
            $pdf->SetFont('HFontMed', 'B', 13);
            $pdf->Text(30, $y + 8, $checkNames[$row]);

            if ($image == 'notchecked.png') {
                $pdf->Image($image, 171, $y + 4, 14);
            } else {
                $pdf->Image($image, 175, $y + 4, 7);
            }

            $pdf->SetFont('HFontLite', '', 8);
            $y+=10;

            $line = $checkSublines[$row];
            $sublines = explode("\n", $line);
            foreach($sublines as $subline)
            {
                if($y>=260) { $pdf->AddPage(); $y=80; }
                $icon = substr($subline,0,1);
                $subtext = substr($subline,1);
                switch ($icon)
                {
                    case 'G':   $image='tick32.png'; break;
                    case 'R':   $image='red32.png'; break;
                    case 'A':   $image='amber32.png'; break;
                    default:   $image=null;
                }
                if($image) $pdf->Image($image, 40, $y, 3, 3);
                $pdf->Text(45,$y+2.5, $subtext);
                $y+=4;
            }

            $y+=3;
            $pdf->SetDrawColor(200,200,200);
            $pdf->SetLineWidth(0.1);
            $y+=5;
		}

		//  Output to browser
		$data = $pdf->Output('S','report.pdf');
		header('Content-Type: application/octet-stream');
		header('Content-Disposition: attachment; filename=report.pdf');
		print $data;
		die;
	}
}
