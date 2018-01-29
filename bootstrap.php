<?php

if ($_SERVER['REQUEST_URI'] === '/up') {
    http_response_code(201);
    exit();
}

if (!isset($_SERVER['GIT_SECRET'])) {
    http_response_code(500);
    echo 'Unable to process request without key set up';
    exit();
}

require_once 'vendor/autoload.php';

$headers = getallheaders();
$body = file_get_contents('php://input');
$secret = $_SERVER['GIT_SECRET'];

$bootstrap = new \RoundPartner\Deploy\Bootstrap($headers, $body, $secret);
if ($bootstrap->dispatch()) {
    echo 'Request Complete.' . PHP_EOL;
} else {
    echo 'Running plan failed.' . PHP_EOL;
}

