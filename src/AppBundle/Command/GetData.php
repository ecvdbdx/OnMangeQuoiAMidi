<?php
namespace AppBundle\Command;

// use Doctrine\ORM\EntityManager;
// use AppBundle\Entity\Place;
// use AppBundle\Entity\Meal;
// use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;
use AppBundle\Service\InfoProvider;

class GetData
{

    public function getPlaces(InfoProvider $infoProvider)
    {

        $places = $infoProvider->getPlaces();

        if ($places) {
            return $places;
        }
    }

    public function getMeals(InfoProvider $infoProvider)
    {

        $meals = $infoProvider->getMeals();
        if ($meals) {
            return $meals;
        }
    }
}
