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

        $orders_from_last_week = $infoProvider->getOrdersFromLastWeek();
        
        $formattedOrdersFromLastWeek = array(
            array("name" => "Order this week", "data" => array())
        );

        for ($i = 6; $i >= 0; $i--) {

            $date = $orders_from_last_week[0]['data'][$i]['date'];
            $orders = $orders_from_last_week[0]['data'][$i]['orders'];

            $order_stats = array(
                'x' => $date->format('d'),
                'y' => $orders,
                'name' => $date->format('d F Y')
            );

            $formattedOrdersFromLastWeek[0]['data'][] = $order_stats;
        }

        $orders_from_last_week_chart = new Highchart();
        $orders_from_last_week_chart->chart->renderTo('linechart');
        $orders_from_last_week_chart->xAxis->title(array('text' => "Day of week"));
        $orders_from_last_week_chart->yAxis->title(array('text' => "Orders"));
        $orders_from_last_week_chart->series($formattedOrdersFromLastWeek);

        return $this->render('admin/dashboard.html.twig', array(
            'stats' => $stats,
            'orders_from_last_week_chart' => $orders_from_last_week_chart
        ));
    }
}
