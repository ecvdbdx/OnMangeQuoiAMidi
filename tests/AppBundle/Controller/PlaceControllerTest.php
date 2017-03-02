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

    public function testPlaceNew()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/place/new');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }
}
