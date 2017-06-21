<?php
namespace AppBundle\Controller;

use AppBundle\Entity\OrderGroup;
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
   * @Method({"GET"})
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

    /**
     * Creates a command
     *
     * @Route("/orderz", name="create_order")
     * @Method("GET")
     */
    public function ajaxAction(Request $request) {
        $user = $this->getUser();
        $em = $this->getDoctrine()->getManager();
        if($user) {
            $orderGroup = new OrderGroup();

            $place_id = $request->get('place_id');
            $expiration_date = $request->get('expiration_date');
            $expiration_date = str_replace('/', '-', $expiration_date);
            $formatted_expiration_date = new \DateTime($expiration_date, new \DateTimeZone('Europe/Paris'));

            $now = new \DateTime("now", new \DateTimeZone('Europe/Paris'));
            $now->modify('+2 hour');

            if ($formatted_expiration_date >= $now) {

              $place = $em->getRepository('AppBundle:Place')->find($place_id);

              $token = uniqid();

              $orderGroup->setToken($token);
              $orderGroup->setExpirationDate($formatted_expiration_date);
              $orderGroup->setPlace($place);
              $orderGroup->setUser($user);
              $em->persist($orderGroup);
              $em->flush();

              return new JsonResponse($token);

            }
            else {
              return new JsonResponse('EH NON !');
            }
            
        } else {
            return new JsonResponse(false);
        }
    }
}
