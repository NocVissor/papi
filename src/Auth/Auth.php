<?php
namespace Kaliostro\Papi\Auth;
use Kaliostro\Papi\Request;
use Kaliostro\Papi\Api;
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