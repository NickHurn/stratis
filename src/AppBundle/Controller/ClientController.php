<?php

namespace AppBundle\Controller;

use AppBundle\Entity\CheckablFilters;
use AppBundle\Entity\Credit;
use AppBundle\Entity\Cv;
use AppBundle\Entity\CvCheck;
use AppBundle\Entity\Employers;
use AppBundle\Entity\EmployersTests;
use AppBundle\Entity\ExcelTestAllocation;
use AppBundle\Entity\MasterUser;
use AppBundle\Entity\SectionDefaults;
use AppBundle\Entity\SkillsEmployer;
use AppBundle\Entity\SourceByEmployers;
use AppBundle\Entity\TestAllocation;
use AppBundle\Entity\EmployersRepository;
use AppBundle\Entity\Users;
use AppBundle\Form\CheckablOptions;
use AppBundle\Form\CreateClientUser;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Request;

use AppBundle\Model\ClientAdmin;
use AppBundle\Model\UsageReport;
use AppBundle\Form\ClientEditBasic;
use AppBundle\Form\ClientEditWhitelabel;
use AppBundle\Form\ClientEditOptions;
use AppBundle\Form\ClientEditSkills;
use AppBundle\Form\ClientEditTests;
use AppBundle\Form\ClientEditCredits;
use AppBundle\Form\ClientEditActivate;
use AppBundle\Form\ClientEditUsage;


class ClientController extends Controller
{
	/**
     * @Security("has_role('ROLE_ADMIN')")
     * @Route("/admin/client/add", name="admin_client_add")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function addClientAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $this->getUser();
        $form = $this->createForm(CreateClientUser::class, []);

        $form->handleRequest($request);
        $process = $this->validateNewClient($form, $user);
        if($process['user'] === true) {
            $client = $form->getData();

            $employer = new Employers();
            $employer->setCompany($client['companyname']);
            $employer->setWebHookUrl($_SERVER['HTTP_HOST'].'/webhooktest');
            //$employer->setCameratagAppId('not-used-now');
            $em->persist($employer);
            $em->flush();

            $clientRole = $em->getRepository('AppBundle:Role')->findOneBy(['name' => 'ROLE_CLIENT']);
            $masterClientRole = $em->getRepository('AppBundle:Role')->findOneBy(['name' => 'ROLE_MASTER_CLIENT']);

			//  Create a user account for this main account user
            $user = new Users();
            $user->setFirstname($client['firstname']);
            $user->setSurname($client['surname']);
            $user->setMobiletel($client['mobile']);
            $user->setEmailaddress($client['email']);
            $user->setEmployerId($employer->getId());
            $user->setTempPassword(1);
            $user->setRoles($clientRole);
			$user->setRoles($masterClientRole);
            $password = substr(base64_encode(random_bytes(8)),0, -1);
            $user->setPassword($password, $this->get('security.password_encoder'));
            $user->setPlainPassword($password);
            $em->persist($user);
            $em->flush();
			$user_id = $user->getId();


			//  Create an address for the user account
			$ad = $em->getRepository('AppBundle:Address')->findOneBy(['userid'=>$user_id]);
			if(!$ad) { $ad = new \AppBundle\Entity\Address(); }
			$ad->setUserid($user);
			$ad->setLine1($client['address1']);
			$ad->setLine2($client['address2']);
			$ad->setTown($client['town']);
			$ad->setCounty($client['county']);
			$ad->setPostCode($client['postcode']);
			$em->persist($ad);
			$em->flush();
			
			//  Create a master_user record (identifies which user is a master for a given client)
			$masterUser = new MasterUser();
            $masterUser->setEmployerId($employer->getId());
            $masterUser->setUserId($user->getId());
            $em->persist($masterUser);

            $sources = $em->getRepository('AppBundle:Source')->findAll();
            foreach($sources as $source){
                $sbye = new SourceByEmployers();
                $sbye->setEmployerId($employer->getId());
                $sbye->setSourceId($source->getId());
                $em->persist($sbye);
            }

			//  Create section_defaults record
            $sd = new SectionDefaults();
            $sd->setEmployerId($employer->getId());
            $sd->setCheckabl(0);
            $sd->setTestabl(0);
            $sd->setPersonabl(0);
            $sd->setCreatedOn(new \DateTime('now'));
            $em->persist($sd);
            $em->flush();

			//  Create credit record
            $credit = new Credit();
            $credit->setEmployerId($employer->getId());
            $credit->setCredits(0);
            $credit->setCreatedOn(new \DateTime('now'));
            $credit->setModifiedOn(new \DateTime('now'));
            $em->persist($credit);
            $em->flush();
			
			// re-direct to edit screen for the new client
            return $this->redirect("/admin/client/edit/labelling/".$employer->getId());
        }

        return $this->render('@App/client/client.html.twig', [
            'form' => $form->createView(),
        ]);
    }


	//-----------------------------------------------------------
	//  Validate New client
	//-----------------------------------------------------------
	
	public function validateNewClient($form, $user)
	{
        if($form->isSubmitted() && $form->isValid()){
            $process['user'] = true;
        } else {
            $process['user'] = false;
        }

        if($form->isSubmitted()){
            $data = $form->getData();
            if($user->getEmailAddress() == $data['email']){
                $systemError = new FormError("You can not create a new client with your email address");
                $form->get('email')->addError($systemError);
                $process['user'] = false;
            }
        }

        return $process;
    }

	
    /**
     * @Security("has_role('ROLE_ADMIN')")
     * @Route("/admin/client/thanks", name="admin_client_thanks")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function thanksClientAction(Request $request)
    {
        return $this->render('@App/client/client.thanks.html.twig', []);
    }

	
	/**
     * @Security("has_role('ROLE_ADMIN')")
     * @Route("/admin/client/list", name="admin_client_list")
     * @return \Symfony\Component\HttpFoundation\Response
     */
	public function listAction()
    {
		$em = $this->getDoctrine()->getManager();
		$clientadmin = $this->get('app.client_admin');
		
		$x = $em->getRepository('AppBundle:Employers')->getList();
		return $this->render('@App/client/list.html.twig', [
            'recs' => $x,
        ]);
	}


