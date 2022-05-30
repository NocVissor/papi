<?php
use NocVissor\Papi\{
    Api,
    Auth\BasicAuth
};

$api = new Api('https://example.com');
$auth = new BasicAuth('login', 'pas');
$api->auth($auth);
$result = $api->get('/testGet');