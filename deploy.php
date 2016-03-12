<?php

if (!isset($_SERVER['SHELL'])) {
    http_response_code(500);
    echo 'This script must be run in the shell';
    exit();
}

require_once __DIR__ . '/vendor/autoload.php';

$container = new \RoundPartner\Deploy\Container();

$server = \RoundPartner\Deploy\Server\ServerFactory::multiRun($container, 1000);
$server->dispatch();
