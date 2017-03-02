<?php
// src/AppBundle/Entity/User.php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="fos_user")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\UserRepository")
 */
class User extends BaseUser
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\OneToMany(targetEntity="OrderUser", mappedBy="user")
     */
    private $orderUsers;

    /**
     * @ORM\OneToMany(targetEntity="OrderGroup", mappedBy="user")
     */
    private $orderGroups;


    public function __construct()
    {

        parent::__construct();
        $this->orderUsers = new ArrayCollection();
        $this->orderGroups = new ArrayCollection();
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
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return ArrayCollection
     */
    public function getOrderUsers()
    {
        return $this->orderUsers;
    }

    /**
     * @param OrderUser $orderUser
     */
    public function addOrderUser($orderUser)
    {
        $this->orderUsers->add($orderUser);
    }

    /**
     * @param OrderUser $orderUser
     */
    public function removeOrderUser($orderUser)
    {
        $this->orderUsers->remove($orderUser);
    }

    /**
     * @return mixed
     */
    public function getOrderGroups()
    {
        return $this->orderGroups;
    }

    /**
     * @param mixed $orderGroups
     */
    public function addOrderGroup($orderGroup)
    {
        $this->orderGroups->add($orderGroup);
    }

    /**
     * @param mixed $orderGroups
     */
    public function removeOrderGroup($orderGroup)
    {
        $this->orderGroups->remove($orderGroup);
    }
}