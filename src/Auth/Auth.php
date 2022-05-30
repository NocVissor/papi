<?php
namespace NocVissor\Papi\Auth;
use NocVissor\Papi\Request;
use NocVissor\Papi\Api;
abstract class Auth{
    public Request $request;
    protected Api $api;
    function __construct()
    {
        $this->request = new Request();
    }
    // connect Api class to Auth via composition
    public function link(Api $api){
        $this->api = $api;
    }
}