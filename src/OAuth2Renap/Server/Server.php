<?php
namespace OAuth2Renap\Server;

use Silex\Application;
use Silex\ControllerProviderInterface;
use OAuth2\HttpFoundationBridge\Response as BridgeResponse;
use OAuth2\Server as OAuth2Server;
use OAuth2\Storage\Pdo;
use OAuth2\Storage\Memory;
use OAuth2\Scope;
use OAuth2\OpenID\GrantType\AuthorizationCode;
use OAuth2\GrantType\UserCredentials;
use OAuth2\GrantType\RefreshToken;

class Server implements ControllerProviderInterface {
    
    public function setup(Application $app) {
        //$dsn = "mysql:dbname=renap_users;unix_socket=/tmp/mysqld.sock;host:localhost;";
        $dsn = "mysql:dbname=renap_users;host:localhost;";
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
            'issuer' => $_SERVER['HTTP_HOST'],
        ), $grantTypes);        

        $defaultScope = 'basic';
        $supportedScopes = array(
            'basic',
            'admin'
        );
        
        $memory = new Memory(array(
            'default_scope' => $defaultScope,
            'supported_scopes' => $supportedScopes
        ));
        
        $scopeUtil = new Scope($memory);        
        $server->setScopeUtil($scopeUtil);
        $storage->setUser("admin","admin", "Alexander", "Baquiax", 'admin');
                
        $app['oauth_server'] = $server;
        $app['mysql_client'] = $storage;
        $app['oauth_response'] = new BridgeResponse();
    }
   
    public function connect(Application $app) {        
        $this->setup($app);        
        $routing = $app['controllers_factory'];        
        Controllers\Authorize::addRoutes($routing);
        Controllers\Token::addRoutes($routing);
        Controllers\Resource::addRoutes($routing);
        Controllers\Login::addRoutes($routing);    
        return $routing;
    } 
}
