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


function GBG_process($file)
{
//	$wsdl = "https://pilot.id3global.com/ID3gWS/ID3global.svc?wsdl&rev=34";
//	$user = "TonyPenn@hireabl.com";
//	$pass = "fh29Soi!!$23DddsaW";

    $wsdl = "https://www.id3global.com/ID3gWS/ID3global.svc?wsdl";
    $user = "ScottB@hireabl.com";
    $pass = "j3llyDell34";

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


//---------------------------------------------------------------------------
//  Return TRUE if the image was processed OK
//---------------------------------------------------------------------------

function GBG_checkOK($response)
{
    $status = true;
    if(!stristr($response, "</UploadAndProcessResult>")) $status = false;
    if(!stristr($response, "<Status>Completed</Status>")) $status = false;

    return $status;
}


//---------------------------------------------------------------------------
//  Extract and format the data from the response
//---------------------------------------------------------------------------

function GBG_extract($response)
{
    $x = GBG_getSection($response,"ExtractedData");
    $data = (array) simplexml_load_string($x);

    $x2 = GBG_getSection($response,"Document");
    $data2 = (array) simplexml_load_string($x2);
    $data['DocumentNumber'] =  $data2['DocumentNumber'];
    $data['Country'] =  $data2['Country'];
    $data['Type'] =  $data2['Type'];
    $x3 = GBG_getSection($response,"TestResults");
    $data3 = (array) simplexml_load_string($x3);
    $tests = '';
    foreach($data3['DocumentForgeryTests'] as $idx=>$d)
    {
        if($d->Type=='Overall Validation') $data['Result'] = $d->Result;
        $tests .= $d->Description . ": " . $d->Result . "\n";
    }
    $data['TestResults'] = $tests;
    return $data;
}


//---------------------------------------------------------------------------
//  Extract driving licence data and format the data from the response
//---------------------------------------------------------------------------

function GBG_extractDrivingData($response)
{
    $x = GBG_getSection($response,"ExtractedData");
    $data = (array) simplexml_load_string($x);

    $x2 = GBG_getSection($response,"Document");
    $data2 = (array) simplexml_load_string($x2);
    $data['DocumentNumber'] =  $data2['DocumentNumber'];
    $data['Country'] =  $data2['Country'];
    $data['Type'] =  $data2['Type'];

    $x4 = GBG_getSection($response,"FormattedAddress");
    $data4 = (array) simplexml_load_string($x4);
    $data['Street'] =  $data4['Street'];
    $data['City'] =  $data4['City'];
    $data['ZipPostcode'] =  $data4['ZipPostcode'];
    $data['Building'] =  $data4['Building'];

    $x3 = GBG_getSection($response,"TestResults");
    $data3 = (array) simplexml_load_string($x3);
    $tests = '';
    foreach($data3['DocumentForgeryTests'] as $idx=>$d)
    {
        if($d->Type=='Overall Validation') { $data['Result'] = $d->Result; }
        $tests .= $d->Description . ": " . $d->Result . "\n";
    }
    $data['TestResults'] = $tests;
    return $data;
}


//---------------------------------------------------------------------------
//  Returns a <section>...</section> from the response
//---------------------------------------------------------------------------

function GBG_getSection($response,$section)
{
    $endstring = "</{$section}>";
    $s = strpos($response, "<{$section}>");
    $e = strpos($response, $endstring);
    $data = substr($response, $s, $e-$s+strlen($endstring));
    return $data;
}


//---------------------------------------------------------------------------
//  Runs Agent Profile check. Returns XML response
//---------------------------------------------------------------------------

function GBG_runAgentCheck($checkNumber,$data)
{
    date_default_timezone_set('Europe/London');

    class WsseAuthHeader extends SoapHeader
    {
        private $wss_ns = 'http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-secext-1.0.xsd';

        function __construct($user, $pass, $ns = null)
        {
            if ($ns)
            {
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

    if(0)	// 0=live, 1=test
    {
        $profile[1] = '03a6d4f4-bba7-4dbc-a051-d33ae431e700'; // UAT Agent Check 1
        $profile[2] = '0704df7c-6297-4e76-8617-3e2ee368193c'; // UAT Agent Check 2
        $profile[3] = '0350e46b-3260-46d6-ab47-944b85e84ce7'; // UAT Agent Check 3
        $profile[4] = '9034f8f8-d121-49ee-a191-879e0085784c'; // UAT Agent Check 4
        $username = "ScottB@hireabl.com";
        $password = "j3llyDell34";
        $wsdl = 'https://pilot.id3global.com/ID3gWS/ID3global.svc?wsdl';
    }
    else
    {
        $profile[1] = 'd1546e85-9241-4674-a6ff-6bde0b7b89c8'; // LIVE Agent Check 1
        $profile[2] = '54a06e65-2508-46a8-8f90-70c39396f1cf'; // LIVE Agent Check 2
        $profile[3] = '17e2cd3d-760a-400c-8a00-052f56befb7c'; // LIVE Agent Check 3
        $profile[4] = 'b674fe13-2a0b-48ca-87e7-e12d1fd54db6'; // LIVE Agent Check 4
        $username = "ScottB@hireabl.com";
        $password = "j3llyDell34";
        $wsdl = "https://www.id3global.com/ID3gWS/ID3global.svc?wsdl";
    }


    $wsse_header = new WsseAuthHeader($username, $password);
    $options = array(
        'soap_version' => SOAP_1_1,
        'exceptions' => true,
        'trace' => 1,
        'wdsl_local_copy' => true
    );

    $soapClient = new SoapClient($wsdl, $options);
    $soapClient->__setSoapHeaders(array($wsse_header));
    $objParam = new stdClass();
    $objParam->ProfileIDVersion = new stdClass();
    $objParam->ProfileIDVersion->ID = $profile[$checkNumber];

    $data['Country'] = 'GBR';
    $data['CountryOfBirth'] = 'GBR';

    $objParam->ProfileIDVersion ->Version = 0;
    $objParam->InputData = new stdClass();
    $objParam->InputData->Personal = new stdClass();
    $objParam->InputData->Personal->PersonalDetails = new stdClass();
    $objParam->InputData->Personal->PersonalDetails->Title = $data['Title'];

    $objParam->InputData->Personal->PersonalDetails->Forename = $data['Forename'];
    if (isset($data['Middlename'])) {
        $objParam->InputData->Personal->PersonalDetails->MiddleName = $data['Middlename'];
    }
    $objParam->InputData->Personal->PersonalDetails->Surname = $data['Surname'];
    $objParam->InputData->Personal->PersonalDetails->Gender = $data['Gender'];
    $objParam->InputData->Personal->PersonalDetails->DOBDay = substr($data['DOB'],0,2);
    $objParam->InputData->Personal->PersonalDetails->DOBMonth = substr($data['DOB'],3,2);
    $objParam->InputData->Personal->PersonalDetails->DOBYear = substr($data['DOB'],6,4);
    $objParam->InputData->Personal->PersonalDetails->Country = $data['CountryOfBirth']; // null

    $objParam->InputData->Personal->PersonalDetails->Birth = new stdClass();
    $objParam->InputData->Personal->PersonalDetails->Birth->MothersMaidenName = $data['MothersMaidenName'];
    $objParam->InputData->Personal->PersonalDetails->Birth->SurnameAtBirth = $data['SurnameAtBirth'];
    $objParam->InputData->Personal->PersonalDetails->Birth->TownOfBirth = $data['TownAtBirth'];
//	$objParam->InputData->Personal->PersonalDetails->Birth->Country = $data['CountryOfBirth']; // null

    $objParam->InputData->Addresses = new stdClass();
    $objParam->InputData->Addresses->CurrentAddress = new stdClass();
    $objParam->InputData->Addresses->CurrentAddress->Country = $data['Country']; // null
    $objParam->InputData->Addresses->CurrentAddress->AddressLine1 = $data['AddressLine1'];
    $objParam->InputData->Addresses->CurrentAddress->AddressLine2 = $data['AddressLine2'];
    $objParam->InputData->Addresses->CurrentAddress->AddressLine3 = $data['AddressLine3'];
    $objParam->InputData->Addresses->CurrentAddress->AddressLine4 = $data['AddressLine4'];
    $objParam->InputData->Addresses->CurrentAddress->AddressLine5 = $data['AddressLine5'];
    $objParam->InputData->Addresses->CurrentAddress->FirstYearOfResidence = substr($data['ResidentFrom'],3,4);
    $objParam->InputData->Addresses->CurrentAddress->FirstMonthOfResidence = substr($data['ResidentFrom'],0,2);
    $objParam->InputData->Addresses->CurrentAddress->LastYearOfResidence = substr($data['ResidentTo'],3,4);
    $objParam->InputData->Addresses->CurrentAddress->LastMonthOfResidence = substr($data['ResidentTo'],0,2);

    $objParam->InputData->Addresses->PreviousAddress1 = new stdClass();
    $objParam->InputData->Addresses->PreviousAddress1->Country = $data['Country']; // null
    $objParam->InputData->Addresses->PreviousAddress1->AddressLine1 = $data['PrevAddressLine1'];
    $objParam->InputData->Addresses->PreviousAddress1->AddressLine2 = $data['PrevAddressLine2'];
    $objParam->InputData->Addresses->PreviousAddress1->AddressLine3 = $data['PrevAddressLine3'];
    $objParam->InputData->Addresses->PreviousAddress1->AddressLine4 = $data['PrevAddressLine4'];
    $objParam->InputData->Addresses->PreviousAddress1->AddressLine5 = $data['PrevAddressLine5'];
    $objParam->InputData->Addresses->PreviousAddress1->FirstYearOfResidence = substr($data['PrevResidentFrom'],3,4);
    $objParam->InputData->Addresses->PreviousAddress1->FirstMonthOfResidence = substr($data['PrevResidentFrom'],0,2);
    $objParam->InputData->Addresses->PreviousAddress1->LastYearOfResidence = substr($data['PrevResidentTo'],3,4);
    $objParam->InputData->Addresses->PreviousAddress1->LastMonthOfResidence = substr($data['PrevResidentTo'],0,2);

    $objParam->InputData->IdentityDocuments = new stdClass();
    $objParam->InputData->IdentityDocuments->InternationalPassport = new stdClass();
    $objParam->InputData->IdentityDocuments->InternationalPassport->Number = $data['LongPassportNumber'];
    $objParam->InputData->IdentityDocuments->InternationalPassport->ShortPassportNumber = substr($data['ShortPassportNumber'],-44);
    $objParam->InputData->IdentityDocuments->InternationalPassport->ExpiryDay = substr($data['PassportExpiry'],0,2);
    $objParam->InputData->IdentityDocuments->InternationalPassport->ExpiryMonth = substr($data['PassportExpiry'],3,2);
    $objParam->InputData->IdentityDocuments->InternationalPassport->ExpiryYear = substr($data['PassportExpiry'],6,4);
    $objParam->InputData->IdentityDocuments->InternationalPassport->CountryOfOrigin =  'GBR'; // $data['CountryOfIssue'];
    $objParam->InputData->IdentityDocuments->InternationalPassport->IssueDay = substr($data['PassportIssue'],0,2);
    $objParam->InputData->IdentityDocuments->InternationalPassport->IssueMonth = substr($data['PassportIssue'],3,2);
    $objParam->InputData->IdentityDocuments->InternationalPassport->IssueYear = substr($data['PassportIssue'],6,4);
    $objParam->InputData->IdentityDocuments->InternationalPassport->Forename = $data['Forename'];
    $objParam->InputData->IdentityDocuments->InternationalPassport->Surname = $data['Surname'];
//	$objParam->InputData->IdentityDocuments->UK = new stdClass();
//	$objParam->InputData->IdentityDocuments->UK->Passport = new stdClass();
//	$objParam->InputData->IdentityDocuments->UK->Passport->Number = $data['ShortPassportNumber'];
//	$objParam->InputData->IdentityDocuments->UK->Passport->ExpiryDay = substr($data['PassportExpiry'],0,2);
//	$objParam->InputData->IdentityDocuments->UK->Passport->ExpiryMonth = substr($data['PassportExpiry'],3,2);
//	$objParam->InputData->IdentityDocuments->UK->Passport->ExpiryYear = substr($data['PassportExpiry'],6,4);

    $objParam->InputData->IdentityDocuments->UK = new stdClass();
    $objParam->InputData->IdentityDocuments->UK->NationalInsuranceNumber = new stdClass();
    $objParam->InputData->IdentityDocuments->UK->NationalInsuranceNumber->Number = $data['NINumber'];

    $objParam->InputData->ContactDetails = new stdClass();
    $objParam->InputData->ContactDetails->LandTelephone = new stdclass();
    $objParam->InputData->ContactDetails->LandTelephone->Number = $data['Telephone'];
    $objParam->InputData->ContactDetails->MobileTelephone = new stdclass();
    $objParam->InputData->ContactDetails->MobileTelephone->Number = $data['Mobile'];

    $objParam->InputData->IdentityDocuments->UK->DrivingLicence = new stdClass();
    $objParam->InputData->IdentityDocuments->UK->DrivingLicence->Number = $data['DLNumber'];
    $objParam->InputData->IdentityDocuments->UK->DrivingLicence->Forename = $data['Forename'];
    $objParam->InputData->IdentityDocuments->UK->DrivingLicence->Surname =  $data['Surname'];

    $_SESSION['data_sent'] = serialize($objParam);
    //print '<pre>'; var_dump($objParam); die;

    if (is_soap_fault($soapClient))
    {
        throw new Exception(" {$soapClient->faultcode}: {$soapClient->faultstring} ");
    }
    $objRet = null;
    try
    {
        $objRet = $soapClient->AuthenticateSP($objParam);
        return $objRet;
    }
    catch (Exception $e)
    {
        return null;
    }
}


//---------------------------------------------------------------------------
//  Extracts the AUthenticateSP data to a plain text array format
//---------------------------------------------------------------------------

function GBG_extractSP($y)
{
    ob_start();
    //print_r($y->AuthenticateSPResult->ProfileName);

    $num_sections = count($y->AuthenticateSPResult->ResultCodes->GlobalItemCheckResultCodes);


    for($s=0; $s<$num_sections; $s++)
    {
        $sect = $y->AuthenticateSPResult->ResultCodes->GlobalItemCheckResultCodes[$s];
        print "CHECK: " . $sect->Name."\n";

        //if(!empty($sect->Comment)) GBG_printSection("Comment", $sect->Comment->GlobalItemCheckResultCode);
        //if(!empty($sect->Warning)) GBG_printSection("Warning", $sect->Warning->GlobalItemCheckResultCode);
        if(!empty($sect->Mismatch)) $reportsection['mismatch'] = GBG_printSection("Mismatch", $sect->Mismatch->GlobalItemCheckResultCode);
        if(!empty($sect->Match)) $reportsection['match'] = GBG_printSection("Match", $sect->Match->GlobalItemCheckResultCode);

        foreach($sect as $nam=>$val)
        {
            if(in_array($nam,array('Name','Comment','ID','Description','Warning','Mismatch','Match'))) continue;
            print "$nam: ";
            if(is_object($val))
            {
                print "\n";
                // Nested object detail, eg credit lines
                foreach($val as $objName=>$v)
                {
                    foreach ($v as $key=>$item) {
                        if ($key == $objName ) {
                            foreach($v->$objName as $idx=>$obj)
                            {
                                foreach($obj as $attrName=>$attrVal)
                                {
                                    print "$attrName: ( $attrVal )   ";
                                }
                                print "\n";
                            }
                        }else{
                            foreach($v as $attrName=>$attrVal)
                            {
                                print "$attrName: ( $attrVal )   ";
                            }
                        }
                        print "\n";
                    }
                }
            }
            else
            {
                print $val;
            }
            print "\n";
        }

    }

    print "Overall Rating: ";
    print $y->AuthenticateSPResult->BandText;
    print "\n";

    $res = ob_get_contents();
    ob_end_clean();


    // CONVERT THE TEXT OUTPUT TO AN ARRAY

    $out = [];
    $lines = explode("\n",$res);
    foreach($lines as $line)
    {
        if(substr($line,0,6)=='CHECK:')
        {
            $section = substr($line,7);
            $out[$section]['LINES']='';
            $out[$section]['PASS']='';
            $out[$section]['ALERT']='';
        }
        else
        {
            if(substr($line,0,15)=='Overall Rating:')
            {
                $out['OVERALL'] = substr($line,16);
            }
            else
            {
                $out[$section]['LINES'].= $line."\n";
                if(substr($line,0,5)=='Pass:') $out[$section]['PASS'] = substr($line,6);
                if(substr($line,0,6)=='Alert:') $out[$section]['ALERT'] = substr($line,7);
            }
        }
    }

    //  Now add the pass/fail flags to each section


    foreach($out as $key=>$d)
    {
        if (!is_array($d)){
            continue;
        }
        $flag = 'A';

        if ($d['ALERT'] == 'Match'){
            $flag = 'R';
        }
        if ($d['PASS'] == 'Match'){
            $flag = 'G';
        }
        if ($d['PASS'] == 'NA' && $d['ALERT'] == 'Nomatch'){
            $flag = 'G';
        }
        if ($d['ALERT'] == 'Refer'){
            $flag = 'R';
        }

        $out[$key]['RESULT'] = $flag;
    }
    return $out;
}



function GBG_printSection($sectionName, $data)
{
    if(is_array($data))
    {
        for($i=0; $i<count($data); $i++)
        {
            if(!empty($data[$i]->Description)) {
                print "$sectionName: " . $data[$i]->Description."\n";
            }
        }
    }
    else
    {
        if(!empty($data->Description)) {
            print "$sectionName: " . $data->Description."\n";
        }
    }
}


class DebugSoapClient extends SoapClient {
    public $sendRequest = false;
    public $printRequest = false;
    public $formatXML = false;

    public function __doRequest($request, $location, $action, $version, $one_way=0) {
        if ( $this->printRequest ) {
            if ( !$this->formatXML ) {
                $out = $request;
            }
            else {
                $doc = new DOMDocument;
                $doc->preserveWhiteSpace = false;
                $doc->loadxml($request);
                $doc->formatOutput = true;
                $out = $doc->savexml();
            }
            echo $out;
            exit;
        }

        if ( $this->sendRequest ) {
            return parent::__doRequest($request, $location, $action, $version, $one_way);
        }
        else {
            return '';
        }
    }
}


