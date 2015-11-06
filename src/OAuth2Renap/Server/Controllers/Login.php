<?php

namespace OAuth2Renap\Server\Controllers;

use Silex\Application;

class Login {    
    public static function addRoutes($routing) {        
        $routing->post('/login', array(new self(), 'login'))->bind('login');        
    }    

    public function login(Application $app) {		
        $app['session']->set('username', "alex");
        $request = $app["request"];        
		return $app->redirect($request->get("returnurl"));		        
    }
}
