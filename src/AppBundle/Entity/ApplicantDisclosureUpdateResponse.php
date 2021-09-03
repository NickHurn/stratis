<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Criteria;

/**
 * Address
 *
 * @ORM\Table(name="applicant_disclosure_update_response")
 * @ORM\Entity
 */
class ApplicantDisclosureUpdateResponse
{
	/**
     * @var integer
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    private $statusId;

    private $statusName;

    private $statusDate;

    private $messages;


}
