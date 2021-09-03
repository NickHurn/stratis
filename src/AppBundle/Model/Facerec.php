<?php

namespace AppBundle\Model;
use Doctrine\ORM\EntityManagerInterface;

class Facerec
{
	public $url;
	
	public function __construct()
    {
        //$this->url = $this->getParameter('visualid_url');
		//die($this->url);
		$this->url = "http://facerec.dev";
	}


	public function compare($file1,$file2)
	{
		$basepath = dirname(dirname(dirname(dirname(__FILE__))))."/web";
		
		$post = [
			'file1'	=> file_get_contents($basepath.$file1),
			'file2'	=> file_get_contents($basepath.$file2),
		];
		
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post);

        $result = curl_exec($ch);
        if($result === false) {
            echo 'A system error has occured. FR01: ' . curl_error($ch);
        }

		curl_close($ch);
        return $result;
    }
}