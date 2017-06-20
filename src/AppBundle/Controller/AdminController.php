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

        $stats['number_of_users'] = $infoProvider->getUsers();
        $stats['number_of_places'] = $infoProvider->getPlaces();
        $stats['number_of_menus'] = $infoProvider->getMenus();
        $stats['number_of_meals'] = $infoProvider->getMeals();
        $stats['latest_created_place'] = $infoProvider->getLatestCreatedPlace();
        $stats['latest_modified_place'] = $infoProvider->getLatestModifiedPlace();

        $orders_by_day = $infoProvider->getOrdersByDay();
        
        $formattedOrdersByDay = array(
            array("name" => "Order this week", "data" => array())
        );

        for ($i = 6; $i >= 0; $i--) {

            $date = $orders_by_day[0]['data'][$i]['date'];
            $orders = $orders_by_day[0]['data'][$i]['orders'];

            $order_stats = array(
                'x' => $date->format('d'),
                'y' => $orders,
                'name' => $date->format('d F Y')
            );

            $formattedOrdersByDay[0]['data'][] = $order_stats;
        }

        $orders_by_day_chart = new Highchart();
        $orders_by_day_chart->chart->renderTo('linechart');
        $orders_by_day_chart->xAxis->title(array('text' => "Day of week"));
        $orders_by_day_chart->yAxis->title(array('text' => "Orders"));
        $orders_by_day_chart->series($formattedOrdersByDay);

        return $this->render('admin/dashboard.html.twig', array(
            'stats' => $stats,
            'orders_by_day_chart' => $orders_by_day_chart
        ));
    }
}
