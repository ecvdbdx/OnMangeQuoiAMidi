<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * OrderMenu
 *
 * @ORM\Table(name="order_menu")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\OrderMenuRepository")
 */
class OrderMenu extends EntityInfos
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
     * @ORM\ManyToOne(targetEntity="Menu", inversedBy="orderMenus")
     * @ORM\JoinColumn(name="menu_id", referencedColumnName="id")
     */
    private $menu;

    /**
     * @ORM\ManyToOne(targetEntity="OrderUser", inversedBy="orderMenus")
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
     * @return OrderMenu
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
     * Set menu
     *
     * @param \AppBundle\Entity\Menu $menu
     *
     * @return OrderMenu
     */
    public function setMenu(\AppBundle\Entity\Menu $menu = null)
    {
        $this->menu = $menu;

        return $this;
    }

    /**
     * Get menu
     *
     * @return \AppBundle\Entity\Menu
     */
    public function getMenu()
    {
        return $this->menu;
    }

    /**
     * Set orderUser
     *
     * @param \AppBundle\Entity\User $orderUser
     *
     * @return OrderMenu
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
