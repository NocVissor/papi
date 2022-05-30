<?php

require __DIR__ . '/../vendor/autoload.php';

use Kaliostro\Papi\{
    Api,
    Auth\TelegramAuth
};



$api = new Api();
$token = 'token';
$auth = new TelegramAuth($token);
$api->auth($auth);
$result = $api->get('getMe');

print_r($result);