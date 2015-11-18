<?php

require_once __DIR__.'/../vendor/autoload.php';

//ini_set('display_errors', 1);
//error_reporting(E_ALL);


$app = new Silex\Application();
$app->register(new Silex\Provider\SessionServiceProvider());
$app->register(new Silex\Provider\UrlGeneratorServiceProvider());
$app->register(new Silex\Provider\TwigServiceProvider(), array(
    'twig.path' => __DIR__.'/../views',
));

$app['debug'] = false;

$app->mount('/', new OAuth2Renap\Client\Client());
$app->mount('/oauth', new OAuth2Renap\Server\Server());
$app->mount('/api', new OAuth2Renap\Server\Forward());


$request = OAuth2\HttpFoundationBridge\Request::createFromGlobals();
$app->run($request);    
