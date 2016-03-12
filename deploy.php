<?php

if (!isset($_SERVER['SHELL'])) {
    http_response_code(500);
    echo 'This script must be run in the shell';
    exit();
}

require_once 'vendor/autoload.php';

$container = new \RoundPartner\Deploy\Container();

$server = \RoundPartner\Deploy\Server\ServerFactory::singleRun($container);
$server->dispatch();
