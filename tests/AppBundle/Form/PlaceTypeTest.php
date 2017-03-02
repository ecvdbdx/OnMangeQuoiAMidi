<?php

namespace Tests\AppBundle\Form\Type;

use AppBundle\Form\PlaceType;
use AppBundle\Entity\Place;
use Symfony\Component\Form\Test\TypeTestCase;

class PlaceTypeTest extends TypeTestCase
{
    public function testSubmitValidData()
    {
        $formData = array(
            'name' => 'Resto test',
            'description' => 'Test description body',
            'city' => 'Bordeaux',
            'street' => 'Cours de l\'Intendance',
            'zip_code' => '33000',
            'country' => 'France',
            'phone' => '0556798381',
            'mobile' => '0656798381',
            'email' => 'test@test.com',
            'website' => 'http://test.com',
            'facebook' => 'http://facebook.com/test',
        );

        $form = $this->factory->create(PlaceType::class);

        $place = new Place();
        $place->setName($formData['name'])
             ->setDescription($formData['description'])
             ->setCity($formData['city'])
             ->setStreet($formData['street'])
             ->setZipCode($formData['zip_code'])
             ->setCountry($formData['country'])
             ->setPhone($formData['phone'])
             ->setMobile($formData['mobile'])
             ->setEmail($formData['email'])
             ->setWebsite($formData['website'])
             ->setFacebook($formData['facebook']);

        // submit the data to the form directly
        $form->submit($formData);

        $this->assertTrue($form->isSynchronized());
        $this->assertEquals($place, $form->getData());

        $view = $form->createView();
        $children = $view->children;

        foreach (array_keys($formData) as $key) {
            $this->assertArrayHasKey($key, $children);
        }
    }

    public function testSubmitNullData()
    {
        $formData = array(
            'name' => null,
            'description' => null,
            'city' => null,
            'street' => null,
            'zip_code' => null,
            'country' => null,
            'phone' => null,
            'mobile' => null,
            'email' => null,
            'website' => null,
            'facebook' => null,
        );

        $form = $this->factory->create(PlaceType::class);

        $place = new Place();

        // submit the data to the form directly
        $form->submit($formData);

        $this->assertTrue($form->isSynchronized());
        $this->assertEquals($place, $form->getData());

        $view = $form->createView();
        $children = $view->children;

        foreach (array_keys($formData) as $key) {
            $this->assertArrayHasKey($key, $children);
        }
    }
}