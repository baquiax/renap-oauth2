<?php
$dsn = 'mysql:dbname=renap_users;host:localhost';
$username = "baquiax";
$password = "admin";

require_once("oauth2-server-php/src/OAuth2/Autoloader.php");
OAuth2\Autoloader::register();

$storage = new OAuth2\Storage\Pdo(array(
    "dsn" =>  $dsn,
    "username" => $username,
    "password" => $password
));

$server = new OAuth2\Server($storage);
$server->addGrantType(new OAuth2\GrantType\AuthorizationCode($storage));

?>