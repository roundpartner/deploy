<?php

require_once 'vendor/autoload.php';

new \Deploy\Deploy();

$entityBody = file_get_contents('php://input');
$entityBody = json_decode($entityBody);
