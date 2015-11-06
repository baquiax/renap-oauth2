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
        $twig =  (!empty( $app['session']->get('username'))) ? 'server/authorize.twig' : 'server/login.twig';
        return $app['twig']->render($twig, array(
                'client_id' => $app['request']->query->get('client_id'),
                'response_type' => $app['request']->query->get('response_type')
            ));
    }
    
    public function authorizeFormSubmit(Application $app) {        
        $server = $app['oauth_server'];         
        $response = $app['oauth_response'];
        
        $authorized = (bool) $app['request']->request->get('authorize');
        $user_id = $app['session']->get('username');
        return $server->handleAuthorizeRequest($app['request'], $response, $authorized, $user_id);
    }
}
