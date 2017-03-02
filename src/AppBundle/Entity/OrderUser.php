<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * OrderUser
 *
 * @ORM\Table(name="order_user")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\OrderUserRepository")
 */
class OrderUser
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


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }
}

