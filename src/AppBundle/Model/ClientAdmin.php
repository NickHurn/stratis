<?php
namespace AppBundle\Model;

use AppBundle\Entity\ApplicantShare;
use AppBundle\Entity\CssSchemes;
use Doctrine\ORM\EntityManager;
use AppBundle\Entity\SkillsEmployer;

class ClientAdmin
{
    /**
     * @var EntityManager
     */
    private $em;
	private $logopath;

    /**
     * @var Whitelabel
     */
	private $whiteLabel;
	

    public function __construct($em, $logopath, $whiteLabel)
    {
            $this->em = $em;
			$this->logopath = $logopath;
			$this->whiteLabel = $whiteLabel;
    }

	
	//----------------------------------------------------------------------------------
	//  Execute query
	//----------------------------------------------------------------------------------
	
	private function execute($sql, $params=array())
	{
		$stmt = $this->em->getConnection()->executeQuery($sql, $params);
		if(strtoupper(substr($sql,0,6))=='SELECT')
			$recs = $stmt->fetchAll();
		else
			$recs = true;
		return $recs;
	}
	
	

	//----------------------------------------------------------------------------------
	//  Fetch basic client data
	//----------------------------------------------------------------------------------
	
    public function getBasicData($id)
    {
		$id = floor($id);
		$ret1 = $this->execute("select id, company as companyName from employers where id=$id");
		$ret2 = $this->execute("select id, firstname as firstName, surname, mobiletel as mobileNumber, emailaddress as emailAddress from users where employer_id=$id");
		$ret = $this->execute("select user_id from master_user where employer_id=$id");
		$userid = $ret[0]['user_id'];
		$ret3 = $this->execute("select line1,line2,town,county,postcode FROM address WHERE userid=$userid");

		$result = array_merge($ret1[0], $ret2[0], $ret3[0]);
		return $result;
	}

	
	//----------------------------------------------------------------------------------
	//  Save basic client data
	//----------------------------------------------------------------------------------
	
    public function saveBasicData($id,$data)
    {
		$em = $this->em;
		$sql = "update employers set company=? where id=?";
		$this->execute($sql, array($data['companyName'], $id));

		$sql = "update users set firstname=?, surname=?, mobiletel=?, emailaddress=? where employer_id=?";
		$this->execute($sql, array(
			$data['firstName'],
			$data['surname'],
			$data['mobileNumber'],
			$data['emailAddress'],
			$id,
		));


		//  Update or create the address record for this user
		$the_user = $this->em->getRepository('AppBundle:Users')->findOneBy(['id'=>$id]);
		$ad = $this->em->getRepository('AppBundle:Address')->findOneBy(['userid'=>$id]);
		if(!$ad) { $ad = new \AppBundle\Entity\Address(); }
		$ad->setUserid($the_user);
		$ad->setLine1($data['line1']);
		$ad->setLine2($data['line2']);
		$ad->setTown($data['town']);
		$ad->setCounty($data['county']);
		$ad->setPostCode($data['postcode']);
		$em->persist($ad);
		$em->flush();
	}	


	//----------------------------------------------------------------------------------
	//  Fetch basic client data
	//----------------------------------------------------------------------------------
	
    public function getWhitelabelData($id)
    {
		$id = floor($id);
		$ret1 = $this->execute("select employer_id, domain as domain1, company_name as companyName, footer_co_name as footerName, contact_number as contactNumber,"
			. "email_from as companyEmail, header_background as headerBackgroundColour, footer_background as footerBackgroundColour from css_schemes where employer_id=$id");
		if(!empty($ret1[0]))
		{
			$ret1[0]['domain1'] = strtr($ret1[0]['domain1'], array('https://'=>''));
			return $ret1[0];
		}
		return null;
	}

	
	//----------------------------------------------------------------------------------
	//  Save basic client data
	//----------------------------------------------------------------------------------
	
