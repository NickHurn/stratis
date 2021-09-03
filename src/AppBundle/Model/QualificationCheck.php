<?php

namespace AppBundle\Model;


use ApiBundle\Entity\Users;
use AppBundle\Entity\CcResponse;
use AppBundle\Entity\Checks;
use AppBundle\Entity\CleanerPayment;
use AppBundle\Entity\ConsentImport;
use AppBundle\Entity\QualificationChecks;
use AppBundle\Entity\SalaryFileData;
use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;

class QualificationCheck {

    private $url;
    private $username;
    private $password;
    private $token;
    private $em;

    /**
     * @var Session
     */
    private $session;

    /**
     * @return mixed
     */
    public function getToken()
    {
        return $this->token;
    }

    /**
     * @param mixed $token
     * @return QualificationCheck
     */
    public function setToken($token)
    {
        $this->token = $token;
        return $this;
    }



    public function __construct($qlUrl, $username, $password, EntityManager $em, $session)
    {
        $this->url = $qlUrl;
        $this->username = $username;
        $this->password = $password;
        $this->em = $em;
        $this->token = null;

    }

    public function authenticate()
    {
        if(is_null($this->token)) {
           $params = ["password" => $this->password, "username" => $this->username];
           $result = $this->callAuthenticateAPI($params, '/v1/auth');
           if(isset($result['x-auth-token'])){
               $this->token = $result['x-auth-token'][0];
               return true;
           } else {
               return false;
           }
        }
    }


    public function searchInstitute($name)
    {
        $params = [

                'name' => $name,
                'page' => 0,
                'size' => 50
            ];

        $result = json_decode($this->callAPI($params, '/v1/institute/summary'), true);
        if(!isset($result['content'])){
            return $result;
        } else {
            return $result['content'];
        }

    }

    public function getInstitute($instituteId)
    {
        $params = [];
        $result = json_decode($this->callAPI($params, '/v1/institute/detail/'.$instituteId), true);

       return $result;

    }

    public function refreshStatus($id)
    {
        $params = [];
        $result = json_decode($this->callAPI($params, '/v1/verification/'.$id), true);
        return $result;

    }


    public function submitVerification(QualificationChecks $checks, $institute)
    {

        $params = [];

        $data = [

                'firstname' => $checks->getFirstName(),
                'surname' => $checks->getLastName(),
                'dob' => $checks->getDob()->format('Y-m-d'),
                'gender' => strtoupper($checks->getGender()),
                'studentId' => $checks->getStudentId(),
                'email' => $checks->getEmail(),
                'course' => $checks->getCourseTitle(),
                'qual' => $checks->getAward(),
                'classi' => $checks->getGrade(),
                'membership' => $checks->getMembership(),
                'enrolYear' => $checks->getEnrolment(),
                'gradYear' => $checks->getGraduated(),
                'additional'=> '',
        ];


        foreach($institute['fields'] as $field){
            $params['fields'][$field['key']] = $data[$field['key']];
        }

        $params['instituteId'] = $checks->getInstituteId();

        return $this->callPostAPI($params, '/v1/verification');
    }

    public function postConsent($fullPath, ConsentImport $file, $fileName, $applicationId)
    {
        // Create a CURLFile object / procedural method


        $path = $fullPath;
        $fContents = file_get_contents($path);
        $base64 = base64_encode($fContents);

        $postfields = [
            'name' => $file->getName(),
            'data' => "$base64"
        ];



        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->url.'/v1/verification/'.$applicationId.'/document');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        curl_setopt($ch, CURLOPT_POST, TRUE);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($postfields));
        curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: application/json", "X-AUTH-TOKEN: ". $this->token ));

        $result = curl_exec($ch);
        curl_close($ch);


        /*
        $cfile = curl_file_create($fullPath,$file->getMimeType(),$fileName); // try adding
        $imgdata = array('file' => $cfile, 'name' => $file->getName());
        curl_setopt($ch, CURLOPT_URL, $this->url.'/v1/verification/'.$applicationId.'/document');
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array("X-AUTH-TOKEN: ". $this->token, "Content-Type: multipart/form-data"));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $imgdata);
        $result = curl_exec($ch);
        if($errno = curl_errno($result)) {
            $error_message = curl_strerror($errno);
            echo "cURL error ({$errno}):\n {$error_message}";
        }
        curl_close($ch);
        */

        return $result;

    }


    private function callAuthenticateAPI($params, $method)
    {
        $headers = [];
        $ch = curl_init();
        // set URL and other appropriate options
	
        curl_setopt($ch, CURLOPT_URL, $this->url.$method);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: application/json"));
        curl_setopt($ch, CURLOPT_HEADERFUNCTION,
            function($curl, $header) use (&$headers)
            {
                $len = strlen($header);
                $header = explode(':', $header, 2);
                if (count($header) < 2) // ignore invalid headers
                    return $len;

                $name = strtolower(trim($header[0]));
                if (!array_key_exists($name, $headers))
                    $headers[$name] = [trim($header[1])];
                else
                    $headers[$name][] = trim($header[1]);

                return $len;
            }
        );
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);

        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($params));
        curl_exec($ch);

        curl_close($ch);
        return $headers;
    }

    private function callAPI($params, $method)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->url.$method.(count($params)>0 ? '?'.http_build_query($params) : ''));
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array("X-AUTH-TOKEN: ". $this->token));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);


        if( ! $result = curl_exec($ch))
        {
            trigger_error(curl_error($ch));
        }
        curl_close($ch);


        return $result;
    }

    private function callPostAPI($params, $method)
    {

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->url.$method);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array("X-AUTH-TOKEN: ". $this->token, "Content-Type: application/json"));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);

        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($params));

        $result = curl_exec($ch);

        curl_close($ch);
        return $result;
    }

}
