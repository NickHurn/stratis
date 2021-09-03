<?php
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;


/**
 * IndexController is the default controller for this application
 *
 * Notice that we do not have to require 'Zend/Controller/Action.php', this
 * is because our application is using "autoloading" in the bootstrap.
 *
 * @see http://framework.zend.com/manual/en/zend.loader.html#zend.loader.load.autoload
 */
class UserController extends Hireabl_Controller_Action
{

    public $params;
    public $denied = true;
    public $userData;
    /**
     * @var $registerModel Model_Register
     */
    public $registerModel;

    public function init()
    {
        $this->params = $this->getRequest()->getParams();
        $auth = Zend_Auth::getInstance();
        $this->userData = $auth->getIdentity();
        if(!is_null($this->userData)) {
            $this->denied = false;
        }
        parent::init();
    }

    public function indexAction()
    {
        $registerModel = new Model_Register();
        $this->_helper->layout->setLayout('layout-noprogress');
        $this->view->section = "User";
        $this->user = new Model_User();

        if (is_null($this->userData)) {
            $redirect = new Zend_Session_Namespace('redirect');
            $redirect->uri = $_SERVER['REQUEST_URI'];
            header('location: /login');
            exit;
        } else {

            $this->view->headScript()->appendFile('/js/register.js');

            // Stuff to do as employer
            if (!is_null($this->userData->employer_id)) {
                $this->_helper->layout->setLayout('adminmenu');
                $this->_helper->viewRenderer('indexadmin');
                $this->view->admin = true;
                if (isset($this->params['id'])) {
                    $usersData = $this->user->getUserById($this->params['id']);
                    if ($this->userData->employer_id != $usersData['employer_id']) {
                        $message = rawurlencode('You do not have the correct access. Please login with an account that has the correct access');
                        header('location: /login/index/emessage/' . $message);
                        exit;
                    }
                    $this->view->userData = (object) $usersData;
                    if (!is_null($this->userData->master_user_id) || $this->userData->id == $this->view->userData->id) {
                        if ($this->getRequest()->isPost()) {
                            if ($registerModel->isValid($this->params, true)) {
                                $this->user->updateUser($this->params, $this->view->userData->id);
                                header ('location: /staff');
                                exit;
                            }
                        }
                    }
                } else {
                    header('location: /staff');
                    exit;
                }
                //stuff to do as applicant
            }else {
                if ($this->getRequest()->isPost()) {
                    if ($registerModel->isValid($this->params, true)) {
                        $this->user->updateUser($this->params, $this->userData->id);
                    }
                }
                $this->view->fullUser = $this->user->getUserById($this->userData->id);
            }
        }
    }

    public function updateAction()
    {
        $this->_helper->layout->disableLayout();
        $user = new Model_User();
        $register = new Model_Register();
        if (is_null($this->userData)) {
            header('location: /login');
            exit;
        } else {
            if ($register->isValid($this->params, true)) {
                $user->updateUser($this->params, $this->userData->id);
                $contactUpdated = new Zend_Session_Namespace('contactUpdated');
                $contactUpdated->message = 'ok';
                echo 'ok';
            } else {
                echo 'error';
            }
            exit;
        }


    }
    /**
     * @Security("has_role('ROLE_MASTER_CLIENT') or has_role('ROLE_ADMIN')")
     * @Route("/user/generateexcel/{userId}/{employerJobId}", name="generate_excel")
     */
    public function generateexcelAction(Request $request, $userId, $employerJobId)
    {
        if($this->denied == true){
            header('location: /login');
            exit;
        }

        if(!is_null($employerJobId)) {

            $user_id = filter_var((int) $userId, FILTER_SANITIZE_NUMBER_INT);
            $employer_id = $this->userData->employer_id;

            $userModel = new Model_User();
            $testablModel = new Model_Testabl();
            $excelUtil = new Model_Excel();
            $excel = new PHPExcel();

            $personalData = $userModel->getAllUserData($employer_id,$user_id);
            $testResults = $testablModel->getUsersTestResults($user_id, $employer_id);
            $educationhistory = $excelUtil->getEducationHistory($user_id, $employer_id);
            $employmenthistory = $excelUtil->getEmploymentHistory($user_id, $employer_id);
            $interviews = $excelUtil->getInterviewDetails($user_id, $employer_id);
            $references = $excelUtil->getReferences($user_id, $employer_id);
            $prescreen = $excelUtil->getPreScreenDetails($user_id, $employer_id);

            if(count($personalData) > 0) {

                $ei = 0;

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
                    $excel->getActiveSheet()->setCellValue('F' . $i, $e['course']);
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
                    $excel->getActiveSheet()->setCellValue('F' . $i, $in['interview_date']);
                    $excel->getActiveSheet()->setCellValue('G' . $i, $in['accepted']);
                    $excel->getActiveSheet()->setCellValue('H' . $i, $in['accepted_on']);
                    $excel->getActiveSheet()->setCellValue('I' . $i, $in['rejected']);
                    $excel->getActiveSheet()->setCellValue('J' . $i, $in['rejected_on']);
                    $excel->getActiveSheet()->setCellValue('K' . $i, $in['reject_reason']);
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
            $objWriter = PHPExcel_IOFactory::createWriter($excel, 'Excel5');
            $objWriter->save('php://output');
            exit;
        } else {
            $message = rawurlencode('Access Denied.');
            header('location: /login/index/emessage/'.$message);
            exit;
        }


    }

    public function idchecksAction()
    {

        $gbgform = new Zend_Session_Namespace('gbgform');
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
        }



    }

    public function processimageAction(){

        $verifyToken = md5('unique_salt' . $_POST['timestamp']);
        $idChecksModel = new Model_idChecks();
        if(isset($this->params['token']) && $verifyToken == $this->params['token'] ){
            if(isset($_FILES) && isset($this->params['uniqueid']))
            {
                $filedata = $idChecksModel->saveUserCheckUploads($_FILES);
                $mainImage = new Hireabl_Image_Image();
                $max_size = 1500;
                $thumb_size = 600;
                $mainImage->set_img(APPLICATION_PATH.'/documents/idUploads/'.$filedata['storedname']);
                $mainImage->set_size($max_size);
                $mainImage->save_img(APPLICATION_PATH.'/documents/idUploads/'.$filedata['storedname']);

                $mainImage->set_img(APPLICATION_PATH.'/documents/idUploads/'.$filedata['storedname']);
                $mainImage->set_size($thumb_size);
                $mainImage->save_img(APPLICATION_PATH.'/documents/idUploads/thumbs/'.$filedata['storedname']);

                echo json_encode(array("uploads" => 1, "id" => 0, "filedata" => $filedata, 'uniqueid' => $this->params['uniqueid']));
                exit;
            } else {
                echo json_encode(array("uploads" => 0, "id" => 0, "filedata" => null, 'uniqueid' => null));
                exit;
            }
        }
    }

    public function downloadAction()
    {
        $filename = urldecode($this->getRequest()->getParam('filename'));
        $mimeType = urldecode($this->getRequest()->getParam('mime'));

        header('Content-Description: File Transfer');
        header('Content-Type: '.$mimeType);
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize(APPLICATION_PATH.'/documents/idUploads/thumbs/'.$filename));
        readfile(APPLICATION_PATH.'/documents/idUploads/thumbs/'.$filename);
        exit;

    }
}
