<?php

namespace AppBundle\Controller;

use AppBundle\Entity\WebHookTests;
use Model_Excel;
use Model_Testabl;
use Model_User;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use AppBundle\Entity\Users;
use AppBundle\Entity\UsersRoles;
use PhpOffice\PhpSpreadsheet\Spreadsheet;


class UserController extends Controller
{
    /**
	 * @Security("has_role('ROLE_CLIENT')")
     * @Route("/user/edit/self", name="user_edit_self")
     */
    public function editselfAction(Request $request)
    {
		$user = $this->getUser();
		$user_id = $user->getId();
		$em = $this->getDoctrine()->getManager();		

		$addr = $em->getRepository('AppBundle:Address')->findOneBy(['userid'=>$user_id]);
	
		$form = $this->createForm(\AppBundle\Form\UserEditNoGDPR::class);
		$form->handleRequest($request);
		if ($form->isSubmitted() && $form->isValid())
		{
			$data = $form->getData();
			$user->setFirstname($data['firstname']);
			$user->setSurname($data['surname']);
			$user->setEmailAddress($data['emailaddress']);
			$user->setHomeTel($data['hometel']);
			$user->setMobileTel($data['mobiletel']);
			$addr->setLine1($data['line1']);
			$addr->setLine2($data['line2']);
			$addr->setLine3($data['line3']);
			$addr->setTown($data['town']);
			$addr->setCounty($data['county']);
			$addr->setPostcode($data['postcode']);
			$em->persist($user);
			$em->persist($addr);
			$em->flush();
			$this->addFlash("success", "Changes saved");
			return $this->redirect("/user/edit/self");
		}

		$form->setData(array(
			'firstname'	=> $user->getfirstname(),
			'surname'	=> $user->getSurname(),
			'emailaddress'	=> $user->getEmailAddress(),
			'hometel'	=> $user->getHomeTel(),
			'mobiletel'	=> $user->getMobileTel(),
			'line1'		=> $addr->getLine1(),
			'line2'		=> $addr->getLine2(),
			'line3'		=> $addr->getLine3(),
			'town'		=> $addr->getTown(),
			'county'	=> $addr->getCounty(),
			'postcode'	=> $addr->getPostcode(),
		));

		
		return $this->render('@App/user/adminedit.html.twig', array(
			'form' => $form->createView(),
			'title' => 'Your Profile',
		));
	}

	
    /**
	 * @Security("has_role('ROLE_MASTER_CLIENT') or has_role('ROLE_ADMIN')")
     * @Route("/staff/edit/new", name="staff_edit_new")
     */
    public function editnewAction(Request $request)
    {
		$user = $this->getUser();
		$user_id = $user->getId();
		$employer_id = $user->getEmployerId();
		$em = $this->getDoctrine()->getManager();		
		
		$form = $this->createForm(\AppBundle\Form\SystemUserEdit::class);
		$form->handleRequest($request);
		$error = null;
		$data = $form->getData();
		if ($form->isSubmitted() && $form->isValid())
		{
			// check email address is not already used
			$check = $em->getRepository('AppBundle:Users')->checkEmailIsUnique($data['emailaddress']);
			if($check==false)
			{
				$request->getSession()->getFlashBag()->add('error', 'Email address is already in use');
			}
			else
			{
				$css = $em->getRepository('AppBundle:CssSchemes')->getEmployerFromDomain();
				$companyname = $css->getCompanyName();

				$u = new Users();
				$u->setFirstName($data['firstName']);
				$u->setSurname($data['surname']);
				$u->setEmailAddress($data['emailaddress']);
				$u->setHomeTel($data['hometel']);
				$u->setMobileTel($data['mobiletel']);
				$u->setEmployerId($employer_id);
				$u->setTempPassword(1);
				$password = substr(base64_encode(random_bytes(8)),0, -1);
				$u->setPassword($password, $this->get('security.password_encoder'));
				$u->setPlainPassword($password);
				$em->persist($u);
				$em->flush();
				
				$ur = new UsersRoles();
				$ur->setUsersId($u->getId());
				$ur->setRoleId(2);
				$em->persist($ur);
				$em->flush();
				
				$se = new \AppBundle\Model\SendEmail($this->get('twig'), $this->get('mailer'), $this->getDoctrine()->getManager());
				$ret = $se->send('', $u->getUsername(), $u->getId(), "Welcome to the Koine system", "newstaff",
					array('name' => $u->getFirstName() . ' ' . $u->getSurname(), 'email' => $u->getEmailaddress(), 'password' => $password, 'companyname'=>$companyname, 'domain' => $_SERVER['HTTP_HOST']));
				
				if($ret<>1) {
					return $this->render('@App/error/error.html.twig', array(
						'title' => 'Unable to send email',
						'msg' => 'An error occured which prevented an email from being sent.'
					));
				}
				
				$this->addFlash("success", "Changes saved");
				return $this->redirect("/staff");
			}
		}

		return $this->render('@App/user/adminedit.html.twig', array(
			'form' => $form->createView(),
			'title' => 'New User',
		));
	}

	
	/**
	 * @Security("has_role('ROLE_MASTER_CLIENT') or has_role('ROLE_ADMIN')")
     * @Route("/staff/edit/{id}", name="staff_edit")
     */
    public function edituserAction(Request $request)
    {
		$id = $request->get('id');
		$user = $this->getUser();
		$user_id = $user->getId();
		$employer_id = $user->getEmployerId();
		$em = $this->getDoctrine()->getManager();		
		$u = $em->getRepository('AppBundle:Users')->findOneBy(['id'=>$id, 'employerId'=>$employer_id]);
		if(!$u) {
			return $this->render('@App/error/error.html.twig', array('msg' => 'This user cannot be found'));
		}
		$form = $this->createForm(\AppBundle\Form\SystemUserEdit::class, $u);
		$form->handleRequest($request);
		$error = null;
		$data = $form->getData();
		if ($form->isSubmitted() && $form->isValid())
		{
			// check email address is not already used
			$check = $em->getRepository('AppBundle:Users')->checkEmailIsUnique($data->getEmailaddress(), $id);
			if($check==false)
			{
				$request->getSession()->getFlashBag()->add('error', 'Email address is already in use');
			}
			else
			{
				$em->persist($data);
				$em->flush();
				$this->addFlash("success", "Changes saved");
				return $this->redirect("/staff");
			}
		}

		return $this->render('@App/user/adminedit.html.twig', array(
			'form' => $form->createView(),
			'title' => $u->getFirstname().' '.$u->getSurname(),
		));
	}

