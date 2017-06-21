<?php

namespace Tests\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\BrowserKit\Cookie;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use AppBundle\Entity\User;

class OrderGroupControllerTest extends WebTestCase
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

    public function testGenerateTokenAndDelete()
    {
      $this->client = $this->createAuthorizedClient();

      $route = $this->client->getContainer()->get('router')->generate('place_index', [], false);
      $crawler = $this->client->request('GET', $route);
      $this->assertEquals(200, $this->client->getResponse()->getStatusCode());

      $link = $crawler->selectLink('Voir')->link();
      $crawler = $this->client->click($link);
      $this->assertEquals(200, $this->client->getResponse()->getStatusCode());

      $location = $crawler->getUri();
      preg_match_all('/(place\/)([\d]+)/',$location, $matches);

      $id = $matches[2][0];

      $date = new \DateTime();
      $date->add(new \DateInterval('P10D'));
      $data = array(
        'place_id' => $id,
        'expiration_date' => $date->format('Y-m-d\TH:i')
      );

      $route = $this->client->getContainer()->get('router')->generate('create_order', [], false);
      $crawler = $this->client->request('GET', $route, $data, array(), array(
        'X-Requested-With' => 'XMLHttpRequest',
      ));

      $this->assertEquals(200, $this->client->getResponse()->getStatusCode());

      $token = json_decode($this->client->getResponse()->getContent());

      $orderGroup = self::$kernel->getContainer()->get('doctrine')->getRepository('AppBundle:OrderGroup')->findOneByToken($token);
      $orderGroup = $this->em->merge($orderGroup);
      $this->em->remove($orderGroup);
      $this->em->flush();

      $this->removeTestClient();
    }
}
