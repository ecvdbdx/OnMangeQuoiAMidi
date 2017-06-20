<?php
namespace AppBundle\Service;

use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class InfoProvider
{
    private $em;

    public function __construct(EntityManager $em){
        $this->em = $em;
    }

    /**
     * @return int
     */
    public function getPlaces()
    {

        $places = $this->em->getRepository('AppBundle:Place')->getNumberOfPlaces();

        if ($places) {
            return $places;
        } else {
            return 0;
        }
    }

    /**
     * @return int
     */
    public function getMeals()
    {

        $meals = $this->em->getRepository('AppBundle:Meal')->getNumberOfMeals();

        if ($meals) {
            return $meals;
        } else {
            return 0;
        }
    }

    /**
     * @return int
     */
    public function getMenus()
    {

        $menus = $this->em->getRepository('AppBundle:Menu')->getNumberOfMenus();

        if ($menus) {
            return $menus;
        } else {
            return 0;
        }
    }

    /**
     * @return \AppBundle\Entity\Place|null
     */
    public function getLatestCreatedPlace()
    {

        $latestCreatedPlace = $this->em->getRepository('AppBundle:Place')->getLatestCreatedPlace();

        if ($latestCreatedPlace) {
            return $latestCreatedPlace;
        } else {
            throw new NotFoundHttpException();
        }
    }

    /**
     * @return \AppBundle\Entity\Place|null
     */
    public function getLatestModifiedPlace()
    {

        $latestModifiedPlace = $this->em->getRepository('AppBundle:Place')->getLatestModifiedPlace();

        if ($latestModifiedPlace) {
            return $latestModifiedPlace;
        } else {
            throw new NotFoundHttpException();
        }
    }

    /**
     * @return int
     */
    public function getUsers()
    {
        $users = $this->em->getRepository('AppBundle:User')->getNumberOfUsers();

        if ($users) {
            return $users;
        } else {
            return 0;
        }
    }

    /**
     * @return array|null
     */
    public function getOrdersFromLastWeek()
    {
        $orders_from_last_week = array(
            array("name" => "Order this week", "data" => array())
        );

        for ($i = 6; $i >= 0; $i--) {
            $date = new \DateTime('-'. $i .' days');

            $orderThisDay = $this->em->getRepository('AppBundle:OrderGroup')->getNumberOfOrdersPerDay($date->format('Y'), $date->format('m'), $date->format('d'));

            $order_stats = array(
                'date' => $date,
                'orders' => (int)$orderThisDay,
            );

            $orders_from_last_week[0]['data'][] = $order_stats;
        }

        return $orders_from_last_week;
    }
}