    /**
     * @Security("has_role('ROLE_MASTER_CLIENT') or has_role('ROLE_ADMIN')")
     * @Route("/user/generateexcel/{userId}/{employerJobId}", name="generate_excel")
     */
    public function generateexcelAction(Request $request, $userId, $employerJobId)
    {
        /**
         * @var $user Users
         */
        $user = $this->getUser();
        $em = $this->getDoctrine()->getManager();

        if(!is_null($employerJobId)) {
            $excelUtil = $this->get('app.model_excel');
            $user_id = filter_var((int) $userId, FILTER_SANITIZE_NUMBER_INT);
            $user = $this->getUser();
            $employer_id = $user->getEmployerId();
            $personalData = $em->getRepository('AppBundle:Users')->getAllUserData($employer_id,(int)$user_id);
            $testResults = $em->getRepository('AppBundle:Users')->getUsersTestResults($user_id, $employer_id);
            $educationhistory = $em->getRepository('AppBundle:HistoryEducation')->getEducationHistory($user_id, $employer_id);
            $employmenthistory = $em->getRepository('AppBundle:HistoryEmployment')->getEmploymentHistory($user_id, $employer_id);
            $interviews = $em->getRepository('AppBundle:Interviews')->getInterviewDetails($user_id, $employer_id);
            $references = $em->getRepository('AppBundle:ReferenceRequest')->getReferences($user_id, $employer_id);
            $prescreen = $em->getRepository('AppBundle:PreScreen')->getPreScreenDetails($user_id, $employer_id);
            $excel = new Spreadsheet();
            $writer = new Xlsx($excel);
            $ei = 0;
            if(count($personalData) > 0) {
                $excel->setActiveSheetIndex($ei);
                $excel->getActiveSheet()->setTitle('Personal Details');
                $excel->getActiveSheet()->setCellValue('A1', 'ID');
                $excel->getActiveSheet()->setCellValue('B1', 'First name');
                $excel->getActiveSheet()->setCellValue('C1', 'Surname');
                $excel->getActiveSheet()->setCellValue('D1', 'Home Telephone');
                $excel->getActiveSheet()->setCellValue('E1', 'Mobile Telephone');
                $excel->getActiveSheet()->setCellValue('F1', 'Email Address');
                $excel->getActiveSheet()->setCellValue('G1', 'Line 1');
                $excel->getActiveSheet()->setCellValue('H1', 'Line 2');
                $excel->getActiveSheet()->setCellValue('I1', 'Line 3');
                $excel->getActiveSheet()->setCellValue('J1', 'Town or City');
                $excel->getActiveSheet()->setCellValue('K1', 'County');
                $excel->getActiveSheet()->setCellValue('L1', 'Postcode');
                $c = 2;
                foreach ($personalData as $person) {
                    $i = 1;
                    foreach ($person as $p) {
                        $excel->getActiveSheet()->setCellValue($excelUtil->numbertoLetter($i) . $c, $p);
                        $i++;
                    }
                    $c++;
                }
                $ei++;
            }
            if(count($testResults) > 0) {
                $excel->createSheet();
                $excel->setActiveSheetIndex($ei);
                $excel->getActiveSheet()->setTitle('Test Results');
                $excel->getActiveSheet()->setCellValue('A1', 'Job Title');
                $excel->getActiveSheet()->setCellValue('B1', 'First Name');
                $excel->getActiveSheet()->setCellValue('C1', 'Surname');
                $excel->getActiveSheet()->setCellValue('D1', 'Test Name');
                $excel->getActiveSheet()->setCellValue('E1', 'Points Scored');
                $excel->getActiveSheet()->setCellValue('F1', 'Points Available');
                $excel->getActiveSheet()->setCellValue('G1', 'Time Started');
                $excel->getActiveSheet()->setCellValue('H1', 'Time Finished');
                $excel->getActiveSheet()->setCellValue('I1', 'Duration');
                $i = 2;
                foreach ($testResults as $t) {
                    $excel->getActiveSheet()->setCellValue('A' . $i, $t['title']);
                    $excel->getActiveSheet()->setCellValue('B' . $i, $t['firstname']);
                    $excel->getActiveSheet()->setCellValue('C' . $i, $t['surname']);
                    $excel->getActiveSheet()->setCellValue('D' . $i, $t['link_name']);
                    $excel->getActiveSheet()->setCellValue('E' . $i, $t['points_scored']);
                    $excel->getActiveSheet()->setCellValue('F' . $i, $t['points_available']);
                    $excel->getActiveSheet()->setCellValue('G' . $i, $t['time_started']);
                    $excel->getActiveSheet()->setCellValue('H' . $i, $t['time_finished']);
                    $excel->getActiveSheet()->setCellValue('I' . $i, $t['duration']);
                    $i++;
                }
                $ei++;
            }

            if(count($educationhistory) > 0) {
                $excel->createSheet();
                $excel->setActiveSheetIndex($ei);
                $excel->getActiveSheet()->setTitle('Education History');
                $excel->getActiveSheet()->setCellValue('A1', 'User ID');
                $excel->getActiveSheet()->setCellValue('B1', 'First Name');
                $excel->getActiveSheet()->setCellValue('C1', 'Surname');
                $excel->getActiveSheet()->setCellValue('D1', 'Job Title');
                $excel->getActiveSheet()->setCellValue('E1', 'Establishment');
                $excel->getActiveSheet()->setCellValue('F1', 'Course');
                $excel->getActiveSheet()->setCellValue('G1', 'Start Date');
                $excel->getActiveSheet()->setCellValue('H1', 'End Date');
                $i = 2;
                foreach ($educationhistory as $e) {
                    $excel->getActiveSheet()->setCellValue('A' . $i, $e['id']);
                    $excel->getActiveSheet()->setCellValue('B' . $i, $e['firstname']);
                    $excel->getActiveSheet()->setCellValue('C' . $i, $e['surname']);
                    $excel->getActiveSheet()->setCellValue('D' . $i, $e['title']);
                    $excel->getActiveSheet()->setCellValue('E' . $i, $e['establishment']);
                    $excel->getActiveSheet()->setCellValue('F' . $i, $e['courseTitle']);
                    $excel->getActiveSheet()->setCellValue('G' . $i, $e['startdate']);
                    $excel->getActiveSheet()->setCellValue('H' . $i, $e['enddate']);
                    $i++;
                }
                $ei++;
            }
            if(count($employmenthistory) > 0) {
                $excel->createSheet();
                $excel->setActiveSheetIndex($ei);
                $excel->getActiveSheet()->setTitle('Employment History');
                $excel->getActiveSheet()->setCellValue('A1', 'User ID');
                $excel->getActiveSheet()->setCellValue('B1', 'First Name');
                $excel->getActiveSheet()->setCellValue('C1', 'Surname');
                $excel->getActiveSheet()->setCellValue('D1', 'Applied for Job Title');
                $excel->getActiveSheet()->setCellValue('E1', 'Historic Job Title');
                $excel->getActiveSheet()->setCellValue('F1', 'Job Description');
                $excel->getActiveSheet()->setCellValue('G1', 'Start Date');
                $excel->getActiveSheet()->setCellValue('H1', 'End Date');
                $i = 2;
                foreach ($employmenthistory as $e) {
                    $excel->getActiveSheet()->setCellValue('A' . $i, $e['id']);
                    $excel->getActiveSheet()->setCellValue('B' . $i, $e['firstname']);
                    $excel->getActiveSheet()->setCellValue('C' . $i, $e['surname']);
                    $excel->getActiveSheet()->setCellValue('D' . $i, $e['title']);
                    $excel->getActiveSheet()->setCellValue('E' . $i, $e['old_title']);
                    $excel->getActiveSheet()->setCellValue('F' . $i, $e['description']);
                    $excel->getActiveSheet()->setCellValue('G' . $i, $e['startdate']);
                    $excel->getActiveSheet()->setCellValue('H' . $i, $e['enddate']);
                    $i++;
                }
                $ei++;
            }
            if(count($prescreen) > 0) {
                $excel->createSheet();
                $excel->setActiveSheetIndex($ei);
                $excel->getActiveSheet()->setTitle('Pre Screen Data');
                $excel->getActiveSheet()->setCellValue('A1', 'User ID');
                $excel->getActiveSheet()->setCellValue('B1', 'First Name');
                $excel->getActiveSheet()->setCellValue('C1', 'Surname');
                $excel->getActiveSheet()->setCellValue('D1', 'Job Title');
                $excel->getActiveSheet()->setCellValue('E1', 'Java Development Experience');
                $excel->getActiveSheet()->setCellValue('F1', 'Low Latency Experience');
                $excel->getActiveSheet()->setCellValue('G1', 'Lock Free Algorithms Experience');
                $excel->getActiveSheet()->setCellValue('H1', 'Linear Algebra Experience');
                $excel->getActiveSheet()->setCellValue('I1', 'Telemetry Systems Experience');
                $excel->getActiveSheet()->setCellValue('J1', 'C/C++ Experience');
                $excel->getActiveSheet()->setCellValue('K1', 'Database Experience (SQL)');
                $i = 2;
                foreach ($prescreen as $p) {
                    $excel->getActiveSheet()->setCellValue('A' . $i, $p['id']);
                    $excel->getActiveSheet()->setCellValue('B' . $i, $p['firstname']);
                    $excel->getActiveSheet()->setCellValue('C' . $i, $p['surname']);
                    $excel->getActiveSheet()->setCellValue('D' . $i, $p['title']);
                    $excel->getActiveSheet()->setCellValue('E' . $i, $p['java_development_experience']);
                    $excel->getActiveSheet()->setCellValue('F' . $i, $p['low_latency_experience']);
                    $excel->getActiveSheet()->setCellValue('G' . $i, $p['lock_free_algorithms_experience']);
                    $excel->getActiveSheet()->setCellValue('H' . $i, $p['linear_algebra_experience']);
                    $excel->getActiveSheet()->setCellValue('I' . $i, $p['telemetry_systems_experience']);
                    $excel->getActiveSheet()->setCellValue('J' . $i, $p['cexperience']);
                    $excel->getActiveSheet()->setCellValue('K' . $i, $p['database_experience']);
                    $i++;
                }
                $ei++;
            }
            if(count($interviews) > 0) {
                $excel->createSheet();
                $excel->setActiveSheetIndex($ei);
                $excel->getActiveSheet()->setTitle('Interview Status');
                $excel->getActiveSheet()->setCellValue('A1', 'User ID');
                $excel->getActiveSheet()->setCellValue('B1', 'First Name');
                $excel->getActiveSheet()->setCellValue('C1', 'Surname');
                $excel->getActiveSheet()->setCellValue('D1', 'Job Title');
                $excel->getActiveSheet()->setCellValue('E1', 'Location');
                $excel->getActiveSheet()->setCellValue('F1', 'Interview Date');
                $excel->getActiveSheet()->setCellValue('G1', 'Accepted');
                $excel->getActiveSheet()->setCellValue('H1', 'Accepted On');
                $excel->getActiveSheet()->setCellValue('I1', 'Rejected');
                $excel->getActiveSheet()->setCellValue('J1', 'Rejected On');
                $excel->getActiveSheet()->setCellValue('K1', 'Rejection Reason');
                $i = 2;
                foreach ($interviews as $in) {
                    $excel->getActiveSheet()->setCellValue('A' . $i, $in['id']);
                    $excel->getActiveSheet()->setCellValue('B' . $i, $in['firstname']);
                    $excel->getActiveSheet()->setCellValue('C' . $i, $in['surname']);
                    $excel->getActiveSheet()->setCellValue('D' . $i, $in['title']);
                    $excel->getActiveSheet()->setCellValue('E' . $i, $in['location']);
                    $excel->getActiveSheet()->setCellValue('F' . $i, $in['interviewDate']);
                    $excel->getActiveSheet()->setCellValue('G' . $i, $in['accepted']);
                    $excel->getActiveSheet()->setCellValue('H' . $i, $in['acceptedOn']);
                    $excel->getActiveSheet()->setCellValue('I' . $i, $in['rejected']);
                    $excel->getActiveSheet()->setCellValue('J' . $i, $in['rejectedOn']);
                    $excel->getActiveSheet()->setCellValue('K' . $i, $in['rejectReason']);
                    $i++;
                }
                $ei++;
            }
            if(count($references) > 0) {
                $excel->createSheet();
                $excel->setActiveSheetIndex($ei);
                $excel->getActiveSheet()->setTitle('References');
                $excel->getActiveSheet()->setCellValue('A1', 'User ID');
                $excel->getActiveSheet()->setCellValue('B1', 'First Name');
                $excel->getActiveSheet()->setCellValue('C1', 'Surname');
                $excel->getActiveSheet()->setCellValue('D1', 'Job Title');
                $excel->getActiveSheet()->setCellValue('E1', 'Company');
                $excel->getActiveSheet()->setCellValue('F1', 'Name');
                $excel->getActiveSheet()->setCellValue('G1', 'Email');
                $i = 2;
                foreach ($references as $r) {
                    $excel->getActiveSheet()->setCellValue('A' . $i, $r['id']);
                    $excel->getActiveSheet()->setCellValue('B' . $i, $r['firstname']);
                    $excel->getActiveSheet()->setCellValue('C' . $i, $r['surname']);
                    $excel->getActiveSheet()->setCellValue('D' . $i, $r['title']);
                    $excel->getActiveSheet()->setCellValue('E' . $i, $r['company']);
                    $excel->getActiveSheet()->setCellValue('F' . $i, $r['name']);
                    $excel->getActiveSheet()->setCellValue('G' . $i, $r['email']);
                    $i++;
                }
            }
            $excel->setActiveSheetIndex(0);
            header('Content-Type: application/vnd.ms-excel');
            if($user_id > 0){
                header('Content-Disposition: attachment;filename="' . $personalData[0]['firstname'] . '_' . $personalData[0]['surname'] . '_' . $personalData[0]['id'] . '.xls"');
            } else {
                header('Content-Disposition: attachment;filename="allusers'.date('dmyhis').'.xls"');
            }
            header('Cache-Control: max-age=0');
            $writer->save('php://output');
            exit;
        }else {
            $message = rawurlencode('Access Denied.');
            header('location: /login/index/emessage/'.$message);
            exit;
        }
    }

