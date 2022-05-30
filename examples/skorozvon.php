<?php

use NocVissor\Papi\{
    Api
};
use NocVissor\Papi\Auth\SkorozvonAuth;






$login = '...';
$api_key = '...';
$id = '...';
$secret = '...';

$api = new Api();
$api->cache->path = '../cache';
$api->auth(new SkorozvonAuth($login, $api_key, $id, $secret));

print_r($api->get('/account/balance'));