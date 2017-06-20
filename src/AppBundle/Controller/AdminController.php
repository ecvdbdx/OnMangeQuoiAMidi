<?php

namespace AppBundle\Controller;

use Symfony\Component\DependencyInjection\ContainerAware;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Ob\HighchartsBundle\Highcharts\Highchart;

/**
 * Admin controller.
 *
 * @Route("/admin")
 */
class AdminController extends Controller
{
    /**
     * @Route("/dashboard", name="dashboard")
     */
    public function dashboardAction()
    {
        $stats = [];

        $infoProvider = $this->container->get('infoProvider');
        $em = $this->getDoctrine()->getManager();

        $stats['number_of_users'] = $infoProvider->getUsers();
        $stats['number_of_places'] = $em->getRepository('AppBundle:Place')->getNumberOfPlaces();
        $stats['number_of_menus'] = $em->getRepository('AppBundle:Menu')->getNumberOfMenus();
        $stats['number_of_meals'] = $em->getRepository('AppBundle:Meal')->getNumberOfMeals();
        $stats['latest_created_place'] = $em->getRepository('AppBundle:Place')->getLatestCreatedPlace();
        $stats['latest_modified_place'] = $em->getRepository('AppBundle:Place')->getLatestModifiedPlace();

        $orders_by_day = array(
            array("name" => "Order this week", "data" => array())
        );

        for ($i = 6; $i >= 0; $i--) {
            $date = new \DateTime('-'. $i .' days');

            $orderThisDay = $em->getRepository('AppBundle:OrderGroup')->getNumberOfOrdersPerDay($date->format('Y'), $date->format('m'), $date->format('d'));

            $order_stats = array(
                'x' => $date->format('d'),
                'y' => (int)$orderThisDay,
                'name' => $date->format('d F Y')
            );

            $orders_by_day[0]['data'][] = $order_stats;
        }

        $orders_by_day_chart = new Highchart();
        $orders_by_day_chart->chart->renderTo('linechart');
        $orders_by_day_chart->xAxis->title(array('text' => "Day of week"));
        $orders_by_day_chart->yAxis->title(array('text' => "Orders"));
        $orders_by_day_chart->series($orders_by_day);

        return $this->render('admin/dashboard.html.twig', array(
            'stats' => $stats,
            'orders_by_day_chart' => $orders_by_day_chart
        ));
    }
}
