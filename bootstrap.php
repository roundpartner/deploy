<?php

if (!isset($_SERVER['GIT_SECRET'])) {
    http_response_code(500);
    echo 'Unable to process request without key set up';
    exit();
}

require_once 'vendor/autoload.php';

$headers = getallheaders();
$body = file_get_contents('php://input');
$secret = $_SERVER['GIT_SECRET'];

$container = new \RoundPartner\Deploy\Container();
$deploy = new \Deploy\Deploy($headers, $body, $secret, $container);
$deploy->dispatch();

