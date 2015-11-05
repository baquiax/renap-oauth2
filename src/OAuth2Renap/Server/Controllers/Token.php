<?php
namespace OAuth2Renap\Server\Controllers;

use Silex\Application;

class Token {
	public static function addRoutes($routing) {
		$routing->post('/token', array(new self(), 'token'))->bind('grant');
	}
	
	public function token(Application $app) {
		$server = $app['oauth_server'];
		$response = $app['oauth_response'];
		return $server->handleTokenRequest($app['request'], $response);
	}
}
