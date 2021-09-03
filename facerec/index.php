<?php

if(!$_POST) 
{
	header("HTTP/1.0 404 Not Found");
	print "<html><body>";
	print "<h1>Not Found</h1>";
	print "The requested URL was not found on this server.";
	print "</body></html>";
	die;
}

include 'faceModel.php';
$face = new faceModel();

$tempfile1 = tempnam("/tmp","FC1");
$tempfile2 = tempnam("/tmp","FC2");

file_put_contents($tempfile1, $_POST['file1']);
file_put_contents($tempfile2, $_POST['file2']);

$resp = $face->uploadAndDetect($tempfile1);
$data1 = json_decode($resp, true);

$resp = $face->uploadAndDetect($tempfile2);
$data2 = json_decode($resp, true);

$resp = $face->compare($data1['faces'][0]['face_token'], $data2['faces'][0]['face_token']);
$comp = json_decode($resp, true);

unlink($tempfile1);
unlink($tempfile2);

$ret = [
	'image1' => $data1,
	'image2' => $data2,
	'comp' => $comp,
];

$json = json_encode($ret);
print $json;
