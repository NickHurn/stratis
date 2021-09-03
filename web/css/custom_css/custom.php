<?php
//  This file will output the css for the currently selected client, based on the sub-domain name.
//  For example, if the domain is newclient.hireable.com or newclient2.hireable.com, then it will
//  grab the css from <css_path>/newclient_error.css and output it. The ETag is used to defeat
//  caching, as this physical file doesnt change.

header('Content-type: text/css');
$etag = md5(time()); 
header("Etag: abc$etag"); 

// Get sub-domain part (eg client name), and calculate client_error.css filename
$path = dirname(__FILE__);
$parts = explode('.', $_SERVER['HTTP_HOST']);
$domain = $parts[0];
$domain = strtr($domain, array('2'=>''));
$filename = $path . '/' . $domain . "_error.css";
if(file_exists($filename))
{
	$css = file_get_contents($filename);
	print $css;
}
else
{
	print "\n/* no custom error css */\n";
}