<?php
namespace NocVissor\Papi\Auth;
use NocVissor\Papi\Request;
use NocVissor\Papi\Api;
class Auth{
    public Request $request;
    protected Api $api;
    function __construct()
    {
        $this->request = new Request();
    }
    public function link(Api $api){
        $this->api = $api;
    }
}