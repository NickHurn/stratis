<?php

namespace AppBundle\Model;

class PDF
{
    public $stmt;
    public $db;

	public $user_id;
	public $job_id;
	public $job_real_id;
	public $unique_id;
	public $credit;
	

    public function __construct($user_id, $job_id, $unique_id)
    {
        $this->db = Zend_Registry::get('db');
		$this->user_id = $user_id;
		$this->job_id = $job_id;
		$this->unique_id = $unique_id;
		$this->job_real_id = $this->getSingleField("select id from jobs where uniqueid=?", array($job_id));
	}


	public function getCreditText()
	{
		return $this->credit;
	}
	
	
	//----------------------------------------------------------------------------------
	//  Fetch the first field from the first record of a query
	//----------------------------------------------------------------------------------
	
	private function getSingleField($sql, $params=null)
	{
        $this->stmt = $this->db->query($sql, $params);
        $rec = $this->stmt->fetch();
		if(!empty($rec)) { foreach($rec as $fldname=>$value) break; } else $value=null;
		return $value;
	}
	

	//----------------------------------------------------------------------------------
	//  Fetch the first record of a query
	//----------------------------------------------------------------------------------
	
	private function getSingleRecord($sql, $params=null)
	{
        $this->stmt = $this->db->query($sql, $params);
        $rec = $this->stmt->fetch();
		if(!empty($rec)) return $rec;
		return null;
	}

	
	//----------------------------------------------------------------------------------
	//  DBS Status
	//----------------------------------------------------------------------------------
	
	public function getDBSCheck()
	{
        $outcome = $this->getSingleField("select gbg_outcome from applicant_disclosures where applicant_id=? and job_id=?",
            array($this->user_id, $this->job_id));
        switch ($outcome)
        {
            case 'Clear':	$c='G'; break;
            case '':        $c='-'; break;
            default:		$c='A';
        }

        return $c;
    }


    //----------------------------------------------------------------------------------
    //  DBS Details
    //----------------------------------------------------------------------------------

    public function getDBSDetails($status)
    {
        $response = ' ';
        if($status == 'G')
        {
            $id = $this->getSingleField("select gbg_disclosure_number as nbr from applicant_disclosures where applicant_id=? and job_id=?",
                array($this->user_id, $this->job_id));

            $response = "GStatus: Clear\n-Report E-Number: {$id}";
        }
        return $response;
    }


    //----------------------------------------------------------------------------------
	//  Qualifications
	//----------------------------------------------------------------------------------
	
	public function getQualificationCheck()
	{
		$status = $this->getSingleField("select verification_status from qualification_checks where user_id=? and job_id=?",
			array($this->user_id, $this->job_real_id));

		switch ($status)
		{
			case 'NOT_FOUND':		$c='A'; break;
			case 'REJECTED':		$c='A'; break;
			case 'NOT_VERIFIED':	$c='R'; break;
			case 'VERIFIED':		$c='G'; break;
			default:				$c='-';
		}
		return $c;
	}


    //----------------------------------------------------------------------------------
    //  Qualification Details
    //----------------------------------------------------------------------------------

    public function getQualificationDetails()
    {
        $status = $this->db->query("select course_title, award, grade from qualification_checks where user_id=? and job_id=? and verification_status='VERIFIED'",
            array($this->user_id, $this->job_real_id));
        $lines = '';
        while($rec = $this->stmt->fetch())
        {
            $lines .= 'G' . $rec['course_title'] . ', ' . $rec['award'] . ', Grade: ' . $rec['grade']."\n";
        }
        return $lines;
    }


    //----------------------------------------------------------------------------------
	//  ID
	//----------------------------------------------------------------------------------
	
	public function getIDCheck()
	{
		$status = $this->getSingleField("select pass from id_checks where user_id=? and job_id=?",
			array($this->user_id, $this->job_id));
		switch ($status)
		{
			case 'Alert':	$c='R'; break;
			case 'Pass':	$c='G'; break;
			case 'Refer':	$c='A'; break;
			default:		$c='-';
		}
		return $c;
	}


