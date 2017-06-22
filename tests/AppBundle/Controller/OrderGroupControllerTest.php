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

    public function testGenerateTokenAndDelete()
    {

      $testUser = $this->client->getContainer()->get('testUser');

      $this->client = $testUser->createAuthorizedClient();

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

      $route = $this->client->getContainer()->get('router')->generate('place_show', ['place' => $id], false);
      $crawler = $this->client->request('GET', $route, $data, array(), array(
        'X-Requested-With' => 'XMLHttpRequest',
      ));

      $this->assertEquals(200, $this->client->getResponse()->getStatusCode());

      $token = json_decode($this->client->getResponse()->getContent());

      if ($token != null)
      {
        $orderGroup = self::$kernel->getContainer()->get('doctrine')->getRepository('AppBundle:OrderGroup')->findOneByToken($token);
        $orderGroup = $this->em->merge($orderGroup);
        $this->em->remove($orderGroup);
        $this->em->flush();
      }

      /*
      $crawler = $this->client->request('GET', '/orderGroup/order/'.$token);
      $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
      $input = $crawler
        ->filter('input[type="number"]')
        ->eq(0)
        ->attr('name');

      $form = $crawler->filter('form')->form();
      $form["$input"] = '1';

      var_dump($form);

      $this->client->submit($form);

      //Reste à vérifier que la commande est bien sur la page, puis la supprimer de la BDD
      */


      $orderGroup = self::$kernel->getContainer()->get('doctrine')->getRepository('AppBundle:OrderGroup')->findOneByToken($token);
      $orderGroup = $this->em->merge($orderGroup);
      $this->em->remove($orderGroup);
      $this->em->flush();

      $testUser->removeTestClient($this->client);
    }
}
