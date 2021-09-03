<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use AppBundle\Entity\Repository;
use Doctrine\ORM\Entity;
use AppBundle\Entity\PoolQuestions;
use AppBundle\Entity\FormQuestions;


class FormBuilderController extends Controller {

	public $arr_question_types = array(
		'TEXT' => 'Free Text',
		'DATE' => 'Date',
		'SELECT' => 'Multiple Choice',
		'NUMBER' => 'Number',
		'TEXTAREA' => 'Long Text',
		'POOL' => 'From Question Pool',
	);
	
	public $arr_question_types_pool = array(
		'TEXT' => 'Free Text',
		'DATE' => 'Date',
		'SELECT' => 'Multiple Choice',
		'NUMBER' => 'Number',
		'TEXTAREA' => 'Long Text',
	);

		
	public $pools_array = array();

	
	/**
	 * @Route("/formbuilder/loadquestions/{formid}", name="formbuilder_loadQuestions")
	 */
	public function loadquestionsAction(Request $request) {
		$this->pools_array[1] = 'PHP Questions (10)';
		$this->pools_array[2] = 'Java Questions (5)';

		$form_id = $request->get('formid');
		$em = $this->getDoctrine()->getManager();
		$questions = $em->getRepository('AppBundle:FormQuestions')->findBy(['formId' => $form_id], ['seq' => 'ASC']);
		$this->renderQuestions($questions, $form_id);
	}

	
	/**
	 * @Route("/formbuilder/poolloadquestions/{poolid}", name="formbuilder_poolLoadQuestions")
	 */
	public function poolloadquestionsAction(Request $request) {

		$pool_id = $request->get('poolid');
		$em = $this->getDoctrine()->getManager();
		$questions = $em->getRepository('AppBundle:PoolQuestions')->findBy(['poolId' => $pool_id], ['seq' => 'ASC']);
		$this->renderQuestions($questions, $pool_id, true);
	}

	
	private function renderQuestions($questions, $form_id, $isPool=false)
	{
		foreach ($questions as $q)
		{
			if($isPool)
			{
				$qtype_options_html = $this->buildChoices($this->arr_question_types_pool, $q->getQuestionType());
				$pool_options_html = '';
			}
			else
			{
				$qtype_options_html = $this->buildChoices($this->arr_question_types, $q->getQuestionType());
				$pool_options_html = $this->buildChoices($this->pools_array, $q->getPoolId());
			}

			$datavalues = '';
			$datavalues = $q->getDataValues();
			$hide = 'display:none';
			if ($q->getQuestionType() == 'SELECT')
				$hide = '';
			$hide2 = 'display:none';
			if ($q->getQuestionType() == 'POOL')
				$hide2 = '';
			$i = $q->getId();
			print "<li id='q{$i}' class='qbox'>";
			print "<div class='qblock'>Question Type<br/><select class='qtyp' id='qtyp{$i}'>{$qtype_options_html}</select></div>";
			print "<div class='qblock' id='dvtext{$i}'>Question Text<br/><textarea id='qt{$i}' name='qt{$i}' class='qt'>{$q->getQuestion()}</textarea></div>";

			print "<div class='qblock' id='dvpool{$i}' style='$hide2'><div class='qblock'>Question Pool<br/><select class='qpool' id='qpool{$i}'>{$pool_options_html}</select></div><div class='qblock'>#Questions:<br/><input type='text' name='numpool{$i}' id='numpool{$i}' value='{$q->getPoolQuestions()}' style='width:50px'></div></div>";

			print "<div class='qblock' id='dvsecs{$i}'>Seconds Limit<br/><input type='text' class='secs' name='secs{$i}' id='secs{$i}' value='{$q->getSecs()}' style='width:50px'></div>";
			print "<div class='qblock' id='dvals{$i}' style='$hide'>Possible Answers (left box), weight (right box)</span><br/>";
			$rows = explode("&#10;",$datavalues);
			print "<div class='mcbox'>";
			for($j=1; $j<=9; $j++)
			{
				if(empty($rows[$j-1])) {
					$d[0]=''; $d[1]='';
				} else {
					$d = explode("--",$rows[$j-1],2);
					$d[0] = htmlspecialchars(trim($d[0],ENT_QUOTES));
					$d[1] = htmlspecialchars(trim($d[1],ENT_QUOTES));
				}
				print "<input type='text' class='mcq' name='qv{$i}r{$j}' id='qv{$i}q{$j}' value='{$d[1]}'> ";                                      
				print "<input type='text' class='mcw' name='qv{$i}r{$j}' id='qv{$i}w{$j}' value='{$d[0]}'><br/> ";
			}
			print "</div></div>";
			if ($i == 0)
				print "<div class='qblock' style='float:right;text-align:right;'><input type='button' id='savebtn0' class='btn green marginbottom' onclick='qsave({$i},{$form_id})' value='Add New'/><br/><img src='/images/drag.png' height=16></div>";
			else
				print "<div class='qblock' style='float:right;text-align:right;'><input type='button' id='savebtn{$i}' class='btn disabled marginbottom' onclick='qsave({$i},{$form_id})' value='Save'/><br/><input type='button' class='btn red marginbottom' onclick='qdelete({$i},{$form_id})' value='Delete'/><br/><img src='/images/drag.png' height=16></div>";
			print "</li>";
		}

		//---------

		$qtype_options_html = $this->buildChoices($this->arr_question_types, 'FREETEXT');
		$pool_options_html = $this->buildChoices($this->pools_array, '');
		$hide = 'display:none';
		$hide2 = 'display:none';
		$datavalues = '';

		$q = null;
		$i = 0;
		print "<li id='q{$i}' class='qbox'>";
		print "<div class='qblock'>Question Type<br/><select class='qtyp' id='qtyp{$i}'>{$qtype_options_html}</select></div>";
		print "<div class='qblock' id='dvtext{$i}'>Question Text<br/><textarea id='qt{$i}' name='qt{$i}' class='qt'></textarea></div>";

		print "<div class='qblock' id='dvpool{$i}' style='$hide2'><div class='qblock'>Question Pool<br/><select class='qpool' id='qpool{$i}'>{$pool_options_html}</select></div><div class='qblock'>#Questions:<br/><input type='text' name='numpool{$i}' id='numpool{$i}' value='' style='width:50px'></div></div>";

		print "<div class='qblock' id='dvsecs{$i}'>Seconds Limit<br/><input type='text' name='secs{$i}' class='secs' id='secs{$i}' value='' style='width:50px'></div>";
		print "<div class='qblock' id='dvals{$i}' style='$hide'>Possible Answers (left box), weight (right box)<br/>";
		$rows = explode("&#10;",$datavalues);

		print "<div class='mcbox'>";
		for($j=1; $j<=9; $j++)
		{
			if(empty($rows[$j-1])) {
				$d[0]=''; $d[1]='';
			} else {
				$d = explode("--",$rows[$j-1],2);
				$d[0] = htmlspecialchars($d[0],ENT_QUOTES);
				$d[1] = htmlspecialchars($d[1],ENT_QUOTES);
			}
			print "<input type='text' class='mcq' name='qv{$i}r{$j}' id='qv{$i}q{$j}'> ";
			print "<input type='text' class='mcw' name='qv{$i}r{$j}' id='qv{$i}w{$j}'><br/> ";
		}
		print "</div></div>";
		print "<div class='qblock' style='float:right;text-align:right;'><input type='button' id='savebtn0' class='btn green marginbottom' onclick='qsave({$i},{$form_id})' value='Add New'/><br/><img src='/images/drag.png' height=16></div>";
		print "</li>";
		print "\n<script>\n";
		print "\$( function() { addEventHandlers(); });\n";
		print "</script>\n";
		exit;
	}

