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

class Forward implements ControllerProviderInterface {
    
    public function setup(Application $app) {
        $app['oauth_response'] = new BridgeResponse();
    }
   
    public function connect(Application $app) {        
        $this->setup($app);
        $routing = $app['controllers_factory'];
        Controllers\Resource::addRoutes($routing);
        return $routing;
    } 
}
