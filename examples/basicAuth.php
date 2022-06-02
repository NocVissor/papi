<?php
use NocVissor\Papi\{
    Api,
    Auth\BasicAuth,
    Request
};

$api = new Api('https://example.com');
$auth = new BasicAuth('login', 'pas');
$api->auth($auth);
$result = $api->get('/testGet',new Request([
    'get' => ['a' => 1],
    'body' => ['b' => 2],
    'headers' => ['c' => 3]
]));