<?php

namespace AppBundle\Model;

use AppBundle\Entity\ApplicantShare;
use AppBundle\Entity\Users;
use AppBundle\Entity\UsersJob;
use AppBundle\Entity\UsersJobsRepository;
use AppBundle\Form\ApplicantViewDateFilters;
use AppBundle\Form\ChoicesFilter;
use AppBundle\Form\DateRangeFilter;
use Doctrine\ORM\EntityManager;
use FormBundle\Factory\FormFactory;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\DependencyInjection\Container;

class FilterFactory extends Controller{

    /**
     * @var EntityManager
     */

    private $em;
    /**
     * @var $toDate \DateTime
     */
    private $toDate;

    /**
     * @var $fromDate \DateTime
     */
    private $fromDate;

    /**
     * @var $jobId string
     */
    private $jobId;

    /**
     * @var $client Users
     */
    private $client;

    /**
     * @var $usersJobsRepository UsersJobsRepository
     */
    private $usersJobsRepository;

    /**
     * @var $progress Progress
     */
    private $progress;

    /**
     * @var $formFactory FormFactory
     */
    private $formFactory;


    /**
     * @var $checkablLower integer
     */
    private $checkablLower;

    /**
     * @var $checkablUpper integer
     */
    private $checkablUpper;

    /**
     * @var $testablLower integer
     */
    private $testablLower;

    /**
     * @var $testablUpper integer
     */
    private $testablUpper;

    /**
     * @var $personablLower integer
     */
    private $personablLower;

    /**
     * @var $personablUpper integer
     */
    private $personablUpper;

    /**
     * @var $idCheck string
     */
    private $idCheck;

    /**
     * @var $dbs string
     */
    private $dbs;

    /**
     * @var $dbs string
     */
    private $kyc;

    /**
     * @var $qualifications string
     */
    protected $qualifications;

    /**
     * @var $ref string
     */
    protected $ref;

    /**
     * @var $interview string
     */
    protected $interview;

    /**
     * @var $employerId int
     */
    private $employerId;

    /**
     * @var $applicantStatus string
     */
    private $applicantStatus;

    /**
     * @var $watchStatus string
     */
    private $watchStatus;


    /**
     * @var $avgRating int
     */
    private $avgRating;

    /**
     * @var $container Container
     */
    protected $container;

    /**
     * FilterFactory constructor.
     * @param $em
     */
    public function __construct($em, TokenStorage $tokenStorage, Progress $progress, $formFactory, $container)
    {
        $this->em = $em;
        $this->client = $tokenStorage->getToken()->getUser();
        $this->usersJobsRepository = $this->em->getRepository('AppBundle:UsersJob');
        $this->usersJobsRepository->setClient($this->client);
        $this->progress = $progress;
        $this->formFactory = $formFactory;
        $this->container = $container;
    }

    /**
     * @return EntityManager
     */
    public function getEm()
    {
        return $this->em;
    }

