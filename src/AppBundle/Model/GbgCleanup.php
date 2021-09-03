<?php

namespace AppBundle\Model;

class GbgCleanup
{
	//-----------------------------------------------------------
	//  Fix GBG data results
	//-----------------------------------------------------------
	
	public function fixdata($data)
	{
		// Fix Nat ID where just a missing landline breaks an otherwise 'good' result
	
		if(!empty($data['UK National Identity Register']))
		{
			$lines = explode("\n",$data['UK National Identity Register']['LINES']);
			$errors = 0; $pass=0;
			foreach($lines as $l)
			{
				if(strstr($l,'Mismatch:') and !strstr($l,'Mismatch: Landline') and !strstr($l,'Mismatch: Mobile')) $errors++;
				if(strstr($l,'Pass: Match')) $pass=1;
			}
			if($errors==0 and $pass==1)
			{
				$data['UK National Identity Register']['RESULT'] = 'G';
				$data['UK National Identity Register']['LINES'] = strtr($data['UK National Identity Register']['LINES'], array('Alert: Match' => 'Alert: Nomatch'));
			}
		}

		
		//  Fix International Passport where everything matches but still says nomatch
		if(!empty($data['International Passport']))
		{
			$lines = explode("\n",$data['International Passport']['LINES']);
			$errors = 0; $match=0;
			foreach($lines as $l)
			{
				if(strstr($l,'Match: Part')) $match++;
				if(substr($l,0,8)=='Mismatch' or substr($l,0,7)=='Nomatch') $errors++;
			}
			if($errors==0 and $match>=9)
			{
				$data['International Passport']['RESULT'] = 'G';
				$data['International Passport']['LINES'] = strtr($data['International Passport']['LINES'], array('Pass: Nomatch' => 'Pass: Match'));
			}
		}
	
		
		return $data;
	}
}