    //----------------------------------------------------------------------------------
    //  ID Check Details
    //----------------------------------------------------------------------------------

    public function getIDCheckDetails($idcheck)
    {
        if($idcheck<>'G') return '';
        return 'GElectoral Register: Present';
    }


	//----------------------------------------------------------------------------------
	//  Passport Check
	//----------------------------------------------------------------------------------
	
	public function getPassportCheck()
	{
		$authenticated = $this->getSingleField("SELECT authenticated FROM gbg_image_response gir LEFT JOIN id_checks idc ON gir.check_id = idc.unique_id "
			. "WHERE user_id=? and job_id=? AND document_type='Passport'", array($this->user_id, $this->job_id));
		switch ($authenticated)
		{
			case 'Authentic':	$c='G'; break;
			case 'Indecisive':	$c='A'; break;
			case null:			$c='-'; break;
			default:			$c='R';
		}
		return $c;
	}


    //----------------------------------------------------------------------------------
    //  Passport Check Details
    //----------------------------------------------------------------------------------

    public function getPassportCheckDetails($check)
    {
        if($check<>'G') return '';
        return 'GOverall Validation
GCheck Sum - Date of Birth
GData Comparison - Date of Birth
GValidation - VIZ Date of Birth
GValidation - MRZ Date of Birth
GCheck Sum - Date of Expiry
GData Comparison - Expiry Date
GValidation - VIZ Date of Expiry
GValidation - MRZ Date of Expiry
GCheck Sum - Document Number
GData Comparison - Document Number
GValidation - VIZ Document number
GCheck Sum - Optional Data
GCheck Sum - Personal Number
GData Comparison - First Name
GData Comparison - Last Name
GData Comparison - Gender
GData Comparison - Issue Date
GValidation - VIZ Date of Issue
GVIZ Fonts - Alphabetic
GVIZ Fonts - Digits
GMRZ Fonts - Alphabetic
GMRZ Fonts - Digits
GText Alignment
GLetter Case - VIZ First Name
GLetter Case - VIZ Last Name
GPortrait Photo Detected
GAdditional Forgery Tests';

    }


    //----------------------------------------------------------------------------------
    //  Drivers License Check
    //----------------------------------------------------------------------------------

    public function getDriverLicenseCheck()
    {
        // TODO
        return 'G';
    }


    //----------------------------------------------------------------------------------
    //  Drivers License Details
    //----------------------------------------------------------------------------------

    public function getDriverLicenseDetails($check)
    {
        // TODO
        if(''<>'G') return '';
        return 'GValid number format
GDate of Birth
GValid From Date
GValid To Date
GCountry of Issue
GDate of Issue
GPhoto Present
GPassport Number Verified';
    }


    //----------------------------------------------------------------------------------
	//  Directorship
	//----------------------------------------------------------------------------------
	
	public function getDirectorshipCheck()
	{
		return 'G'; // TODO
	}


    //----------------------------------------------------------------------------------
    //  Directorship Details
    //----------------------------------------------------------------------------------

    public function getDirectorshipDetails()
    {
        /*  TODO: data built in file poc_directors.php. Where to call from?
5 = 'G3 Active Directorship(s) found:
GVOOSEARCH LTD, (06559695)
GPath IT LTD, (10070482)
GDRILL HALL SPORTS CLUB (ENFIELD) LIMITED (03413460)
G1 Company Secretary position(s) found:
GVOOSEARCH LTD, (06559695)',
*/
        return ' ';
    }


    //----------------------------------------------------------------------------------
	//  Credit Check
	//----------------------------------------------------------------------------------
	
	public function getCreditCheck()
	{
		$credit = $this->getSingleField("select credit_lines from id_checks where user_id=? and job_id=?",
			array($this->user_id, $this->job_id));
		$this->credit = $credit;
		switch ($credit)
		{
			case 'No Credit':	$c='R'; break;
			case null:			$c='-'; break;
			default:			$c='G';
		}
		return $c;
	}


