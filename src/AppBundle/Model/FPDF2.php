<?php
/*******************************************************************************
* FPDF2                                                                       *
*******************************************************************************/

namespace AppBundle\Model;

define('FPDF_VERSION','1.81');


class FPDF2 extends FPDF
{
	public $candidateName;
    public $dob;
    public $address;
    public $clientName;
	public $logo;
	public $backgroundColour;
	public $reportType;


    public function setHeaderFooterData($data)
    {
        $this->candidateName = $data['candidateName'];
        $this->dob = $data['dob'];
        $this->address = $data['address'];
        $this->clientName = $data['clientName'];
		$this->reportType = $data['reportType'];
	}

	
	function Header()
    {
		$r = hexdec(substr($this->backgroundColour,1,2));
		$g = hexdec(substr($this->backgroundColour,3,2));
		$b = hexdec(substr($this->backgroundColour,5,2));
		
		
        //$this->Image('images/hireabl-logo.jpg',130,10,70);
        $this->SetDrawColor($r, $g, $b);
		$this->SetFillColor($r, $g, $b);
		$this->Rect(0,0,220,30,'F');
		$this->Image("images/".$this->logo, 10,5,40);

        $this->SetDrawColor(0,0,0);
        $this->SetLineWidth(0.2);
        $this->Line(5,48,205,48);
        $this->Line(5,60,205,60);

        $this->SetFont('HFontMed','B',16);
        $this->SetTextColor(255,0,0);
        $this->Text(35,56,'CONFIDENTIAL :');
        $this->SetTextColor(0,0,0);
        $this->Text(85,56,'KYC / AML CHECK REPORT');
    }


    function Footer()
    {
        $this->SetTextColor(0,0,0);
        $this->SetFont('HFontLite','',10);
        $this->Text(20,288, 'Hireabl KYC / AML Check on behalf of: '.$this->clientName);
        $this->Text(170,288, date("d / M / Y"));
        $this->Text(20,293, 'Document Classification:');
        $this->SetTextColor(255,0,0);
        $this->Text(55,293, 'Confidential.');
		$this->SetTextColor(0,0,0);
		$this->Text(75,293, 'Report ID: ' . $this->reportType);
    }
}
