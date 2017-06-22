<?php
namespace AppBundle\Controller;

use AppBundle\Entity\OrderGroup;
use AppBundle\Form\OrderGroupType;
use AppBundle\Form\OrderGroupNoJsType;
use Doctrine\Common\Persistence\ObjectManager;
use Http\Discovery\Exception\NotFoundException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * OrderGroup controller.
 *
 * @Route("/orderGroup")
 */
class OrderGroupController extends Controller
{

  /**
   * Finds and displays an OrderGroup entity.
   *
   * @Route("/order/{token}", name="order_group_show")
   * @Method({"GET", "POST"})
   */
   public function showAction($token)
   {
       $em = $this->getDoctrine()->getManager();
       $orderGroup = $em->getRepository('AppBundle:OrderGroup')->findOneBy(['token' => $token]);
       if($orderGroup == null) {
           throw new NotFoundHttpException();
       }

       return $this->render('place/order_create.html.twig', array(
         'orderGroup' => $orderGroup
       ));
     }
}