    public function saveWhitelabelData($id,$data)
    {
		$domain = $data['domain1'];

		$employer = $this->em->getRepository('AppBundle:Employers')->find($id);

        $cssScheme = $this->em->getRepository('AppBundle:CssSchemes')->findOneBy(['domain' => $domain]);
        if(is_null($cssScheme)){
            $cssScheme = new CssSchemes();
        }

		$filename = $domain . "_logo.png";
		$filename_full = $this->logopath . $filename;

		if(!empty($data['tmp_name']))
		{
			exec("convert -background none -resize 200x80 -gravity center -extent 200x80 {$data['tmp_name']} {$filename_full} ");
		}
		else
		{
			if(!file_exists($filename_full)) exec("cd {$this->logopath} && cp default_logo.png $filename");
		}

		$cssScheme->setFooterLogo($filename);
		$cssScheme->setHeaderLogo($filename);
		$cssScheme->setFooterLogoAdmin($filename);
		$cssScheme->setHeaderLogoAdmin($filename);

		
		$cssScheme->setEmployerId($employer);
		$cssScheme->setDomain($data['domain1']);
        $cssScheme->setCompanyName($data['companyName']);
        $cssScheme->setFooterCoName($data['footerName']);
        $cssScheme->setContactNumber($data['contactNumber']);
        $cssScheme->setEmailFrom($data['companyEmail']);
        $cssScheme->setHeaderBackground($data['headerBackgroundColour']);
        $cssScheme->setHeaderBackgroundAdmin($data['headerBackgroundColour']);
        $cssScheme->setFooterBackground($data['footerBackgroundColour']);
        $cssScheme->setFooterBackgroundAdmin($data['footerBackgroundColour']);
        $this->em->persist($cssScheme);
        $this->em->flush();

        //  Generate the error css file and write it out
        $error_css = "header\n";
        $error_css .= "{\n";
        $error_css .= "  background-color: {$data['headerBackgroundColour']};\n";
        $error_css .= "  background-image: url('/images/{$domain}_logo.png');\n";
        $error_css .= "  box-shadow: {$data['headerBackgroundColour']} 5px 5px 10px;\n";
        $error_css .= "}\n";
        //file_put_contents($this->csspath."{$domain}_error.css", $error_css);
        //file_put_contents($this->csspathzend."{$domain}_error.css", $error_css);

    }


	//----------------------------------------------------------------------------------
	//  Fetch client options data
	//----------------------------------------------------------------------------------
	
    public function getOptionsData($id)
    {
		$id = floor($id);
		$ret1 = $this->execute("select checkabl, testabl, personabl FROM section_defaults WHERE employer_id=$id");
		$ret2 = $this->execute("select gbg_organisation_id as dbs from employers where id=$id");
		$ret3 = $this->execute("select count(1) as cv from cv_check where employer_id=$id");
		if(empty($ret1[0])) $ret1[0]=array();
		if(empty($ret2[0])) $ret2[0]=array();
		if(empty($ret3[0])) $ret3[0]=array();
		
		if($ret2[0]['dbs']>0) $ret2[0]['dbs']=1;
		$result = array_merge($ret1[0], $ret2[0], $ret3[0]);
		foreach($result as $fld=>$val) {
			$result[$fld] = ($val==1) ? true:false;
		}
		return $result;
	}

	
	//----------------------------------------------------------------------------------
	//  Save client options data
	//----------------------------------------------------------------------------------
	
    public function saveOptionsData($id,$data)
    {
		foreach($data as $fld=>$val) {
			$data[$fld] = ($val==true) ? 1:0;
		}
		$data['dbs']=123;

		$sql = "update section_defaults set checkabl=?, testabl=?, personabl=? where employer_id=$id";
		$this->execute($sql, array(
			$data['checkabl'],
			$data['testabl'],
			$data['personabl']
		));

		$sql = "update employers set gbg_organisation_id = {$data['dbs']} where id=$id";
		$this->execute($sql);
		
		$this->execute("delete from cv_check where employer_id=$id");
		if($data['cv']==1) {
			$this->execute("insert ignore into cv_check (employer_id) values($id)");
		}
	}

}
