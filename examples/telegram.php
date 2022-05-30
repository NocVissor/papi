<?php

require __DIR__ . '/../vendor/autoload.php';

use NocVissor\Papi\{
    Api,
    Auth\Auth
};


class TelegramAuth extends Auth{
    private $base_url = '';
    function __construct($token)
    {
        parent::__construct();
        $this->base_url = "https://api.telegram.org/bot$token/";
    }
    public function link(Api $api){
        parent::link($api);
        $api->base_url = $this->base_url;
    }
}



$api = new Api();
$token = 'token';
$auth = new TelegramAuth($token);
$api->auth($auth);
$result = $api->get('getMe');

print_r($result);