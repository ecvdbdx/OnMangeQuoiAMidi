<?php

namespace Tests\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Client;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class OrderGroupControllerTest extends WebTestCase
{
    /**
     * @var Client
     */
    private $client = null;

    public function setUp()
    {
        $this->client = static::createClient();
    }

    public function testSubmitButtonWithoutBeingAuthenticated()
    {
        $route = $this->client->getContainer()->get('router')->generate('order_group_show', ['token' => '5947d492a52cc'], false);

        $crawler = $this->client->request('GET', $route);
        $this->assertEquals(404, $this->client->getResponse()->getStatusCode());

        // TODO If you want to test a specific OrderGroup, you must be sure it exists first
        /*$form = $crawler->filter('form')->form();
        $this->client->submit($form);
        $this->assertEquals(302, $this->client->getResponse()->getStatusCode());*/

    }

    // public function testSubmitButtonWithAuthentication()
    // {
    //
    //   $crawler = $this->client->request('GET', '/orderGroup/order?uid=5947d492a52cc', array(), array(), array(
    //     'PHP_AUTH_USER' => 'admin',
    //     'PHP_AUTH_PW'   => 'admin',
    //   ));
    //   $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
    //
    //   $form = $crawler->filter('form')->form();
    //   $this->client->submit($form);
    //   $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
    // }
}
