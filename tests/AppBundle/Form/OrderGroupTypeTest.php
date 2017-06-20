<?php

namespace Tests\AppBundle\Form\Type;

use AppBundle\Form\OrderGroupType;
use AppBundle\Entity\OrderGroup;
use Symfony\Component\Form\Test\TypeTestCase;

class OrderGroupTypeTest extends TypeTestCase
{
    public function testSubmitValidData()
    {
        $formData = array(
            'expirationDate' => new \DateTime('now')
        );

        $form = $this->factory->create(OrderGroupType::class);

        $orderGroup = new OrderGroup();
        $orderGroup->setExpirationDate($formData['expirationDate']);

        // submit the data to the form directly
        $form->submit($formData);

        $this->assertTrue($form->isSynchronized());
        $this->assertEquals($orderGroup, $form->getData());

        $view = $form->createView();
        $children = $view->children;

        foreach (array_keys($formData) as $key) {
            $this->assertArrayHasKey($key, $children);
        }
    }

    public function testSubmitNullData()
    {
        $formData = array(
            'expirationDate' => null,
        );

        $form = $this->factory->create(OrderGroupType::class);

        $orderGroup = new OrderGroup();

        // submit the data to the form directly
        $form->submit($formData);

        $this->assertTrue($form->isSynchronized());
        $this->assertEquals($orderGroup, $form->getData());

        $view = $form->createView();
        $children = $view->children;

        foreach (array_keys($formData) as $key) {
            $this->assertArrayHasKey($key, $children);
        }
    }
}
