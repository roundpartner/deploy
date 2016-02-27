<?php

require_once 'vendor/autoload.php';

$headers = getallheaders();
$body = file_get_contents('php://input');

file_put_contents('/tmp/body', $body);
file_put_contents('/tmp/headers', print_r($headers, true));

echo 'Request Complete, nothing processed';