	/**
	 * Creates a block of HTML representing a SELECT box and its choices.
	 * 
	 * @param array $choices An array of idx=>name select options
	 * @param string $chosen  The idx value of the selected option
	 */
	private function buildChoices($options, $chosen) {
		$output_html = '';
		foreach ($options as $val => $txt) {
			$selected = ($val == $chosen) ? "selected='selected'" : "";
			$output_html .= "<option $selected value='$val'>$txt</option>";
		}
		return $output_html;
	}


	/**
	 * @Route("/formbuilder/storesort/{formid}", name="formbuilder_storesort")
	 * 
	 * When items are dragged on the page, an ajax call is made here with the new seq order of the
	 * items, so that it can be saved to the database.
	 */
	public function storesortAction(Request $request) {
		$form_id = $request->get('formid');
		$p = $request->get('p');
		$this->getDoctrine()->getManager()->getRepository('AppBundle:FormQuestions')->sortQuestions($form_id, $p);
		print "OK";
		exit;
	}


	/**
	 * @Route("/formbuilder/poolstoresort/{poolid}", name="formbuilder_poolstoresort")
	 * 
	 * When items are dragged on the page, an ajax call is made here with the new seq order of the
	 * items, so that it can be saved to the database.
	 */
	public function poolstoresortAction(Request $request) {
		$poolid = $request->get('poolid');
		$p = $request->get('p');
		$this->getDoctrine()->getManager()->getRepository('AppBundle:PoolQuestions')->sortQuestions($poolid, $p);
		print "OK";
		exit;
	}

	
	/**
	 * @Route("/formbuilder/questionsave", name="formbuilder_questionsave")
	 */
	public function questionsaveAction(Request $request)
	{
		foreach($_POST as $idx=>$var) $post[$idx] = filter_input(INPUT_POST, $idx, FILTER_SANITIZE_SPECIAL_CHARS);
		$post['id'] = floor($post['id']);
		if($post['seq']==0) $post['seq']=1;
		
		$dump = var_export($_POST,true);
		file_put_contents('/tmp/debug',$dump);
		chmod('/tmp/debug',0777);
		
		$em = $this->getDoctrine()->getManager();		
		if($post['id']>0) {
			$fq = $em->getRepository('AppBundle:FormQuestions')->findOneBy(['id'=>$post['id']]);
		} else {
			$fq = new FormQuestions();
		}
		$fq->setFormId($post['formid']);
		$fq->setSeq($post['seq']);
		$fq->setQuestion($post['question']);
		$fq->setQuestionType($post['questiontype']);
		$fq->setPoolId($post['poolid']);
		$fq->setSecs($post['secs']);
		$fq->setDataValues($post['datavalues']);
		$em->persist($fq);
		$em->flush();
		
		// If we added a new question, then re-build the editing form (so that a new 'blank' question is added)
		if($post['id']==0) {
			$em->getRepository('AppBundle:FormQuestions')->updateQuestionCount($post['formid']);
			$questions = $em->getRepository('AppBundle:FormQuestions')->findBy(['formId' => $post['formid']], ['seq' => 'ASC']);
			$this->renderQuestions($questions, $post['formid']);
		} else {
			print "OK";
		}
		exit;
	}


