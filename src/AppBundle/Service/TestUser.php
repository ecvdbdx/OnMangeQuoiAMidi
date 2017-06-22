<?php
namespace AppBundle\Service;

use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\BrowserKit\Cookie;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use AppBundle\Entity\User;

class TestUser extends WebTestCase
{
    private $em;

    public function __construct(EntityManager $em){
        $this->em = $em;
    }

    public function createAuthorizedClient()
    {
        $client = static::createClient();
        $container = $client->getContainer();
        $session = $container->get('session');

        $user = new User();
        $user->setUsername('testuser');
        $user->setEmail('testuser@email.com');
        $user->setPassword('testuserpass');
        $user->addRole('ROLE_ADMIN');
        $user->setEnabled(true);
        $this->em->persist($user);
        $this->em->flush();

        $person = $container->get('doctrine')->getRepository('AppBundle:User')->findOneByUsername('testuser');

        $token = new UsernamePasswordToken($person, null, 'main', $person->getRoles());
        $session->set('_security_main', serialize($token));
        $session->save();

        $client->getCookieJar()->set(new Cookie($session->getName(), $session->getId()));

        return $client;
    }

    public function removeTestClient($client)
    {
        $container = static::$kernel->getContainer();
        $session = $container->get('session');

        $user = $container->get('doctrine')->getRepository('AppBundle:User')->findOneByUsername('testuser');
        $user = $this->em->merge($user);
        $this->em->remove($user);
        $this->em->flush();

        $session->set('_security_main', '');
        $session->save();

        $client->getCookieJar()->set(new Cookie($session->getName(), $session->getId()));

        return $client;
    }
}
