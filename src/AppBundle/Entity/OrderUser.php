<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * OrderUser
 *
 * @ORM\Table(name="order_user")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\OrderUserRepository")
 */
class OrderUser extends EntityInfos
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
     * @ORM\ManyToOne(targetEntity="OrderGroup", inversedBy="orderUsers")
     * @ORM\JoinColumn(name="order_group_id", referencedColumnName="id")
     */
    private $orderGroup;

    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="orderUsers")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    private $user;

    /**
     * @ORM\OneToMany(targetEntity="OrderMeal", mappedBy="orderUser")
     */
    private $orderMeals;

    /**
     * @ORM\OneToMany(targetEntity="OrderMenu", mappedBy="orderUser")
     */
    private $orderMenus;

    public function __construct()
    {
        $this->orderMeals = new ArrayCollection();
        $this->orderMenus = new ArrayCollection();
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
     * Get user
     *
     * @return \AppBundle\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set user
     *
     * @param \AppBundle\Entity\User $user
     *
     * @return OrderUser
     */
    public function setUser(User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get orderGroup
     *
     * @return OrderUser
     */
    public function getOrderGroup()
    {
        return $this->orderGroup;
    }

    /**
     * Set orderGroup
     *
     * @param \AppBundle\Entity\OrderGroup $orderGroup
     *
     * @return OrderUser
     */
    public function setOrderGroup(OrderGroup $orderGroup = null)
    {
        $this->orderGroup = $orderGroup;

        return $this;
    }

    /**
     * Get menu
     *
     * @return \AppBundle\Entity\OrderMenu
     */
    public function getOrderMenus()
    {
        return $this->orderMenus;
    }

    /**
     * Set menu
     *
     * @param \AppBundle\Entity\OrderMenu $orderMenus
     *
     * @return OrderUser
     */
    public function setOrderMenus(OrderMenu $orderMenus = null)
    {
        $this->orderMenus = $orderMenus;

        return $this;
    }

    /**
     * Get meals
     *
     * @return \AppBundle\Entity\OrderMeal
     */
    public function getOrderMeals()
    {
        return $this->orderMeals;
    }

    /**
     * Set meals
     *
     * @param \AppBundle\Entity\OrderMeal $orderMeals
     *
     * @return OrderUser
     */
    public function setOrderMeals(OrderMeal $orderMeals = null)
    {
        $this->orderMeals = $orderMeals;

        return $this;
    }
}