	/**
     * @Security("has_role('ROLE_ADMIN')")
     * @Route("/admin/client/edit/{pg}/{id}", name="admin_client_edit")
     * @return \Symfony\Component\HttpFoundation\Response
     */
	public function editAction(Request $request)
    {
		$pg = $request->get('pg');
		$id = $request->get('id');
		$empRepository = $this->getDoctrine()->getManager()->getRepository('AppBundle:Employers');
	
		$em = $this->getDoctrine()->getManager();
		$clientadmin = $this->get('app.client_admin');

		$client = $em->getRepository('AppBundle:Employers')->findOneBy(['id' => $id]);

		// Build the form for display or validation
		
		switch ($pg) {
			case 'basic':
				$form = $this->createForm(ClientEditBasic::class); 
				$data = $clientadmin->getBasicData($id);
				//print "<pre>"; var_dump($id); die('2');
				break;
			case 'labelling':
				$form = $this->createForm(ClientEditWhitelabel::class); 
				$data = $clientadmin->getWhitelabelData($id);
				break;
			case 'options':		
				$form = $this->createForm(ClientEditOptions::class); 
				$data = $clientadmin->getOptionsData($id);
				break;
			case 'skills':		
				$form = $this->createForm(ClientEditSKills::class);
				$data = $empRepository->getSkillsData($id);
				break;
			case 'tests':		
				$form = $this->createForm(ClientEditTests::class); 
				$data['class'] = $empRepository->getClassmarkerTestsData($id);
				$data['excel'] = $empRepository->getExcelTestsData($id);
				break;
			case 'credits':		
				$form = $this->createForm(ClientEditCredits::class); 
				$data = $empRepository->getCreditsData($id);
				break;
			case 'activate':	
				$form = $this->createForm(ClientEditActivate::class); 
				$data = $empRepository->activatedStatus($id); 
				break;
			case 'usage':		
				$form = $this->createForm(ClientEditUsage::class); 
				$data = null;
				break;
			default:			
				throw new exception("Unknown client edit tab name");
		}


		// If the form was POSTed, validate and process it
		
		$form->handleRequest($request);
		if ($form->isSubmitted() && $form->isValid())
		{
			$data = $form->getData();
			if($pg=='labelling') {
				foreach($request->files as $uploadedFile) {
					if(!empty($uploadedFile['newLogo'])) {
					    $data['tmp_name'] = $uploadedFile['newLogo']->__toString();

					}
					break;
				}
			}

			//  Perform the action (save to database, etc)
			switch ($pg) {
				case 'basic':		$clientadmin->saveBasicData($id,$data); $this->showMsg($request); break;
				case 'labelling':	$clientadmin->saveWhitelabelData($id,$data); $this->showMsg($request); break;
				case 'options':		$clientadmin->saveOptionsData($id,$data); $this->showMsg($request); break;
				case 'skills':		$empRepository->saveSkillsData($id, $data); $this->showMsg($request); break;
				case 'tests':		$empRepository->saveTestsData($id, $data); $this->showMsg($request); break;
				case 'credits':		$empRepository->saveCreditsData($id,$data); $this->showMsg($request); break;
				case 'activate':	$this->activateClient($id, $this->get('security.password_encoder')); $this->showMsg($request, 'Client (Re-)Activated'); break;
				case 'usage':		
					$startDate = $data['startDate']->format('Y-m-d');
					$endDate = $data['startDate']->format('Y-m-d');
					return $this->redirect("/admin/client/usagereport/$id/$startDate/$endDate");
				default:			
					throw new \Exception("Unknown client edit tab name");
			}
			return $this->redirect("/admin/client/edit/{$pg}/{$id}");
		}


		// If this is not a POST (eg, first time through/displaying) - output the form
		if (!$request->isMethod('POST')) {
			if($pg!='skills' and $pg!='tests' and $pg!='usage') $form->setData($data);
		}

		$values=null;
		$values2=null;
		if($pg=='skills') $values=$data;
		if($pg=='tests') { $values=$data['class']; $values2=$data['excel']; }

		return $this->render('@App/client/edit.html.twig', array(
            'clientName'	=> $client->getCompany(),
			'id'			=> $id,
			'pg'			=> $pg,
			'values'		=> $values,
			'values2'		=> $values2,
			'form'			=> $form->createView(),
			'data'			=> $data,
        ));
	}
	
	
	//----------------------------------------------------------------------------------
	//  Activate Client
	//----------------------------------------------------------------------------------
	
