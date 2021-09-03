<?php

namespace AppBundle\Model;
use Doctrine\ORM\EntityManagerInterface;

class Cameratag
{

    public $restapikey;
    public $formatids;
    public $cacert;



    public function __construct($restapi, $formatIds, $cacert)
    {
        $this->restapikey = $restapi;
        $this->formatids = [$formatIds];
        $this->cacert = $cacert;

    }

    public function createApp($name){

        $url = 'https://cameratag.com/api/v7/cameras.json';
        $fields = array(
            'api_key' => urlencode($this->restapikey),
            'camera[name]' => $name,
            'format_ids[]' => "335d6280-0e53-0131-0564-22000a8dafd5"
        );
        $fields_string = "";

//url-ify the data for the POST
        foreach($fields as $key=>$value) {
            $fields_string .= $key.'='.$value.'&';
        }

        $fields_string = substr($fields_string, 0, -1);

        $number = count($fields);
        $ch = curl_init();

        curl_setopt($ch,CURLOPT_URL, $url);
        curl_setopt($ch,CURLOPT_POST, $number);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_CAINFO, $this->cacert);
        curl_setopt($ch,CURLOPT_POSTFIELDS, $fields_string);

        $result = curl_exec($ch);
        if($result === false){
            echo 'Curl error: ' . curl_error($ch);
        }

        curl_close($ch);
        return $result;
    }

    public function getVideoData($id)
    {
        $url = 'https://cameratag.com/api/v8/videos/'.$id.'.json';
        $apikey = urlencode($this->restapikey);
        $result = file_get_contents($url.'/?api-key='.$apikey);
        return json_decode($result);
    }
}