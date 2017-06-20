<?php

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Debug\Debug;

umask(0002); // This will let the permissions be 0775 because we need to deploy on a mutualised server

/**
 * @var Composer\Autoload\ClassLoader $loader
 */
$loader = require __DIR__.'/../app/autoload.php';
Debug::enable();

$kernel = new AppKernel('dev', true);
$kernel->loadClassCache();
$request = Request::createFromGlobals();
$response = $kernel->handle($request);
$response->send();
$kernel->terminate($request, $response);
