<?php

namespace Tests\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class PlaceControllerTest extends WebTestCase
{

    public function testFixtures()
    {
        $client = static::createClient();

        $route = $client->getContainer()->get('router')->generate('place_show', ['place' => 3], false);

        $client->request('GET', $route);

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    public function testPlaceNewWithoutBeingAuthenticated()
    {
        $client = static::createClient();

        $route = $client->getContainer()->get('router')->generate('place_new', array(), false);

        $client->request('GET', $route);

        $this->assertEquals(302, $client->getResponse()->getStatusCode());
    }

}
