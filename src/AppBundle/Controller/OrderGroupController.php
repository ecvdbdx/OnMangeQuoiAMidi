<?php
namespace AppBundle\Controller;

use AppBundle\Entity\OrderGroup;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Validator\Constraints\Date;

/**
 * OrderGroup controller.
 *
 * @Route("/orderGroup")
 */
class OrderGroupController extends Controller
{
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
            $place = $em->getRepository('AppBundle:Place')->find($place_id);

            $date = new \DateTime();
            $token = uniqid();
            $orderGroup->setToken($token);
            $orderGroup->setExpirationDate($date);
            $orderGroup->setPlace($place);
            $orderGroup->setUser($user);
            //$orderGroup->setPlace($place);
            $em->persist($orderGroup);
            $em->flush();
        return new JsonResponse($token, 200);
        } else {
            $user = "T'es pas connecté, connard.";
        }
    }
}