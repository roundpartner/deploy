<?php

if (!isset($_SERVER['argc']) || $_SERVER['argc'] === 0) {
    http_response_code(500);
    echo 'This script must be run in the shell';
    exit();
}

$iterations = 0;
if ($_SERVER['argc'] > 1) {
    $iterations = $_SERVER['argv'][1];
}

require_once __DIR__ . '/vendor/autoload.php';

$container = new \RoundPartner\Deploy\Container();

$server = \RoundPartner\Deploy\Server\ServerFactory::multiRun($container, $iterations);
$server->dispatch();
