<?php
namespace AppBundle\Controller;

use AppBundle\Entity\OrderGroup;
use AppBundle\Entity\OrderUser;
use AppBundle\Entity\OrderMeal;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Validator\Constraints\Date;


/**
* OrderGroup controller.
*
* @Route("/orderUser")
*/
class OrderUserController extends Controller
{

  /**
  * create an order.
  *
  * @Route("/create", name="order_user_create")
  * @Method({"POST"})
  */
  public function createAction(Request $request)
  {
    $user = $this->getUser();
    $em = $this->getDoctrine()->getManager();
    $data = $request->get('order_user');
    if($user){
      $orderGroup = $em->getRepository('AppBundle:OrderGroup')->findOneByToken($data['order_group']);

      $orderUser = new OrderUser();
      $orderUser->setUser($user);
      $orderUser->setOrderGroup($orderGroup);
      $em->persist($orderUser);

      if(isset($data['meal'])){
        foreach ($data['meal'] as $meal_id => $quantity) {
          if($quantity){
            $meal = $em->getRepository('AppBundle:Meal')->find($meal_id);

            $orderMeal = new OrderMeal();
            $orderMeal->setQuantity($quantity);
            $orderMeal->setOrderUser($orderUser);
            $orderMeal->setMeal($meal);
            $em->persist($orderMeal);
          }
        }
      }
      if(isset($data['menu'])){
        foreach ($data['menu'] as $menu_id => $quantity) {
          if($quantity){
            $menu = $em->getRepository('AppBundle:Menu')->find($menu_id);

            $orderMenu = new OrderMenu();
            $orderMenu->setQuantity($quantity);
            $orderMenu->setOrderUser($orderUser);
            $orderMenu->setMenu($menu);
            $em->persist($orderMenu);
          }
        }
      }

      $em->flush();
    }
    return $this->redirectToRoute('order_group_show', array('uid' => $data['order_group']));
  }

}
