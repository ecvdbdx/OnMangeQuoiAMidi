<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * OrderMeal
 *
 * @ORM\Table(name="order_meal")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\OrderMealRepository")
 */
class OrderMeal
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
     * @var int
     *
     * @ORM\Column(name="quantity", type="integer")
     */
    private $quantity;

    /**
     * @ORM\ManyToOne(targetEntity="Meal", inversedBy="orderMeals")
     * @ORM\JoinColumn(name="meal_id", referencedColumnName="id")
     */
    private $meal;

    /**
     * @ORM\ManyToOne(targetEntity="OrderUser", inversedBy="orderMeals")
     * @ORM\JoinColumn(name="order_id", referencedColumnName="id")
     */
    private $orderUser;

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
     * Set quantity
     *
     * @param integer $quantity
     *
     * @return OrderMeal
     */
    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;

        return $this;
    }

    /**
     * Get quantity
     *
     * @return int
     */
    public function getQuantity()
    {
        return $this->quantity;
    }

    /**
     * Set meal
     *
     * @param \AppBundle\Entity\Meal $meal
     *
     * @return OrderMeal
     */
    public function setMeal(\AppBundle\Entity\Meal $meal = null)
    {
        $this->meal = $meal;

        return $this;
    }

    /**
     * Get meal
     *
     * @return \AppBundle\Entity\Meal
     */
    public function getMeal()
    {
        return $this->meal;
    }

    /**
     * Set orderUser
     *
     * @param \AppBundle\Entity\User $orderUser
     *
     * @return OrderMeal
     */
    public function setOrderUser(\AppBundle\Entity\OrderUser $orderUser = null)
    {
        $this->orderUser = $orderUser;

        return $this;
    }

    /**
     * Get orderUser
     *
     * @return \AppBundle\Entity\User
     */
    public function getOrderUser()
    {
        return $this->orderUser;
    }
}
