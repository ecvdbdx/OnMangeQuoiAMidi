<?php

namespace AppBundle\Controller;

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

        $em = $this->getDoctrine()->getManager();

        $stats['number_of_users'] = $em->getRepository('AppBundle:User')->getNumberOfUsers();
        $stats['number_of_places'] = $em->getRepository('AppBundle:Place')->getNumberOfPlaces();
        $stats['number_of_menus'] = $em->getRepository('AppBundle:Menu')->getNumberOfMenus();
        $stats['number_of_meals'] = $em->getRepository('AppBundle:Meal')->getNumberOfMeals();

        //
        $orders_by_day = array(
            array("name" => "Order this week", "data" => array(1, 2, 4, 5, 6, 3, 8))
        );

        $orders_by_day_chart = new Highchart();
        $orders_by_day_chart->chart->renderTo('linechart');  // The #id of the div where to render the chart
//        $orders_by_day_chart->title->text('Orders this week');
        $orders_by_day_chart->xAxis->title(array('text' => "Orders"));
        $orders_by_day_chart->yAxis->title(array('text' => "Day of week"));
        $orders_by_day_chart->series($orders_by_day);

        return $this->render('admin/dashboard.html.twig', array(
            'stats' => $stats,
            'orders_by_day_chart' => $orders_by_day_chart
        ));
    }
}
