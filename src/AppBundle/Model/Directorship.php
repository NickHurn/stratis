<?php

namespace AppBundle\Model;

class Directorship
{
    public $api_key = '-iz_bRZbnf4fdbQFMY1nL7eg1VqvRlkjRsne1qrW:';  // hard coded for testing only
    public $api_url = 'https://api.companieshouse.gov.uk';          // move to config after.


    public function __construct()
    {
        //$this->api_key = Zend_Registry::get('companies_house_api_key');
        //this->api_key = Zend_Registry::get('companies_house_api_url');
    }


    /**
     * @param $name
     * @return array company names
     */
    public function search($name)
    {
        $name = $this->sanitizeName($name);
        $url = null;
		$data = $this->curl_request("/search/officers?q=" . urlencode($name) . "&start_index=0&items_per_page=20");
		$result = array();
		foreach($data['items'] as $idx=>$d)
		{
			unset($r);
			$r['id'] = $idx;
			$r['address'] = $d['address_snippet'];
			$r['appointment_count'] = $d['appointment_count'];
			$r['title'] = $d['title'];
			$r['link'] = $d['links']['self'];
			$result[] = $r;
		}
		return $result;
    }

	
	//--------------------------------------------------------------
    //  Fetch appointments
    //--------------------------------------------------------------
	
	public function getAppointments($url)
    {
    	$data = $this->curl_request($url);
		//print "<pre>"; var_dump($data); die;
		$ret=[];
		foreach($data['items'] as $idx=>$a)
		{
			$rec = [];
			$rec['role'] = $a['officer_role'];
			$rec['companyName'] = $a['appointed_to']['company_name'];
			$rec['companyNumber'] = $a['appointed_to']['company_number'];
			$ret[] = $rec;
		}
        return $ret;
    }

	


	//--------------------------------------------------------------
    //  Sanitize name (keep only A-Z and space, make uppercase)
    //--------------------------------------------------------------

    private function sanitizeName($name)
    {
        $cleaned = strtoupper(preg_replace("/[^A-Z\s]+/i", "", $name));
        return $cleaned;
    }


    //--------------------------------------------------------------
    //  Sanitize postcode (Only A-Z, 0-9, uppercase, no spaces)
    //--------------------------------------------------------------

    private function sanitizePostcode($postcode)
    {
        $cleaned = strtoupper(preg_replace("/[^A-Z0-9]+/i", "", $postcode));
        return $cleaned;
    }


    //--------------------------------------------------------------
    //  Perform name match. Rules are:
    //  1. all names in source must exist in result
    //  2. first name in source must match first name in result
    //  3. last name in source much match last name in result
    //  4. middle names in source can appear in any order in result
    //--------------------------------------------------------------

    private function matchName($source,$result)
    {
        $src = explode(" ", $source);
        $res = explode(" ", $result);
        $src_last = count($src)-1;
        $res_last = count($res)-1;

        if($src[0] <> $res[0]) return false;
        if($src[$src_last] <> $res[$res_last]) return false;
        if(count($src)>2)
        {
            for($i=1; $i<count($src)-1; $i++)
            {
                if(!in_array($src[$i], $res)) return false;
            }
        }
        return true;
    }


    //--------------------------------------------------------------
    //  Makes the CURL request, and returns the API data
    //  as an associative array.
    //--------------------------------------------------------------

    private function curl_request($url)
    {
        $full_url = $this->api_url . $url;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $full_url);
        curl_setopt($ch, CURLOPT_USERPWD, $this->api_key);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HTTPGET, 1);
        $result = curl_exec($ch);
		$this->http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
		$json_result = json_decode($result,true);
        return $json_result;
    }
}
