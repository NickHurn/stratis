<?php

class GBG_Model_WsseAuthHeader extends SoapHeader
{
    private $wss_ns = 'http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-secext-1.0.xsd';

    function __construct($user, $pass, $ns = null)
    {
        if ($ns) {
            $this->wss_ns = $ns;
        }

        $auth = new stdClass();
        $auth->Username = new SoapVar($user, XSD_STRING, NULL, $this->wss_ns, NULL, $this->wss_ns);
        $auth->Password = new SoapVar($pass, XSD_STRING, NULL, $this->wss_ns, NULL, $this->wss_ns);
        $username_token = new stdClass();
        $username_token->UsernameToken = new SoapVar($auth, SOAP_ENC_OBJECT, NULL, $this->wss_ns, 'UsernameToken', $this->wss_ns);
        $security_sv = new SoapVar(
            new SoapVar($username_token, SOAP_ENC_OBJECT, NULL, $this->wss_ns, 'UsernameToken', $this->wss_ns),
            SOAP_ENC_OBJECT, NULL, $this->wss_ns, 'Security', $this->wss_ns);
        parent::__construct($this->wss_ns, 'Security', $security_sv, true);
    }
}

class DocImage
{
    public $DocImage;

    public function __construct($filename)
    {
        $this->DocImage = file_get_contents($filename);
		if(!$this->DocImage) die("ID3: Unable to fetch image file $filename");
    }
}

function id3($file)
{
	$wsdl = "https://pilot.id3global.com/ID3gWS/ID3global.svc?wsdl&rev=34";
	$user = "TonyPenn@hireabl.com";
	$pass = "fh29Soi!!$23DddsaW";
	
//	$wsdl = "https://www.id3global.com/ID3gWS/ID3global.svc?wsdl";
//	$user = "ScottB@hireabl.com";
//	$pass = "KPX-U4p-QGD-x8r";
	
	$options = array('soap_version' => 1, 'exceptions' => true, 'trace' => 1, 'wdsl_local_copy' => false);
	$version = 'v1.1.3';

	$soapClient = new SoapClient($wsdl, $options);
	$wsse_header = new GBG_Model_WsseAuthHeader($user, $pass);
	$soapClient->__setSoapHeaders(array($wsse_header));
	$objParam = new DocImage($file);

	try
	{
		$objRet = $soapClient->UploadAndProcess($objParam);
		$response = $soapClient->__getLastResponse();
		return $response;
	}
	catch (Exception $ex)
	{
		$response = $soapClient->__getLastResponse();
		return $response;
	}

	$response = $soapClient->__getLastResponse();
	return $response;
}

	