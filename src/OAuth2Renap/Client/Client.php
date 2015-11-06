<?php

namespace OAuth2Renap\Client;

use Silex\Application;
use Silex\ControllerProviderInterface;
use Silex\Provider\SessionServiceProvider;
use Guzzle\Http\Client as GuzzleClient;

class Client implements ControllerProviderInterface {
    
    public function setup(Application $app) {        
     	$app['twig']->addExtension(new Twig\JsonStringifyExtension());
        $app['twig']->addFilter(new \Twig_SimpleFilter('base64_decode', 'base64_decode'));
        $app['http_client'] = new GuzzleClient();
    }
    
    public function connect(Application $app) {        
        $this->setup($app);        
        $routing = $app['controllers_factory'];
	Controllers\ReceiveAuthorizationCode::addRoutes($routing);
	Controllers\RequestToken::addRoutes($routing);
	return $routing;
    }    
}
