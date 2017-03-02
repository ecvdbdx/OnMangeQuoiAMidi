<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\Place;
use AppBundle\Entity\Meal;
use AppBundle\Form\MealType;

/**
 * Place controller.
 *
 * @Route("/place/{place}/meal")
 */
class MealController extends Controller
{
    /**
     * Creates a new Meal for the Place.
     *
     * @Route("/new", name="place_meal_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request, Place $place)
    {
        $meal = new Meal();
        $meal->setPlace($place);

        $form = $this->createForm(MealType::class, $meal);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $em->persist($meal);
            $em->flush();

            $request->getSession()
                ->getFlashBag()
                ->add('success', 'New meal saved in database.');

            return $this->redirectToRoute('place_show', array('place' => $place->getId()));
        }

        return $this->render('meal/new.html.twig', array(
            'meal' => $meal,
            'form' => $form->createView(),
        ));
    }

    /**
     * Deletes a Meal entity.
     *
     * @Route("/delete/{meal}", name="meal_delete")
     */
    public function deleteAction(Request $request, Place $place, Meal $meal)
    {
        $em = $this->getDoctrine()->getManager();

        $em->remove($meal);
        $em->flush();

        $request->getSession()
            ->getFlashBag()
            ->add('success', 'Meal removed from database.');

        return $this->redirectToRoute('place_show', array('place' => $place->getId()));
    }
}
