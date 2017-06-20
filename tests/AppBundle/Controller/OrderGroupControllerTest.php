<?php

namespace Tests\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\BrowserKit\Cookie;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;

class OrderGroupControllerTest extends WebTestCase
{
    private $client = null;

    public function setUp()
    {
        $this->client = static::createClient();
    }

    public function testSubmitButtonWithoutBeingAuthenticated()
    {
        $crawler = $this->client->request('GET', '/orderGroup/order?uid=5947d492a52cc');
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());

        $form = $crawler->filter('form')->form();
        $this->client->submit($form);
        $this->assertEquals(302, $this->client->getResponse()->getStatusCode());

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
