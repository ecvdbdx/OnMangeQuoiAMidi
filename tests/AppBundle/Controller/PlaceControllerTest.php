<?php

namespace Tests\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\BrowserKit\Cookie;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use AppBundle\Entity\User;

class PlaceControllerTest extends WebTestCase
{
  private $client = null;
  private $em = null;

  public function setUp()
  {
      $this->client = static::createClient();
      $this->em = self::$kernel->getContainer()->get('doctrine.orm.entity_manager');
  }

    public function testFixtures()
    {
        $route = $this->client->getContainer()->get('router')->generate('place_show', ['place' => 3], false);

        $this->client->request('GET', $route);

        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
    }

    public function testPlaceNewWithoutBeingAuthenticated()
    {
        $route = $this->client->getContainer()->get('router')->generate('place_new', array(), false);

        $this->client->request('GET', $route);

        $this->assertEquals(302, $this->client->getResponse()->getStatusCode());
    }

    public function testNaviagationToPlace()
    {
        $route = $this->client->getContainer()->get('router')->generate('place_index', [], false);
        $crawler = $this->client->request('GET', $route);
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());

        $link = $crawler->selectLink('Voir')->link();
        $crawler = $this->client->click($link);
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
    }

    public function testCreateAndRemovePlaceWithAuthentication()
    {
      $testUser = $this->client->getContainer()->get('testUser');
      $this->client = $testUser->createAuthorizedClient();

      $route = $this->client->getContainer()->get('router')->generate('place_new', array(), false);

      $crawler = $this->client->request('GET', $route);

      $this->assertEquals(200, $this->client->getResponse()->getStatusCode());

      $form = $crawler->filter('form[name="place"]')->form();
      $form->setValues(array(
              'place[name]' => 'mcdo',
              'place[description]' => 'test',
              'place[city]' => 'bordeaux',
              'place[street]' => 'sainte catherine',
              'place[zip_code]' => '33000',
              'place[country]' => 'France',
              'place[phone]' => '0659403459',
              'place[mobile]' => '0659403459',
              'place[email]' => 'mcdo@catherine.com',
              'place[website]' => 'mcdo.com',
              'place[facebook]' => 'mcdo',
            ));
      $this->client->submit($form);
      $crawler = $this->client->followRedirect();
      $this->assertEquals(200, $this->client->getResponse()->getStatusCode());

      $form = $crawler->filter('form[name="form"]')->form();
      $this->client->submit($form);
      $crawler = $this->client->followRedirect();
      $this->assertEquals(200, $this->client->getResponse()->getStatusCode());

      $testUser->removeTestClient($this->client);
    }

}
