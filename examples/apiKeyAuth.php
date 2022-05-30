<?php
use NocVissor\Papi\{
    Api,
    Auth\ApiKeyAuth
};

$api = new Api('https://example.com');
$auth = new ApiKeyAuth('key', 'token');
$api->auth($auth);
$result = $api->get('/testGet',[
    'get' => ['a' => 1],
    'body' => ['b' => 2],
    'headers' => ['c' => 3]
]);