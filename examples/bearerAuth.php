<?php
use NocVissor\Papi\{
    Api,
    Auth\BearerAuth
};

$api = new Api('https://example.com');
$auth = new BearerAuth('token');
$api->auth($auth);
$result = $api->get('/testGet',[
    'get' => ['a' => 1],
    'body' => ['b' => 2],
    'headers' => ['c' => 3]
]);