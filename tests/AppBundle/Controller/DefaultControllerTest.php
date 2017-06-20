<?php

namespace Tests\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DefaultControllerTest extends WebTestCase
{
    public function testIndex()
    {
        $client = static::createClient();

        $route = $client->getContainer()->get('router')->generate('homepage', array(), false);

        $crawler = $client->request('GET', $route);

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertEquals('On mange quoi à midi ?', $crawler->filter('.site-title')->text());
    }
}
