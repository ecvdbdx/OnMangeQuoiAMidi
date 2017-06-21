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

  public function createAuthorizedClient()
  {
      $this->client = static::createClient();
      $container = static::$kernel->getContainer();
      $session = $container->get('session');

      $user = new User();
      $user->setUsername('testuser');
      $user->setEmail('testuser@email.com');
      $user->setPassword('testuserpass');
      $user->addRole('ROLE_ADMIN');
      $user->setEnabled(true);
      $this->em->persist($user);
      $this->em->flush();

      $person = self::$kernel->getContainer()->get('doctrine')->getRepository('AppBundle:User')->findOneByUsername('testuser');

      $token = new UsernamePasswordToken($person, null, 'main', $person->getRoles());
      $session->set('_security_main', serialize($token));
      $session->save();

      $this->client->getCookieJar()->set(new Cookie($session->getName(), $session->getId()));

      return $this->client;
  }

  public function removeTestClient()
  {
      $container = static::$kernel->getContainer();
      $session = $container->get('session');


      $user = self::$kernel->getContainer()->get('doctrine')->getRepository('AppBundle:User')->findOneByUsername('testuser');
      $user = $this->em->merge($user);
      $this->em->remove($user);
      $this->em->flush();

      $session->set('_security_main', '');
      $session->save();

      $this->client->getCookieJar()->set(new Cookie($session->getName(), $session->getId()));
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
      $this->client = $this->createAuthorizedClient();

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

      $this->removeTestClient();
    }

}