    /**
     * @param EntityManager $em
     * @return FilterFactory
     */
    public function setEm($em)
    {
        $this->em = $em;
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getToDate()
    {
        return $this->toDate;
    }

    /**
     * @param \DateTime $toDate
     * @return FilterFactory
     */
    public function setToDate($toDate)
    {
        $this->toDate = $toDate;
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getFromDate()
    {
        return $this->fromDate;
    }

    /**
     * @param \DateTime $fromDate
     * @return FilterFactory
     */
    public function setFromDate($fromDate)
    {
        $this->fromDate = $fromDate;
        return $this;
    }

    /**
     * @return string
     */
    public function getJobId()
    {
        return $this->jobId;
    }

    /**
     * @param string $jobId
     * @return FilterFactory
     */
    public function setJobId($jobId)
    {
        $this->jobId = $jobId;
        return $this;
    }

    /**
     * @return int
     */
    public function getCheckablLower()
    {
        return $this->checkablLower;
    }

    /**
     * @param int $checkablLower
     * @return FilterFactory
     */
    public function setCheckablLower($checkablLower)
    {
        $this->checkablLower = $checkablLower;
        return $this;
    }

    /**
     * @return int
     */
    public function getCheckablUpper()
    {
        return $this->checkablUpper;
    }

    /**
     * @param int $checkablUpper
     * @return FilterFactory
     */
    public function setCheckablUpper($checkablUpper)
    {
        $this->checkablUpper = $checkablUpper;
        return $this;
    }

    /**
     * @return int
     */
    public function getTestablLower()
    {
        return $this->testablLower;
    }

    /**
     * @param int $testablLower
     * @return FilterFactory
     */
    public function setTestablLower($testablLower)
    {
        $this->testablLower = $testablLower;
        return $this;
    }

    /**
     * @return int
     */
    public function getTestablUpper()
    {
        return $this->testablUpper;
    }

    /**
     * @param int $testablUpper
     * @return FilterFactory
     */
    public function setTestablUpper($testablUpper)
    {
        $this->testablUpper = $testablUpper;
        return $this;
    }

    /**
     * @return int
     */
    public function getPersonablLower()
    {
        return $this->personablLower;
    }

    /**
     * @param int $personablLower
     * @return FilterFactory
     */
    public function setPersonablLower($personablLower)
    {
        $this->personablLower = $personablLower;
        return $this;
    }

    /**
     * @return int
     */
    public function getPersonablUpper()
    {
        return $this->personablUpper;
    }

    /**
     * @param int $personablUpper
     * @return FilterFactory
     */
    public function setPersonablUpper($personablUpper)
    {
        $this->personablUpper = $personablUpper;
        return $this;
    }

    /**
     * @return idCheck
     */
    public function getIdCheck()
    {
        return $this->idCheck;
    }

    /**
     * @param idCheck $idCheck
     * @return FilterFactory
     */
    public function setIdCheck($idCheck)
    {
        $this->idCheck = $idCheck;
        return $this;
    }

    /**
     * @return string
     */
    public function getDbs()
    {
        return $this->dbs;
    }

    /**
     * @param string $dbs
     * @return FilterFactory
     */
    public function setDbs($dbs)
    {
        $this->dbs = $dbs;
        return $this;
    }

    /**
     * @return string
     */
    public function getKyc()
    {
        return $this->kyc;
    }

    /**
     * @param string $kyc
     * @return FilterFactory
     */
    public function setKyc($kyc)
    {
        $this->kyc = $kyc;
        return $this;
    }


    /**
     * @return Container
     */
    public function getQualifications()
    {
        return $this->qualifications;
    }

    /**
     * @param Container $qualifications
     * @return FilterFactory
     */
    public function setQualifications($qualifications)
    {
        $this->qualifications = $qualifications;
        return $this;
    }

    /**
     * @return Container
     */
    public function getRef()
    {
        return $this->ref;
    }

    /**
     * @param Container $ref
     * @return FilterFactory
     */
    public function setRef($ref)
    {
        $this->ref = $ref;
        return $this;
    }

    /**
     * @return string
     */
    public function getInterview()
    {
        return $this->interview;
    }

    /**
     * @param string $interview
     * @return FilterFactory
     */
    public function setInterview($interview)
    {
        $this->interview = $interview;
        return $this;
    }

    /**
     * @return int
     */
    public function getEmployerId()
    {
        return $this->employerId;
    }

    /**
     * @param int $employerId
     * @return FilterFactory
     */
    public function setEmployerId($employerId)
    {
        $this->employerId = $employerId;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getApplicantStatus()
    {
        return $this->applicantStatus;
    }

    /**
     * @param mixed $applicantStatus
     * @return FilterFactory
     */
    public function setApplicantStatus($applicantStatus)
    {
        $this->applicantStatus = $applicantStatus;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getWatchStatus()
    {
        return $this->watchStatus;
    }

    /**
     * @param mixed $watchStatus
     * @return FilterFactory
     */
    public function setWatchStatus($watchStatus)
    {
        $this->watchStatus = $watchStatus;
        return $this;
    }

    /**
     * @return int
     */
    public function getAvgRating()
    {
        return $this->avgRating;
    }

    /**
     * @param int $avgRating
     * @return FilterFactory
     */
    public function setAvgRating($avgRating)
    {
        $this->avgRating = $avgRating;
        return $this;
    }



    public function setUpInitialData($searchTerm = null)
    {

        /**
         * @var $a UsersJob
         */
        if (is_null($this->getJobId()) || $this->getJobId() == ''){
            $applicants = $this->usersJobsRepository->getUsers($this->getFromDate(), $this->getToDate());
        }else {
            $applicants = $this->usersJobsRepository->getUsersByJob($this->getFromDate(), $this->getToDate(), $this->getJobId());
        }

        foreach ($applicants as $key=>$a){
            $applicantShare = new ApplicantShare;
            $applicantShare->setJobId($a['jobUniqueId']);
            $applicantShare->setEmployerId($a['employerId']);
            $applicantShare->setApplicantId($a['applicantId']);
            $applicants[$key]['checkablProgress']=$this->progress->getCheckablProgress($applicantShare);
            $applicants[$key]['testablProgress']=$this->progress->getTestablProgress($applicantShare);
            $applicants[$key]['personablProgress']=$this->progress->getPersonablProgress($applicantShare);
            $interviewStatus = $this->em->getRepository('AppBundle:Interviews')->findOneBy(['userId' => $a['applicantId'], 'jobId'=>$a['jobUniqueId']],['id' => 'desc']);
            $applicants[$key]['interview'] = (!is_null($interviewStatus) ? $interviewStatus->getStatus() : 'Not Requested');
            $applicants[$key]['idChecks'] = $this->progress->getIdCheckStatus($applicantShare);
            $applicants[$key]['qualChecks'] = $this->progress->getQualStatus($applicantShare);
            $applicants[$key]['disclosureChecks'] = $this->progress->getDisclosureStatus($applicantShare);
            $applicants[$key]['kycChecks'] = $this->progress->getKycStatus($applicantShare);
            $applicants[$key]['referenceChecks'] = $this->progress->getReferenceStatus($applicantShare);
            $applicants[$key]['preScreenPass'] = $this->progress->getPreScreenStatus($applicantShare);
            $applicants[$key]['shared'] = $this->progress->getSharedStatus($a['applicantId'], $a['jobUniqueId'],$a['employerId'] );
            $applicants[$key]['watched'] = $this->progress->getWatchedStatus($a['applicantId'], $a['jobId'],$a['employerId'] );
            $applicants[$key]['rating'] = $this->progress->getRatingStatus($a['applicantId'], $a['jobUniqueId'],$a['employerId'] );
        }

        $applicantsfinalData = $this->createTemporaryTable($applicants);

        return $applicantsfinalData;
    }

    /**
     * @param $fromDate
     * @param $toDate
     * @return \Symfony\Component\Form\Form
     */
    public function getDateRangeForm($fromDate,$toDate, $dateToLabel, $dateFromLabel, $submitLabel)
    {

        $applicantViewDateForm = $this->formFactory->create(DateRangeFilter::class ,array('fromDate'=>$fromDate, 'toDate'=>$toDate), array('method' => 'GET', 'dateFrom'=>$dateFromLabel, 'dateTo'=>$dateToLabel, 'submitLabel'=>$submitLabel) );
        return $applicantViewDateForm;
    }

    /**
     * @return \Symfony\Component\Form\Form
     */
    public function getJobDropDownForm()
    {
        $jobListElements=$this->getJobListDataForChoicesForm();
        $applicantViewDateForm = $this->formFactory->create(ChoicesFilter::class ,$jobListElements, array('name'=>'jobList', 'label'=>'Job List', 'placeholder'=>'All') );
        return $applicantViewDateForm;
    }

    /**
     * @return \Symfony\Component\Form\Form
     */
    public function getCheckablDropDownForm()
    {
        $CheckablElements=['0-10%,'=>'0,10','11-20%'=>'11,20','21-30%'=>'21,30','31-40%'=>'31,40','41-50%'=>'41,50','51-60%'=>'51,60','61-70%'=>'61,70','71-80%'=>'71,80','81-90%'=>'81,90','91-100%'=>'91,100'];
        $data=[];
        foreach ($CheckablElements as $key=>$ce) {
            $data['choices'][$key]=$ce;
        }
        $checkableForm = $this->formFactory->create(ChoicesFilter::class ,$data, array('name'=>'checkabl', 'label'=>'Checkabl % Range', 'placeholder'=>'All') );
        return $checkableForm;
    }

    /**
     * @return \Symfony\Component\Form\Form
     */
    public function getTestablDropDownForm()
    {
        $TestablElements=['0-10%,'=>'0,10','11-20%'=>'11,20','21-30%'=>'21,30','31-40%'=>'31,40','41-50%'=>'41,50','51-60%'=>'51,60','61-70%'=>'61,70','71-80%'=>'71,80','81-90%'=>'81,90','91-100%'=>'91,100'];
        $data=[];
        foreach ($TestablElements as $key=>$ce) {
            $data['choices'][$key]=$ce;
        }
        $testableForm = $this->formFactory->create(ChoicesFilter::class ,$data, array('name'=>'testabl', 'label'=>'Testabl % Range', 'placeholder'=>'All') );
        return $testableForm;
    }

    /**
     * @return \Symfony\Component\Form\Form
     */
    public function getPersonablDropDownForm()
    {
        $PersonablElements=['0-10%,'=>'0,10','11-20%'=>'11,20','21-30%'=>'21,30','31-40%'=>'31,40','41-50%'=>'41,50','51-60%'=>'51,60','61-70%'=>'61,70','71-80%'=>'71,80','81-90%'=>'81,90','91-100%'=>'91,100'];
        $data=[];
        foreach ($PersonablElements as $key=>$ce) {
            $data['choices'][$key]=$ce;
        }
        $personableForm = $this->formFactory->create(ChoicesFilter::class ,$data, array('name'=>'personabl', 'label'=>'Personabl % Range', 'placeholder'=>'All') );
        return $personableForm;
    }

    /**
     * @return \Symfony\Component\Form\Form
     */
    public function getIdcheckDropDownForm()
    {
        $idCheckElements=$this->getIdcheckListDataForChoicesForm();
        $applicantViewDateForm = $this->formFactory->create(ChoicesFilter::class ,$idCheckElements, array('name'=>'idCheck', 'label'=>'ID Checks', 'placeholder'=>'All') );
        return $applicantViewDateForm;
    }

    /**
     * @return \Symfony\Component\Form\Form
     */
    public function getDbsDropDownForm()
    {
        $dbsElements=$this->getDbsListDataForChoicesForm();
        $applicantViewDateForm = $this->formFactory->create(ChoicesFilter::class ,$dbsElements, array('name'=>'dbs', 'label'=>'DBS Checks', 'placeholder'=>'All') );
        return $applicantViewDateForm;
    }

    /**
     * @return \Symfony\Component\Form\Form
     */
    public function getQualificationssDropDownForm()
    {
        $qualificationsElements=$this->getQualificationsListDataForChoicesForm();
        $applicantViewDateForm = $this->formFactory->create(ChoicesFilter::class ,$qualificationsElements, array('name'=>'qualifications', 'label'=>'Qualifications Checks', 'placeholder'=>'All') );
        return $applicantViewDateForm;
    }

    /**
     * @return \Symfony\Component\Form\Form
     */
    public function getRefDropDownForm()
    {
        $refElements=$this->getRefListDataForChoicesForm();
        $applicantViewDateForm = $this->formFactory->create(ChoicesFilter::class ,$refElements, array('name'=>'ref', 'label'=>'Reference Checks', 'placeholder'=>'All') );
        return $applicantViewDateForm;
    }

    /**
     * @return \Symfony\Component\Form\Form
     */
    public function getInterviewDropDownForm()
    {
        $Elements=$this->geInterviewListDataForChoicesForm();
        $applicantViewDateForm = $this->formFactory->create(ChoicesFilter::class ,$Elements, array('name'=>'interview', 'label'=>'Interview Checks', 'placeholder'=>'All') );
        return $applicantViewDateForm;
    }

    /**
     * @return \Symfony\Component\Form\Form
     */
    public function getPreScreenDropDownForm()
    {
        $Elements=$this->getPreScreenListDataForChoicesForm();
        $applicantViewDateForm = $this->formFactory->create(ChoicesFilter::class ,$Elements, array('name'=>'preScreen', 'label'=>'Pre Screen Checks', 'placeholder'=>'All') );
        return $applicantViewDateForm;
    }

    /**
 * @return \Symfony\Component\Form\Form
 */
    public function getApplicantStatusForm()
    {
        $Elements['choices'] = ['Accepted' => 'Accepted', 'In Progress' => 'Outstanding', 'Rejected' => 'Rejected', 'Shared' => 'Shared'];
        $applicantStatusForm = $this->formFactory->create(ChoicesFilter::class ,$Elements, array('name'=>'applicantStatus', 'label'=>'Applicant Status', 'placeholder'=>'All') );
        return $applicantStatusForm;
    }

    /**
     * @return \Symfony\Component\Form\Form
     */
    public function getWatchStatusForm()
    {
        $Elements['choices'] = ['Watched' => 'Watched', 'Not Watching' => 'Not Watching'];
        $watchStatusForm = $this->formFactory->create(ChoicesFilter::class ,$Elements, array('name'=>'watchStatus', 'label'=>'Watch Status', 'placeholder'=>'All') );
        return $watchStatusForm;
    }

    /**
     * @return \Symfony\Component\Form\Form
     */
    public function getAvgRatingForm($user)
    {
        $Elements=$this->getAvgRatingDataForChoicesForm($user);

        $applicantViewDateForm = $this->formFactory->create(ChoicesFilter::class ,$Elements, array('name'=>'avgRating', 'label'=>'Average Rating', 'placeholder'=>'All') );
        return $applicantViewDateForm;
    }



    public function getJobListDataForChoicesForm()
    {
        $sql = "select job_id, title 
                from applicant_view
                GROUP BY job_id, title ";
        $stmt = $this->em->getConnection()->prepare($sql);
        $stmt->execute();
        $result =  $stmt->fetchAll();
        if(empty($result)){
            $data['choices']['NoJobs'] = 0;
        }
        foreach ($result as $key=>$r) {
            $data['choices'][$r['title']]=$r['job_id'];
        }
        return $data;
    }

    public function getIdcheckListDataForChoicesForm()
    {
        $sql = "select id_checks 
                from applicant_view
                GROUP BY id_checks ";
        $stmt = $this->em->getConnection()->prepare($sql);
        $stmt->execute();
        $result =  $stmt->fetchAll();

        if(empty($result)){
            $data['choices']['NoJobs'] = 0;
        }

        foreach ($result as $key=>$r) {
            $data['choices'][$r['id_checks']]=$r['id_checks'];
        }
        return $data;
    }

    public function getDbsListDataForChoicesForm()
    {
        $sql = "select disclosure_checks 
                from applicant_view
                GROUP BY disclosure_checks ";
        $stmt = $this->em->getConnection()->prepare($sql);
        $stmt->execute();
        $result =  $stmt->fetchAll();
         if(empty($result)){
            $data['choices']['NoJobs'] = 0;
        }
        foreach ($result as $key=>$r) {
            $data['choices'][$r['disclosure_checks']]=$r['disclosure_checks'];
        }
        return $data;
    }

    public function getQualificationsListDataForChoicesForm()
    {
        $sql = "select qual_checks 
                from applicant_view
                GROUP BY qual_checks ";
        $stmt = $this->em->getConnection()->prepare($sql);
        $stmt->execute();
        $result =  $stmt->fetchAll();
        if(empty($result)){
            $data['choices']['NoJobs'] = 0;
        }
        foreach ($result as $key=>$r) {
            $data['choices'][$r['qual_checks']]=$r['qual_checks'];
        }
        return $data;
    }

    public function getRefListDataForChoicesForm()
    {
        $sql = "select reference_checks 
                from applicant_view
                GROUP BY reference_checks ";
        $stmt = $this->em->getConnection()->prepare($sql);
        $stmt->execute();
        $result =  $stmt->fetchAll();
         if(empty($result)){
            $data['choices']['NoJobs'] = 0;
        }
        foreach ($result as $key=>$r) {
            $data['choices'][$r['reference_checks']]=$r['reference_checks'];
        }
        return $data;
    }

    public function geInterviewListDataForChoicesForm()
    {
        $sql = "select interview 
                from applicant_view
                GROUP BY interview ";
        $stmt = $this->em->getConnection()->prepare($sql);
        $stmt->execute();
        $result =  $stmt->fetchAll();
         if(empty($result)){
            $data['choices']['NoJobs'] = 0;
        }
        foreach ($result as $key=>$r) {
            $data['choices'][$r['interview']]=$r['interview'];
        }
        return $data;
    }
    public function getPreScreenListDataForChoicesForm()
    {
        $sql = "select prescreen_pass 
                from applicant_view
                GROUP BY prescreen_pass ";
        $stmt = $this->em->getConnection()->prepare($sql);
        $stmt->execute();
        $result =  $stmt->fetchAll();
         if(empty($result)){
            $data['choices']['NoJobs'] = 0;
        }
        foreach ($result as $key=>$r) {
            $data['choices'][$r['prescreen_pass']]=$r['prescreen_pass'];
        }
        return $data;
    }

    public function getAvgRatingDataForChoicesForm(Users $user)
    {
        $data =[];
        $sql = "select rating 
                from applicant_view
                GROUP BY rating ";
        $stmt = $this->em->getConnection()->prepare($sql);
        $stmt->execute();
        $result =  $stmt->fetchAll();


        if (!empty($result)) {
           foreach ($result as $key => $r) {
               $rating = (float)$r['rating'];

               if ($rating >= 1.0 && $rating < 2.0) {
                   $ratingDescription = 'Unsatisfactory (1)';
               }
               elseif ($rating >= 2.0 && $rating < 3.0) {
                   $ratingDescription = 'Improvement Needed (2)';
               }
               elseif ($rating >= 3.0 && $rating < 4.0) {
                   $ratingDescription = 'Good (3)';
               }
               elseif ($rating >= 4.0 && $rating < 5.0) {
                   $ratingDescription = 'Very Good (4)';
               }
               elseif ($rating >= 5.0) {
                   $ratingDescription = 'Outstanding (5)';
               }
               else  {
                   $ratingDescription = 'Not Rated';
               }

               $data['choices'][$ratingDescription] = $ratingDescription;
           }

        }else{
            $data['choices']['NoJobs'] = 0;
        }

        return $data;
    }


    public function createTemporaryTable($data)
    {
        $result = FALSE;

        $sql = 'CREATE TEMPORARY TABLE `applicant_view` (
                `id` int(11) NOT NULL AUTO_INCREMENT,
                `applicant_id` int(11) NOT NULL,
                `job_id` int(11) NOT NULL,
                `title` varchar(50) Not null,
                `prescreen_pass` varchar(50), 
                `accepted` int(1),
                `offered` int(1),
                `rejected` int(1),
                `firstname`varchar(50) Not null,
                `surname`varchar(50) Not null,
                `job_unique_id`varchar(50) Not null,
                `employer_id` int(11),
                `checkabl_progress` float,
                `testabl_progress` float,
                `personabl_progress` float,
                `interview` varchar(50) ,
                `id_checks` varchar(50) ,
                `qual_checks` varchar(50) ,
                `disclosure_checks` varchar(50) ,
                `kyc_checks` varchar(50) ,
                `reference_checks` varchar(50) ,
                `cv_id` int (11),
                `shared` varchar(50) ,
                `watched` varchar(50) ,
                `rating` float ,
                `created_on` datetime, 
              PRIMARY KEY (`id`)
            ) ENGINE=InnoDB AUTO_INCREMENT=38 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;';
        $statement = $this->em->getConnection()->prepare($sql);
        $statement->execute();

        foreach ($data as $d) {

            $coDate = $d['createdOn']->format('Y-m-d H:i:s');
            $sql = "select id from cv where user_id = ".$d['applicantId']." and job_id ='".$d['jobUniqueId']."'";
            $stmt = $this->em->getConnection()->prepare($sql);
            $stmt->execute();
            $cv =  $stmt->fetchAll();

            if  (empty($cv)){
                $cvId = NULL;

            }else{
                $c = $cv[0] ["id"];
                $cvId = (int)$c;
            }

            $sql = "INSERT INTO applicant_view (applicant_id,job_id,title,prescreen_pass,accepted,offered,rejected,firstname,surname,job_unique_id,employer_id,checkabl_progress,testabl_progress,personabl_progress,interview,id_checks,qual_checks,disclosure_checks,kyc_checks,reference_checks,cv_id,shared,watched,rating,created_on)
                VALUES (
                    ?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?   
                )";
            $stmt = $this->em->getConnection()->prepare($sql);

            $result = $stmt->execute([$d['applicantId'],
                    $d['jobId'],
                    $d['title'],
                    $d['preScreenPass'],
                    $d['accepted'],
                    $d['offered'],
                    $d['rejected'],
                    $d['firstname'],
                    $d['surname'],
                    $d['jobUniqueId'],
                    $d['employerId'],
                    $d['checkablProgress'],
                    $d['testablProgress'],
                    $d['personablProgress'],
                    $d['interview'],
                    $d['idChecks'],
                    $d['qualChecks'],
                    $d['disclosureChecks'],
                    $d['kycChecks'],
                    $d['referenceChecks'],
                    $cvId,
                    $d['shared'],
                    $d['watched'],
                    $d['rating'],
                    $coDate,
                ]);

        }
        return $result;
    }

    public function getData ( $searchTerm)
    {
        $filters=[];
        $sql = "select * from applicant_view";

        if (!is_null($this->getJobId())){
            $filters[]= 'job_id = '.$this->getJobId();
        }
        if (!is_null($this->getCheckablLower()) && !is_null($this->getCheckablUpper())){
            $filters[]= 'checkabl_progress between '.$this->getCheckablLower().' and '.$this->getCheckablUpper();

        }
        if (!is_null($this->getTestablLower()) && !is_null($this->getTestablUpper())){
            $filters[]= 'testabl_progress between '.$this->getTestablLower().' and '.$this->getTestablUpper();
        }
        if (!is_null($this->getIdCheck()) ){
            $filters[]= 'id_checks = "'.$this->getIdCheck().'"';
        }
        if (!is_null($this->getInterview()) ){
            $filters[]= 'interview = "'.$this->getInterview().'"';
        }

        if (!is_null($this->getRef()) ){
            $filters[]= 'reference_checks = "'.$this->getRef().'"';
        }
        if (!is_null($this->getQualifications()) ){
            $filters[]= 'qual_checks = "'.$this->getQualifications().'"';
        }
        if (!is_null($this->getDbs()) ){
            $filters[]= 'disclosure_checks = "'.$this->getDbs().'"';
        }
        if (!is_null($this->getKyc()) ){
            $filters[]= 'kyc_checks = "'.$this->getKyc().'"';
        }
        if (!is_null($this->getApplicantStatus()) ){
            if ($this->getApplicantStatus() == 'Accepted'){
                $filters[]= 'accepted = 1';
            }elseif ($this->getApplicantStatus() == 'Rejected'){
                $filters[]= 'rejected =1';
            }elseif ($this->getApplicantStatus() == 'Shared'){
                $filters[]= 'shared = "'.$this->getApplicantStatus().'"';
            }else{
                $filters[]= 'accepted <> 1 AND rejected <> 1';
            }
        }

        if (!is_null($this->getWatchStatus())){
            $filters[]= 'watched = "'.$this->getWatchStatus().'"';
        }

        if (!is_null($this->getAvgRating())){
            if ($this->getAvgRating() ==  "Outstanding (5)"){
                $filters[]= 'rating >= 5';
            }
            elseif ($this->getAvgRating() ==  "Very Good (4)"){
                $filters[]= 'rating between 4 and 4.999';
            }
            elseif ($this->getAvgRating() ==  "Good (3)"){
                $filters[]= 'rating between 3 and 3.999';
            }
            elseif ($this->getAvgRating() ==  "Improvement Needed (2)"){
                $filters[]= 'rating between 2 and 2.999';
            }
            elseif ($this->getAvgRating() ==  "Unsatisfactory (1)"){
                $filters[]= 'rating between 1 and 1.999';
            }
            else{
                $filters[]= 'rating is null';
            }
        }

        if (!is_null($searchTerm)){
            $filters[]= "(firstname like '".$searchTerm."' or surname like '".$searchTerm."')";
        }

        $filters[]="created_on BETWEEN '".$this->getFromDate()->format('Y-m-d H:i:s')."' AND '".$this->getToDate()->format('Y-m-d H:i:s')."'";
        if (count($filters) === 1){
            $sql .= " WHERE ".$filters[0];
        }
        if (count($filters)>1){
            $sql .= " WHERE ".$filters[0];
            unset ($filters[0]);
            $sql .= " and ".implode(' and ',$filters);
        }

        $stmt = $this->em->getConnection()->prepare($sql);
        $stmt->execute();
        $result2 =  $stmt->fetchAll();
        return $result2;
    }

}
