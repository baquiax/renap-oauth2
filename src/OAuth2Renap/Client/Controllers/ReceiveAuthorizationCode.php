<?php
namespace OAuth2Renap\Client\Controllers;

use Silex\Application;

class ReceiveAuthorizationCode{
    public static function addRoutes($routing) {
        $routing->get('/receive-code', array(new self(), 'receiveAuthorizationCode'))->bind('receiveCode');
    }

    public function receiveAuthorizationCode(Application $app) {
        $request = $app['request'];               
        $http    = $app['http_client'];
        $parameters = array(
            "grant_type" => "authorization_code",
            "code" => $request->get('code'),            
            "client_id"     => "testclient",
            "client_secret" => "testpass",
        );        
        $response = $http->post("http://localhost/oauth/token", null, $parameters, array("exceptions" => false))->send();        
        $json = json_decode((string) $response->getBody(), true);
        return $app->json($json);
    }
}
