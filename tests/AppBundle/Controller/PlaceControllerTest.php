<?php

namespace Tests\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class PlaceControllerTest extends WebTestCase
{

    public function testFixtures()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/place/3');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    public function testPlaceNewWithoutBeingAuthenticated()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/place/new');

        $this->assertEquals(302, $client->getResponse()->getStatusCode());
    }

    public function testSubmitButton()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/place/3');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $form = $crawler->filter('form[name="order_group"]')->form();
        $client->submit($form);
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

}
