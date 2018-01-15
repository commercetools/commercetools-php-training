<?php

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Debug\Debug;

require __DIR__.'/../vendor/autoload.php';
if (PHP_VERSION_ID < 70000) {
    include_once __DIR__.'/../var/bootstrap.php.cache';
}

$debug = false;
if (isset($_SERVER['APP_ENV']) && $_SERVER['APP_ENV'] == 'dev') {
    Debug::enable();
    $debug = true;
}
$kernel = new AppKernel((isset($_SERVER['APP_ENV']) ? $_SERVER['APP_ENV']: 'prod'), $debug);
if (PHP_VERSION_ID < 70000) {
    $kernel->loadClassCache();
}

//$kernel = new AppCache($kernel);

// When using the HttpCache, you need to call the method in your front controller instead of relying on the configuration parameter
//Request::enableHttpMethodParameterOverride();
$request = Request::createFromGlobals();
$response = $kernel->handle($request);
$response->send();
$kernel->terminate($request, $response);
