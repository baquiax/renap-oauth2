<?php
namespace OAuth2Renap\Server;

use Silex\Application;
use Silex\ControllerProviderInterface;
use OAuth2\HttpFoundationBridge\Response as BridgeResponse;
use OAuth2\Server as OAuth2Server;
use OAuth2\Storage\Pdo;
use OAuth2\Storage\Memory;
use OAuth2\OpenID\GrantType\AuthorizationCode;
use OAuth2\GrantType\UserCredentials;
use OAuth2\GrantType\RefreshToken;

class Server implements ControllerProviderInterface {
    
    public function setup(Application $app) {
        $dsn = "mysql:dbname=renap_users;unix_socket=/tmp/mysqld.sock;host:localhost;";
        $username = "baquiax";
        $password = "admin";
        $storage = new Pdo(array(
            "dsn" =>  $dsn,
            "username" => $username,
            "password" => $password
        ));        
        
        $grantTypes = array(
            'authorization_code' => new AuthorizationCode($storage),            
            'refresh_token'      => new RefreshToken($storage, array(
                'always_issue_new_refresh_token' => true,
            )),
        );
        
        $server = new OAuth2Server($storage, array(
            'enforce_state' => true,
            'allow_implicit' => true,
            'use_openid_connect' => true,
            'issuer' => $_SERVER['HTTP_HOST'],
        ), $grantTypes);        
        
        $app['oauth_server'] = $server;
        $app['oauth_response'] = new BridgeResponse();
    }

   
    public function connect(Application $app) {        
        $this->setup($app);        
        $routing = $app['controllers_factory'];        
        Controllers\Authorize::addRoutes($routing);
        Controllers\Token::addRoutes($routing);
        Controllers\Resource::addRoutes($routing);
        return $routing;
    }
    
}
