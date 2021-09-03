<?php

namespace AppBundle\Model;

class Disclosures
{
	private $domain;
	private $pin;
	private $sharedKey;
	private $http_code;
	
	
	public function __construct($domain, $pin, $sharedKey)
    {
	    $this->domain = $domain;
        $this->pin = $pin;
        $this->sharedKey = $sharedKey;
    }

	
	public function createApplication($data)
	{
		$response = $this->request('organisation/' . $this->pin . '/application', $data);
       // print "<pre>"; var_dump($response);exit;
		return $this->processResponse($response);

		//$x = $this->processResponse($response);
		//var_dump($x); die('CREATE');
	}
	

	public function updateApplication($data)
	{
		$response = $this->request('organisation/' . $this->pin . '/application/' . $data['ClientReference'], $data, 'PUT');
		return $this->processResponse($response);
		//print "<pre>"; var_dump($response);
		//$x = $this->processResponse($response);
		//var_dump($x); die('UPDATE');
	}

	
	public function verifyApplication($data)
	{
		$ClientId = $data['ClientId'];
		unset($data['ClientId']);
		$response = $this->request('organisation/' . $this->pin . '/application/' . $ClientId . '/verify', $data, 'POST');
		$x= $this->processResponse($response);
		//return $x; 
		return null;
	}

	
	public function getApplicationStatus($clientId)
	{
		$response = $this->request('organisation/' . $this->pin . '/application/' . $clientId . '/status');
		return $response;
	}

	
	public function getApplicationDetails($clientId)
	{
		$response = $this->request('organisation/' . $this->pin . '/application/' . $clientId);
		return $response;
	}


	public function getPositions()
	{
		$response = $this->request('organisation/' . $this->pin . '/positions');
		return $response;
	}

	
	//--------------------------------------------------------------
	//  Formats the response:
	//  null = OK
	//  array() = Error message(s)
	//--------------------------------------------------------------

	private function processResponse($data)
	{
		//  Successful = return null
		if($this->http_code>=200 and $this->http_code<=299) {
			return null;
		}
		
		// If an error indicated, build an array of error messages
		$errors = array();
		if(!empty($data['ValidationErrors']))
		{
			foreach($data['ValidationErrors'] as $idx=>$d)
			{
				$errors[] = $d['Description'];
			}
		}
		
		// If no error messages found, create one using the http response code
		if(empty($errors))
		{
			$errors[] = "Error " . $this->http_code;
		}
		return $errors;
	}
	

	//--------------------------------------------------------------
	//  Makes the CURL request, and returns the API data
	//  as an associative array.
	//--------------------------------------------------------------
	
	private function request($url, $data = null, $customMethod = null)
	{
		$method = 'GET';
		if(!empty($data)) $method='POST';
		if(!empty($customMethod)) $method=$customMethod;
		
		$full_url = $this->domain . $url;
		$headers = array(
			'SharedKey: ' . $this->sharedKey,
			'Content-Type: application/json',
		);
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $full_url);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);


		//  If data supplied, send it
		if(!empty($data))
		{
			$jsondata = json_encode($data,JSON_UNESCAPED_SLASHES);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $jsondata);
		}

		
		//  Determine http method
		switch ($method)
		{
			case 'GET':
				curl_setopt($ch, CURLOPT_HTTPGET, 1);
				break;
			case 'POST':
				curl_setopt($ch, CURLOPT_POST, 1);
				break;
			default:
				curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $customMethod);
				break;
		}
		$result = curl_exec($ch);
		$this->http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
		$this->logResult($url,$result);
		$json_result = json_decode($result,true);
		return $json_result;
	}
	
	
	//--------------------------------------------------------------
	//  Logs each call result to the dbs_responses table
	//--------------------------------------------------------------
	
	private function logResult($url, $response)
	{
		// TODO
		return null;
	}	
}
