<?php
namespace AppBundle\Controller;

use AppBundle\Entity\OrderGroup;
use AppBundle\Entity\OrderMeal;
use AppBundle\Entity\OrderMenu;
use AppBundle\Entity\OrderUser;
use Doctrine\Common\Persistence\ObjectManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;


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
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function createAction(Request $request)
    {
        $user = $this->getUser();
        if ($user == null) {
            throw new AccessDeniedException();
        }

        $em = $this->getDoctrine()->getManager();
        $data = $request->get('order_user');

        $orderGroup = $em->getRepository('AppBundle:OrderGroup')->findOneBy(['token' => $data['order_group']]);

        if ($orderGroup == null) {
            throw new NotFoundHttpException();
        }

        $orderUser = new OrderUser();
        $orderUser->setUser($user)->setOrderGroup($orderGroup);

        $mustPersistOrderUser = $this->extractAndPersistMeals($data, $em, $orderUser);
        $mustPersistOrderUser |= $this->extractAndPersistMenus($data, $em, $orderUser);

        if ($mustPersistOrderUser) {
            $em->persist($orderUser);
        }

        $em->flush();

        return $this->redirectToRoute('order_group_show', array('uid' => $data['order_group']));
    }

    /**
     * @param $data
     * @param $em
     * @param $orderUser
     * @return array
     */
    protected function extractAndPersistMeals($data, ObjectManager $em, OrderUser $orderUser)
    {
        $mustPersistOrderUser = false;
        foreach ($data['meal'] as $meal_id => $quantity) {
            if ($quantity) {
                $meal = $em->getRepository('AppBundle:Meal')->find($meal_id);

                $orderMeal = new OrderMeal();
                $orderMeal->setQuantity($quantity);
                $orderMeal->setOrderUser($orderUser);
                $orderMeal->setMeal($meal);
                $em->persist($orderMeal);

                $mustPersistOrderUser = true;
            }
        }
        return $mustPersistOrderUser;
    }

    /**
     * @param $data
     * @param $em
     * @param $orderUser
     * @return bool
     */
    protected function extractAndPersistMenus($data, ObjectManager $em, OrderUser $orderUser)
    {
        $mustPersistOrderUser = false;
        foreach ($data['menu'] as $menu_id => $quantity) {
            if ($quantity) {
                $menu = $em->getRepository('AppBundle:Menu')->find($menu_id);

                $orderMenu = new OrderMenu();
                $orderMenu->setQuantity($quantity);
                $orderMenu->setOrderUser($orderUser);
                $orderMenu->setMenu($menu);
                $em->persist($orderMenu);

                $mustPersistOrderUser = true;
            }
        }
        return $mustPersistOrderUser;
    }

}
