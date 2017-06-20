<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpKernel\Exception\FlattenException;

class ExceptionController extends Controller
{
  public function logStatus(FlattenException $exception)
  {
    $code = $exception -> getStatusCode();
    return $this -> render('TwigBundle:Exception:error.html.twig', array(
      'status_code' => $code
    ));
  }
}
