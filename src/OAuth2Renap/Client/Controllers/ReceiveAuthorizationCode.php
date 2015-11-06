<?php
namespace OAuth2Renap\Client\Controllers;

use Silex\Application;

class ReceiveAuthorizationCode{
    public static function addRoutes($routing) {
        $routing->get('/receive_code', array(new self(), 'receiveAuthorizationCode'))->bind('authorize_redirect');
    }

    public function receiveAuthorizationCode(Application $app) {
        $request = $app['request']; // the request object
        $session = $app['session']; // the session (or user) object
        $twig    = $app['twig'];    // used to render twig templates
	$http    = $app['http_client'];   // service to make HTTP requests to the oauth server

        // the user denied the authorization request
        if (!$code = $request->get('code')) {
               return $twig->render('client/failed_authorization.twig', array('response' => $request->getAllQueryParameters()));
        }

        // verify the "state" parameter matches this user's session (this is like CSRF - very important!!)
//        if ($request->get('state') !== $session->getId()) {
  //          return $twig->render('client/failed_authorization.twig', array('response' => array('error_description' => 'Your session has expired.  Please try again.')));
   //     }
	
	$response = $http->get("http://mayaleng.com:8080/index.php/get_token", array("code" => $code))->send();
var_dump($response);
	$json = json_decode((string) $response->getBody(), true);
	return $app->json($json);
    }
}
