<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * UsersRoles
 *
 * @ORM\Table(name="users_roles")
 * @ORM\Entity
 */
class UsersRoles
{
    /**
     * @var integer
	 * @ORM\Id
	 * @ORM\Column(name="users_id", type="integer")
     */
	private $usersId;
				
    
    /**
     * @var integer
     * @ORM\Id
	 * @ORM\Column(name="role_id", type="integer")
     */
	private $roleId;
				

	
    /**
     * Set users_id
	 * @param integer $users_id
	 * @return Users_roles
     */
	public function setUsersId($value)
    {
		$this->usersId = $value;
        return $this;
    }

    /**
     * Get users_id
	 * @return integer
     */
    public function getUsersId()
    {
		return $this->usersId;
    }


	
    /**
     * Set role_id
	 * @param integer $role_id
	 * @return Users_roles
     */
	public function setRoleId($value)
    {
		$this->roleId = $value;
        return $this;
    }

    /**
     * Get role_id
	 * @return integer
     */
    public function getRoleId()
    {
		return $this->roleId;
    }
}