	/**
	 * @Route("/formbuilder/poolquestionsave", name="formbuilder_poolquestionsave")
	 */
	public function poolquestionsaveAction(Request $request)
	{
		foreach($_POST as $idx=>$var) $post[$idx] = filter_input(INPUT_POST, $idx, FILTER_SANITIZE_SPECIAL_CHARS);
		$post['id'] = floor($post['id']);
		if($post['seq']==0) $post['seq']=1;
		
		$em = $this->getDoctrine()->getManager();		
		if($post['id']>0) {
			$fq = $em->getRepository('AppBundle:PoolQuestions')->findOneBy(['id'=>$post['id']]);
		} else {
			$fq = new PoolQuestions();
		}
		$fq->setPoolId($post['poolid']);
		$fq->setSeq($post['seq']);
		$fq->setQuestion($post['question']);
		$fq->setQuestionType($post['questiontype']);
		$fq->setSecs($post['secs']);
		$fq->setDataValues($post['datavalues']);
		$em->persist($fq);
		$em->flush();
		
		// If we added a new question, then re-build the editing form (so that a new 'blank' question is added)
		if($post['id']==0) {
			$em->getRepository('AppBundle:PoolQuestions')->updateQuestionCount($post['poolid']);
			$questions = $em->getRepository('AppBundle:PoolQuestions')->findBy(['poolId' => $post['poolid']], ['seq' => 'ASC']);
			$this->renderQuestions($questions, $post['poolid']);
		} else {
			print "OK";
		}
		exit;
	}

	
	/**
	 * @Route("/formbuilder/questiondelete/{id}/{formid}", name="formbuilder_questiondelete")
	 */
	public function questiondeleteAction(Request $request)
	{
		$id = $request->get('id');
		$formid = $request->get('formid');
		$em = $this->getDoctrine()->getManager();		
		$q = $em->createQuery('delete from AppBundle:FormQuestions fq WHERE fq.id='.intval($id));
		$q->execute();
		$em->getRepository('AppBundle:FormQuestions')->updateQuestionCount($formid);
				
		$questions = $em->getRepository('AppBundle:FormQuestions')->findBy(['formId' => $formid], ['seq' => 'ASC']);
		$this->renderQuestions($questions, $formid);
		exit;
	}

	
	/**
	 * @Route("/formbuilder/poolquestiondelete/{id}/{formid}", name="formbuilder_poolquestiondelete")
	 */
	public function poolquestiondeleteAction(Request $request)
	{
		$id = $request->get('id');
		$formid = $request->get('formid');
		$em = $this->getDoctrine()->getManager();		
		$q = $em->createQuery('delete from AppBundle:PoolQuestions fq WHERE fq.id='.intval($id));
		$q->execute();
		$em->getRepository('AppBundle:PoolQuestions')->updateQuestionCount($formid);
				
		$questions = $em->getRepository('AppBundle:PoolQuestions')->findBy(['poolId' => $formid], ['seq' => 'ASC']);
		$this->renderQuestions($questions, $formid);
		exit;
	}
	
	
	/**
	 * @Route("/formbuilder/savepassscore/{formid}/{score}", name="formbuilder_savepassscore")
	 */
	public function savepassscoreAction(Request $request)
	{
		$formid = $request->get('formid');
		$score = $request->get('score');
		
		$user = $this->getUser();
		$employer_id = $user->getEmployerId();
				
		$em = $this->getDoctrine()->getManager();		
		$form = $em->getRepository('AppBundle:Forms')->findOneBy(['id'=>$formid, 'employerId'=>$employer_id, 'formType'=>'PRESCREEN']);
		if($form)
		{
			if($score<0 or $score>14400) $score=0;
			$form->setPassScore($score);
			$em->persist($form);
			$em->flush();
			die($score);
		}
		die("0");
	}

}
