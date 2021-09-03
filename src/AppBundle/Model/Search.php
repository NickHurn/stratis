<?php

namespace AppBundle\Model;


use AppBundle\Entity\Users;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\ORM\EntityManager;

class Search
{

    /**
     *
     */
    private $em;

    /**
     * @var string
     */
    private $apiKey;

    /**
     * @var string
     */
    private $url;

    private $apiVersion = '2016-09-01';

    /**
     * @var string
     */
    private $adminKey;

    /**
     * @var $env string
     */
    private $env;

    /**
     * Search constructor.
     * @param EntityManager $em
     * @param $apiKey
     * @param $adminKey
     * @param $index
     * @param $env
     */

    public function __construct(EntityManager $em, $apiKey, $adminKey, $index, $env)
    {
        $this->em = $em;
        $this->apiKey = $apiKey;
        $this->adminKey = $adminKey;
        $this->url = 'https://doestheuk.search.windows.net/indexes/'.$index.'/docs/';
        $this->env = $env;
    }

    /**
     * @return string
     */
    public function getApiKey()
    {
        return $this->apiKey;
    }

    /**
     * @return string
     */
    public function getAdminKey()
    {
        return $this->adminKey;
    }

    public function indexApplicant(Users $applicant, $employerId)
    {
        $params = [
            "value" => [
                [
                    "@search.action" => "upload",
                    "id" => $applicant->getId().'-'.$employerId.'-'.$this->env,
                    'user_id'=>(string) $applicant->getId(),
                    "name" => $applicant->getName(),
                    "email" => $applicant->getEmailaddress(),
                    "employerId" => $employerId,
                    "env" => ($this->env),
                ]
            ]
        ];

        return $this->callAPI($params, 'index');
    }

    public function reIndexApplicants(ObjectManager $em, $delete = true)
    {

        $employers = $em->getRepository('AppBundle:Employers')->findAll();
        $message = [];
        foreach ($employers as $e){
            $applicants = $em->getRepository('AppBundle:Users')->getUsersByEmployerId($e->getId());

            $result = json_decode($this->search('*', $e->getId()), true);

            foreach($result['value'] as $search) {
                if ($delete === true) {
                    $message[] = 'Deleting Applicant ' . $search['id'] ;
                    $result = $this->deleteApplicants($search['id']);
                    //var_dump($result);
                }
            }

            foreach($applicants as $applicant){
                $message[] = 'Indexing Applicant ' . $applicant->getName();
                $result = $this->indexApplicant($applicant,$e->getId());
                //var_dump($result);

            }
        }


        return $message;
    }

    public function deleteApplicants($id)
    {
        $params = [
            "value" => [
                [
                    "@search.action" => "delete",
                    "id" => (string) $id,
                ]
            ]
        ];

        return $this->callAPI($params, 'index');
    }

    public function getSuggestion($string)
    {
        $params = [
            "search" => $string,
            "top" => 100,
            "suggesterName" => "doestheuk",
        ];
        return $this->callAPI($params, 'suggest');
    }

    public function search($string, $employerId)
    {
        $params = [
            "search" => $string,
            "filter" => "env eq '".$this->env."' and employerId eq ".$employerId,
            "top" => 100,
            "queryType" => "simple",
            "searchMode" => "any",
            "count" => true,
        ];

        return  $this->callAPI($params, 'search');
    }

    private function callAPI($params, $method)
    {
        $ch = curl_init();
        dump($params, $method, $this->url.$method);exit;
        //return (json_encode($params));
        // set URL and other appropriate options
        curl_setopt($ch, CURLOPT_URL, $this->url.$method.'?api-version='.$this->apiVersion);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: application/json","api-key: ".$this->adminKey));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($params));


        if( ! $result = curl_exec($ch))
        {
            trigger_error(curl_error($ch));
        }
        curl_close($ch);

        return $result;
    }




}
