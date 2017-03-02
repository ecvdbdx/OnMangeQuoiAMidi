<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\Place;
use AppBundle\Entity\Menu;
use AppBundle\Form\MenuType;

/**
 * Place controller.
 *
 * @Route("/place/{place}/menu")
 */
class MenuController extends Controller
{
    /**
     * Creates a new Menu for the Place.
     *
     * @Route("/new", name="place_menu_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request, Place $place)
    {
        $menu = new Menu();
        $menu->setPlace($place);

        $form = $this->createForm(MenuType::class, $menu);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $em->persist($menu);
            $em->flush();

            $request->getSession()
                ->getFlashBag()
                ->add('success', 'New menu saved in database.');

            return $this->redirectToRoute('place_show', array('place' => $place->getId()));
        }

        return $this->render('menu/new.html.twig', array(
            'menu' => $menu,
            'form' => $form->createView(),
        ));
    }

    /**
     * Deletes a Menu entity.
     *
     * @Route("/delete/{menu}", name="menu_delete")
     */
    public function deleteAction(Request $request, Place $place, Menu $menu)
    {
        $em = $this->getDoctrine()->getManager();

        $em->remove($menu);
        $em->flush();

        $request->getSession()
            ->getFlashBag()
            ->add('success', 'Menu removed from database.');

        return $this->redirectToRoute('place_show', array('place' => $place->getId()));
    }
}
