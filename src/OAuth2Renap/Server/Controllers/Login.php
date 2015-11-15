<?php

namespace OAuth2Renap\Server\Controllers;

use Silex\Application;

class Login {    
    public static function addRoutes($routing) {        
        $routing->post('/login', array(new self(), 'login'))->bind('login');        
    }    

    public function login(Application $app) {		        
        $request = $app["request"];
        $pdo = $app["mysql_client"];
        $validUser = $pdo->checkUserCredentials($request->get("username"),$request->get("password"));
        if ($validUser) {
            $user = $pdo->getUserDetails($request->get("username"));
            $app['session']->set("user", $user);
        }                                                   
        return $app->redirect($request->get("returnurl"));        				        
    }
}
