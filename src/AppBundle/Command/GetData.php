<?php
namespace AppBundle\Command;

use Doctrine\ORM\EntityManager;
use AppBundle\Entity\Place;
use AppBundle\Entity\Meal;
// use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;

class GetData
{
    private $em;

    public function __construct(EntityManager $em){
        $this->em = $em;
    }

    public function getPlaces()
    {

        $places = $this->em->getRepository('AppBundle:Place')->findAll();

        if ($places) {
            return $places;
        }
    }

    public function getMeals()
    {

        $meals = $this->em->getRepository('AppBundle:Meal')->findAll();

        if ($meals) {
            return $meals;
        }
    }
}