    public function activateClient($id, $encoder)
    {	
		$em = $this->getDoctrine()->getManager();
		$user = $em->getRepository('AppBundle\Entity\Users')->findOneBy(array('employerId' => $id));
		$user->setTempPassword(1);
		$password = substr(base64_encode(random_bytes(8)),0, -1);
		$user->setPassword($password, $encoder);
		$user->setPlainPassword($password);
		$em->persist($user);
		$em->flush();


		$parameters = array(
			'password' => $user->getPlainPassword(),
			'name' => $user->getName(), 
			'toplevel_domain' => $this->getParameter('toplevel_domain'),
			'hireabl_email' => $this->getParameter('hireabl_email'),
			'hireabl_phone' => $this->getParameter('hireabl_phone'),
		);

		$se = new \AppBundle\Model\SendEmail($this->get('twig'), $this->get('mailer'), $this->getDoctrine()->getManager());
		$se->send($user->getEmailAddress(), 
			$user->getUsername(), 
			$this->getUser()->getId(), 
			"Welcome to Koine",
			"hireabl.registration",
			$parameters
		);
	}
	
		
	private function showMsg($request, $msg=null, $type='success')
	{
		if(!$msg) $msg = "Changes saved";
		$request->getSession()->getFlashBag()->add($type, $msg);
	}
	
	
	/**
     * @Security("has_role('ROLE_ADMIN')")
     * @Route("/admin/client/usagereport/{id}/{startDate}/{endDate}", name="admin_client_usagereport")
     * @return \Symfony\Component\HttpFoundation\Response
     */
	public function usageReportAction(Request $request)
    {
		$em = $this->getDoctrine()->getManager();
		$employerId = $request->get('id');
		$startDate= $request->get('startDate');
		$endDate = $request->get('endDate');
		
		$report = new UsageReport($em, $employerId, $startDate, $endDate);
		die;
	}
	
}