    //----------------------------------------------------------------------------------
    //  Credit Check Details
    //----------------------------------------------------------------------------------

    public function getCreditCheckDetails($check)
    {
        if($check<>'G') return '';
        return 'GDetails verified by Credit Reference Agency
GLines of credit found';
    }



    //----------------------------------------------------------------------------------
	//  PEP
	//----------------------------------------------------------------------------------
	
	public function getPEPCheck()
	{
		$pep = $this->getSingleField("select pep from id_checks where user_id=? and job_id=?",
			array($this->user_id, $this->job_id));
		
		$c='G';
		if($pep==0)	$c='G';
		if($pep>0)	$c='R';
		if($pep===null)	$c='-';
		return $c;
	}


    //----------------------------------------------------------------------------------
    //  PEP Details
    //----------------------------------------------------------------------------------

    public function getPEPDetails()
    {
        $pep = $this->getSingleField("select pep from id_checks where user_id=? and job_id=?",
            array($this->user_id, $this->job_id));

        $msg='GNo political exposures found';
        if($pep==0)	$msg='GNo political exposures found';
        if($pep>0)	$msg="R{$pep} political exposure(s) found";
        if($pep===null)	$msg='-Unable to determine political exposure';
        return $msg;
    }


    //----------------------------------------------------------------------------------
	//  Sanctions
	//----------------------------------------------------------------------------------
	
	public function getSanctionsCheck()
	{
		$sanc= $this->getSingleField("select sanctions from id_checks where user_id=? and job_id=?",
			array($this->user_id, $this->job_id));

        $c='G';
        if($sanc==0)    $c='G';
        if($sanc>0)	    $c='R';
        if($sanc===null) $c='-';
        return $c;
	}


    //----------------------------------------------------------------------------------
    //  Sanctions Details
    //----------------------------------------------------------------------------------

    public function getSanctionsDetails()
    {
        $sanc= $this->getSingleField("select sanctions from id_checks where user_id=? and job_id=?",
            array($this->user_id, $this->job_id));

        $msg='GNo political sanctions or enforcements found';
        if($sanc==0)    $msg='GNo political sanctions or enforcements found';
        if($sanc>0)	    $msg="R{$sanc} political sanctions or enforcements found";
        if($sanc===null) $msg='-Unable to determine presence of political sanctions or enforcements';
        return $msg;
    }


    //----------------------------------------------------------------------------------
    //  Fetch employers name
    //----------------------------------------------------------------------------------

    public function getEmployerNameFromJobId()
	{
		$employer_id = $this->getSingleField("Select employer_id from jobs where uniqueid=?", array($this->job_id));
		$company = $this->getSingleField("Select company from employers where id=?", array($employer_id));
		return $company;
    }


    //----------------------------------------------------------------------------------
    //  Fetch Candidate Info (name, dob, email)
    //----------------------------------------------------------------------------------

    public function getCandidateInfo()
	{
		$dob = $this->getSingleField("Select dob from checked_details where userid=?",array($this->user_id));
		$dob = (empty($dob)) ? '(unknown)' : date("j M Y",strtotime($dob));
		
		$rec = $this->getSingleRecord("Select firstname,surname,line1,line2,town,county,postcode from users u left join address a on u.id = a.userid where u.id=?", 
			array($this->user_id));
		
		$address = $rec['line1'].', ';
		if(trim($rec['line2'])) $address .= $rec['line2'].', ';
		if(trim($rec['town'])) $address .= $rec['town'].', ';
		if(trim($rec['county'])) $address .= $rec['county'].', ';
		if(trim($rec['postcode'])) $address .= $rec['postcode'].', ';
		$address = substr($address,0,-2);
		$name = $rec['firstname'] . ' ' . $rec['surname'];

		$data = array(
			'name'	=> $name,
			'dob'	=> $dob,
			'address' => $address,
		);
		return $data;
	}
}