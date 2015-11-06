<?php

namespace OAuth2Renap\Client;

use Silex\Application;
use Silex\ControllerProviderInterface;
use Silex\Provider\SessionServiceProvider;
use Guzzle\Http\Client as GuzzleClient;

class Client implements ControllerProviderInterface {
    
    public function setup(Application $app) {        
        $app['http_client'] = new GuzzleClient();
    }
    
    public function connect(Application $app) {        
        $this->setup($app);        
        $routing = $app['controllers_factory'];

        Controllers\Login::addRoutes($routing);
        return $routing;
    }    
}
