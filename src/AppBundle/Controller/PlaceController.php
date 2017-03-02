<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\Place;
use AppBundle\Entity\Meal;
use AppBundle\Entity\Menu;
use AppBundle\Form\MealType;
use AppBundle\Form\MenuType;
use AppBundle\Repository\PlaceRepository;
use Ivory\GoogleMap\Map;
use Ivory\GoogleMap\Overlay\Marker;
use Ivory\GoogleMap\Base\Coordinate;
use Ivory\GoogleMap\Service\Geocoder\GeocoderService;
use Ivory\GoogleMap\Service\Serializer\SerializerBuilder;
use Http\Adapter\Guzzle6\Client;
use Http\Message\MessageFactory\GuzzleMessageFactory;
use Ivory\GoogleMap\Service\Geocoder\Request\GeocoderAddressRequest;

/**
 * Place controller.
 *
 * @Route("/place")
 */
class PlaceController extends Controller
{
    /**
     * Lists all Place entities.
     *
     * @Route("/", name="place_index")
     * @Method("GET")
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $places = $em->getRepository('AppBundle:Place')->findAll();

        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $places,
            $request->query->getInt('page', 1),
            4
        );

        $map = new Map();

        // Disable the auto zoom flag (disabled by default)
        $map->setAutoZoom(false);

        // Sets the center
        $map->setCenter(new Coordinate(44.841767, -0.574961));

        // Sets the zoom
        $map->setMapOption('zoom', 16);

        foreach ($places as $place) {
            $map->getOverlayManager()->addMarker(new Marker(new Coordinate($place->getLatitude(), $place->getLongitude())));
        }



        /***********************************************
         ************ Get address informations *********
         **********************************************/

        /*$geocoder = new GeocoderService(
            new Client(),
            new GuzzleMessageFactory(),
            SerializerBuilder::create()
        );

        $request = new GeocoderAddressRequest('4 - 6 Cours de l\'Intendance, Hôtel Pichon, 33000 Bordeaux');
        $response = $geocoder->geocode($request);*/

        return $this->render('place/index.html.twig', array(
            'pagination' => $pagination,
            'map' => $map
        ));
    }

    /**
     * Creates a new Place entity.
     *
     * @Route("/new", name="place_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $place = new Place();
        $form = $this->createForm('AppBundle\Form\PlaceType', $place);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $em->persist($place);

            $em->flush();

            $request->getSession()
                ->getFlashBag()
                ->add('success', 'New place saved in database.');

            return $this->redirectToRoute('place_show', array('id' => $place->getId()));
        }

        return $this->render('place/new.html.twig', array(
            'place' => $place,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Place entity.
     *
     * @Route("/{id}", name="place_show")
     * @Method({"GET", "POST"})
     */
    public function showAction(Request $request, Place $place)
    {
        $deleteForm = $this->createDeleteForm($place);

        $meal = new Meal();
        $meal->setPlace($place);
        $addMealForm = $this->createForm(MealType::class, $meal);
        $addMealForm->handleRequest($request);

        if ($addMealForm->isSubmitted() && $addMealForm->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $em->persist($meal);
            $em->flush();

            return $this->redirectToRoute('place_show', array('id' => $place->getId()));
        }

        $menu = new Menu();
        $menu->setPlace($place);
        $addMenuForm = $this->createForm(MenuType::class, $menu);
        $addMenuForm->handleRequest($request);

        // TODO: ADD THE MEALS TO THE MENU ENTITY
        if ($addMenuForm->isSubmitted() && $addMenuForm->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $em->persist($menu);
            $em->flush();

            return $this->redirectToRoute('place_show', array('id' => $place->getId()));
        }

        return $this->render('place/show.html.twig', array(
            'place' => $place,
            'delete_form' => $deleteForm->createView(),
            'add_meal_form' => $addMealForm->createView(),
            'add_menu_form' => $addMenuForm->createView()
        ));
    }

    /**
     * Displays a form to edit an existing Place entity.
     *
     * @Route("/{id}/edit", name="place_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Place $place)
    {
        $deleteForm = $this->createDeleteForm($place);

        $editForm = $this->createForm('AppBundle\Form\PlaceType', $place);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($place);
            $em->flush();

            return $this->redirectToRoute('place_edit', array('id' => $place->getId()));
        }

        return $this->render('place/edit.html.twig', array(
            'place' => $place,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Place entity.
     *
     * @Route("/{id}", name="place_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Place $place)
    {
        $form = $this->createDeleteForm($place);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($place);
            $em->flush();
        }

        return $this->redirectToRoute('place_index');
    }

    /**
     * Deletes a Meal entity.
     *
     * @Route("/mealdelete/{id}", name="meal_delete")
     */
    public function deleteMealAction(Request $request, Meal $meal)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:Meal')->find($meal);

        $idPlace = $entity->getPlace()->getId();

        $em->remove($entity);
        $em->flush();

        return $this->redirectToRoute('place_show', array('id' => $idPlace));
    }

    /**
     * Creates a form to delete a Place entity.
     *
     * @param Place $place The Place entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Place $place)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('place_delete', array('id' => $place->getId())))
            ->setMethod('DELETE')
            ->getForm();
    }
}
