<?php
namespace NocVissor\Papi\Auth;
use NocVissor\Papi\Request;
use NocVissor\Papi\Api;
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