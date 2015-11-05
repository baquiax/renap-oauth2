<?php
namespace OAuth2Renap\Server\Controllers;

use Silex\Application;

class Authorize {    
    public static function addRoutes($routing) {
        $routing->get('/authorize', array(new self(), 'authorize'))->bind('authorize');
        $routing->post('/authorize', array(new self(), 'authorizeFormSubmit'))->bind('authorize_post');
    }

    public function authorize(Application $app) {        
        $server = $app['oauth_server'];         
        $response = $app['oauth_response'];
        
        if (!$server->validateAuthorizeRequest($app['request'], $response)) {
            return $server->getResponse();
        }
        
        return $app['twig']->render('server/authorize.twig', array(
            'client_id' => $app['request']->query->get('client_id'),
            'response_type' => $app['request']->query->get('response_type')
        ));
    }
    
    public function authorizeFormSubmit(Application $app) {        
        $server = $app['oauth_server'];         
        $response = $app['oauth_response'];
        
        $authorized = (bool) $app['request']->request->get('authorize');
        return $server->handleAuthorizeRequest($app['request'], $response, $authorized);
    }
}
