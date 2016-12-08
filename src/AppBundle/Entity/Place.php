<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use AppBundle\Entity\Meal;
use Doctrine\ORM\Mapping as ORM;

/**
 * Place
 *
 * @ORM\Table(name="place")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\PlaceRepository")
 */
class Place
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
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * One Place has Many Meals.
     *
     * @var ArrayCollection
     * @ORM\OneToMany(targetEntity="Meal", mappedBy="place", cascade={"persist", "remove"})
     */
    private $meals;

    /**
     * @return ArrayCollection
     */
    public function getMeals()
    {
        return $this->meals;
    }

    /**
     * @param Meal $meal
     * @return Place
     */
    public function addMeal($meal)
    {
        if(!$this->getMeals()->contains($meal)){
            $meal->setPlace($this);
            $this->meals->add($meal);
        }
        return $this;
    }

    /**
     * @param Meal $meal
     * @return Place
     */
    public function removeMeal($meal)
    {
        if(!$this->getMeals()->contains($meal)){
            $this->meals->removeElement($meal);
        }
        return $this;
    }

    /**
     * @param mixed $meals
     * @return Place
     */
    public function setMeals($meals)
    {
        $this->meals = $meals;
        return $this;
    }

    public function __construct()
    {
        $this->meals = new ArrayCollection();
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
     * Set name
     *
     * @param string $name
     *
     * @return Place
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }
}

