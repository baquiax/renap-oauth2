<?php
namespace OAuth2Renap\Server\Controllers;

use Silex\Application;
use Symfony\Component\HttpFoundation\Response;
use Guzzle\Http\Exception\ClientErrorResponseException;
use Guzzle\Http\Exception\BadResponseException;

class Resource {
    private $base_url = "http://192.168.0.101:8080/";
        
    public static function addRoutes($routing) {
        $routing->get('{url}', array(new self(), 'forwardRequest'))->bind('forward')->assert('url', '.*');
        $routing->post('{url}', array(new self(), 'forwardPOSTRequest'))->bind('forwardPOST')->assert('url', '.*');
    }
    
    public function forwardRequest(Application $app, $url = "") {
        $server = $app['oauth_server'];
        $response = $app['oauth_response']; 
        $request = $app['request'];
        $http    = $app['http_client'];
        
        if (!$server->verifyResourceRequest($request, $response, 'admin')) {            
            return $server->getResponse();
        } else {            
            try {
                $response = $http->get($this->base_url . $url, $request->query->all())->send();
                $json = json_decode((string) $response->getBody(), true);
                $status = (string)$response->getHeader('Content-type');
            } catch (ClientErrorResponseException  $e) {
                $json = json_decode((string) $e->getResponse()->getBody(true), true);
                $status = (string)$e->getResponse()->getHeader('Content-type');                
            } catch (BadResponseException  $e) {
                $json = json_decode((string) $e->getResponse()->getBody(true), true);
                $status = (string)$e->getResponse()->getHeader('Content-type');                
            }  
            
            return new Response(json_encode($json),
                $response->getStatusCode(),
                array('content-type' => $status));
        }
    }
    
    public function forwardPOSTRequest(Application $app, $url) {
        $server = $app['oauth_server'];
        $response = $app['oauth_response']; 
        $request = $app['request'];
        $http    = $app['http_client'];
        
        if (!$server->verifyResourceRequest($app['request'], $response, 'admin')) {            
            return $server->getResponse();
        } else {
            try {                
                $response = $http->post($this->base_url . $url, $request->request->all())->send();
                $json = json_decode((string) $response->getBody(), true);                
                $status = (string)$response->getHeader('Content-type');
            } catch (ClientErrorResponseException  $e) {
                $json = json_decode((string) $e->getResponse()->getBody(true), true);
                $status = (string)$e->getResponse()->getHeader('Content-type');                
            }  catch (BadResponseException  $e) {
                $json = json_decode((string) $e->getResponse()->getBody(true), true);
                $status = (string)$e->getResponse()->getHeader('Content-type');                
            } 
            
            return new Response(json_encode($json),
                $response->getStatusCode(),
                array('content-type' => $status));
        }
    }
}
