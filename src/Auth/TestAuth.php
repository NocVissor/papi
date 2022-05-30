<?php
namespace NocVissor\Papi\Auth;
use NocVissor\Papi\Request;
class TestAuth extends Auth{
    function __construct()
    {
        parent::__construct();
        $this->request->headers['token'] = 'test';
    }
}