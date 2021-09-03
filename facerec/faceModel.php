<?php
class faceModel
{
	public function uploadAndDetect($imageurl)
	{
		$url = 'https://api-us.faceplusplus.com/facepp/v3/detect';
		$fields = ['image_file' => new \CurlFile($imageurl, 'image/jpg', 'image.jpg')];
		$fields['api_key'] = 'hf7MG9stHAtT5u5WVQZERO8wt1q-HG4S';
		$fields['api_secret'] = 'RhJGthOCA2cwhaxt5-hffzQcU4RBoRUP';
		$fields['return_attributes'] = 'gender,age,smiling,headpose,facequality,blur,eyestatus,emotion,ethnicity,beauty,mouthstatus,eyegaze,skinstatus';

		$ch = curl_init($url);
		curl_setopt ($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
		curl_setopt( $ch, CURLOPT_FOLLOWLOCATION, 1);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: multipart/form-data')); 
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		$response = curl_exec($ch);
		return $response;
	}

	
	public function compare($face1,$face2)
	{
		$url = 'https://api-us.faceplusplus.com/facepp/v3/compare';
		$fields['api_key'] = 'hf7MG9stHAtT5u5WVQZERO8wt1q-HG4S';
		$fields['api_secret'] = 'RhJGthOCA2cwhaxt5-hffzQcU4RBoRUP';
		$fields['face_token1'] = $face1;
		$fields['face_token2'] = $face2;

		$ch = curl_init($url);
		curl_setopt ($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
		curl_setopt( $ch, CURLOPT_FOLLOWLOCATION, 1);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: multipart/form-data')); 
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		$response = curl_exec($ch);
		return $response;
	}
	
}
