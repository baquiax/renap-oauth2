<?php
namespace OAuth2Renap\Server\Controllers;

use Silex\Application;
use Symfony\Component\HttpFoundation\Response;

class Resource {    
    public static function addRoutes($routing) {
        $routing->get('/resource', array(new self(), 'resource'))->bind('access');
    }
    
    public function resource(Application $app) {        
        $server = $app['oauth_server'];        
        $response = $app['oauth_response'];

        if (!$server->verifyResourceRequest($app['request'], $response)) {
            return $server->getResponse();
        } else {            
            $api_response = array(
                'friends' => array(
                    'john',
                    'matt',
                    'jane'
                )
            );
            return new Response(json_encode($api_response));
        }
    }
}
