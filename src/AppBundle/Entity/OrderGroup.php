<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * OrderGroup
 *
 * @ORM\Table(name="order_group")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\OrderGroupRepository")
 */
class OrderGroup
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="expiration_date", type="datetimetz")
     */
    private $expirationDate;

    /**
     * @var string
     *
     * @ORM\Column(name="token", type="string", length=255, unique=true)
     */
    private $token;

    /**
     * @ORM\OneToMany(targetEntity="OrderUser", mappedBy="orderGroup")
     */
    private $orderUsers;

    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="orderGroups")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity="Place", inversedBy="orderGroups")
     * @ORM\JoinColumn(name="place_id", referencedColumnName="id")
     */
    private $place;

    public function __construct()
    {
        $this->orderUsers = new ArrayCollection();
    }

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set expirationDate
     *
     * @param \DateTime $expirationDate
     *
     * @return OrderGroup
     */
    public function setExpirationDate($expirationDate)
    {
        $this->expirationDate = $expirationDate;

        return $this;
    }

    /**
     * Get expirationDate
     *
     * @return \DateTime
     */
    public function getExpirationDate()
    {
        return $this->expirationDate;
    }

    /**
     * Set token
     *
     * @param string $token
     *
     * @return OrderGroup
     */
    public function setToken($token)
    {
        $this->token = $token;

        return $this;
    }

    /**
     * Get token
     *
     * @return string
     */
    public function getToken()
    {
        return $this->token;
    }

    /**
     * Add orderUser
     *
     * @param \AppBundle\Entity\OrderUser $orderUser
     *
     * @return OrderGroup
     */
    public function addOrderUser(\AppBundle\Entity\OrderUser $orderUser)
    {
        $this->orderUsers[] = $orderUser;

        return $this;
    }

    /**
     * Remove orderUser
     *
     * @param \AppBundle\Entity\OrderUser $orderUser
     */
    public function removeOrderUser(\AppBundle\Entity\OrderUser $orderUser)
    {
        $this->orderUsers->removeElement($orderUser);
    }

    /**
     * Get orderUsers
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getOrderUsers()
    {
        return $this->orderUsers;
    }

    /**
     * Set user
     *
     * @param \AppBundle\Entity\User $user
     *
     * @return OrderGroup
     */
    public function setUser(\AppBundle\Entity\User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \AppBundle\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set place
     *
     * @param \AppBundle\Entity\Place $place
     *
     * @return OrderGroup
     */
    public function setPlace(\AppBundle\Entity\Place $place = null)
    {
        $this->place = $place;

        return $this;
    }

    /**
     * Get place
     *
     * @return \AppBundle\Entity\Place
     */
    public function getPlace()
    {
        return $this->place;
    }
}