    /**
     * @Security("has_role('ROLE_MASTER_CLIENT') or has_role('ROLE_ADMIN')")
     * @Route("/user/idchecks/{id}", name="id_checks")
     */
    public function idchecksAction(Request $request, $id)
    {
        dump('t');

        /*$gbgform = new Zend_Session_Namespace('gbgform');
        if(!is_null($gbgform->successMessage)){
            $this->view->successMessage = $gbgform->successMessage;
        }
        if(!is_null($gbgform->errors)){
            $this->view->message = $gbgform->errors;
        }
        $this->_helper->layout->setLayout('layout-noprogress');
        $idChecksModel = new Model_idChecks();
        $userModel = new Model_User();
        $uniqueId = $this->getRequest()->getParam('id');
        $this->view->uniqueid = $uniqueId;
        $details = $idChecksModel->getIdCheckByUniqueId($uniqueId);
        $this->view->loggedin = !is_null($this->userData);
        Zend_Session::namespaceUnset('gbgform');
        if(!empty($details)){
            $this->view->idDetails = $details;
            $this->view->user = $userModel->getUserById($details[0]["user_id"]);
            $this->view->userAddress = $userModel->getUserAddressyUserId ($details[0]["user_id"]);
            if(!is_null($details[0]['authenticated'])){
                $this->view->imgData = ['extracted_data' => $details[0]["extracted_data"],
                    'document_type' => $details[0]['document_type'],
                    'document_number' => $details[0]['document_number']];
            } else {
                $this->view->imgData = [];
            }
        }else{
            $redirect = new Zend_Session_Namespace('redirect');
            $redirect->uri = $_SERVER['REQUEST_URI'];
            header('location: /login');
            exit;
        }*/

        return $this->render('@App/user/userIdCheck.html.twig', array(

        ));
    }
}
