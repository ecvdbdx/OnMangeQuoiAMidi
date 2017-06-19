<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction()
    {
        return $this->render('default/index.html.twig');
    }

    /**
     * @Route("/about", name="about")
     */
    public function aboutAction()
    {
        // replace this example code with whatever you need
        return $this->render('default/about.html.twig', [
            'base_dir' => 'toto',
        ]);
    }
    /**
     * @Route("/testmail", name="testmail")
     */
    public function sendMailAction()
    {
        $message = \Swift_Message::newInstance()
            ->setSubject('Hello Email')
            ->setFrom('send@example.com')
            ->setTo('recipient@example.com')
            ->setBody(
                $this->renderView(
                // app/Resources/views/Emails/registration.html.twig
                    'Emails/registration.html.twig',
                    array('name' => "name")
                ),
                'text/html'
            );
        $this->get('mailer')->send($message);

        return $this->redirect($this->generateUrl('homepage'));
    }
}
