<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Employers
 *
 * @ORM\Table(name="web_hook_log")
 * @ORM\Entity
 */
class WebHookLog
{
    /**
     * @var int
     * @ORM\Column(name="employer_id", type="integer", nullable=false)
     */
    private $employer;

    /**
     * @var string
     * @ORM\Column(name="url", type="string", length=255, nullable=false)
     */
    private $url;

    /**
     * @var string
     * @ORM\Column(name="job_id", type="string", length=36, nullable=false)
     */
    private $job;

    /**
     * @var int
     * @ORM\Column(name="user_id", type="integer", nullable=false)
     */
    private $user;

    /**
     * @var int
     * @ORM\Column(name="status", type="string", length=50, nullable=false)
     */
    private $status;

    /**
     * @var string
     * @ORM\Column(name="response", type="text", nullable=false)
     */
    private $response;



    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @return int
     */
    public function getEmployer()
    {
        return $this->employer;
    }

    /**
     * @param int $employer
     * @return WebHookLog
     */
    public function setEmployer($employer)
    {
        $this->employer = $employer;
        return $this;
    }

    /**
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @param string $url
     * @return WebHookLog
     */
    public function setUrl($url)
    {
        $this->url = $url;
        return $this;
    }

    /**
     * @return string
     */
    public function getJob()
    {
        return $this->job;
    }

    /**
     * @param string $job
     * @return WebHookLog
     */
    public function setJob($job)
    {
        $this->job = $job;
        return $this;
    }

    /**
     * @return int
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param int $user
     * @return WebHookLog
     */
    public function setUser($user)
    {
        $this->user = $user;
        return $this;
    }

    /**
     * @return int
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param int $status
     * @return WebHookLog
     */
    public function setStatus($status)
    {
        $this->status = $status;
        return $this;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return WebHookLog
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string
     */
    public function getResponse()
    {
        return $this->response;
    }

    /**
     * @param string $response
     * @return WebHookLog
     */
    public function setResponse($response)
    {
        $this->response = $response;
        return $this;
    }





}
