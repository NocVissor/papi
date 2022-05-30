<?php
namespace Kaliostro\Papi\Auth;
use Kaliostro\Papi\Request;
class TestAuth extends Auth{
    function __construct()
    {
        parent::__construct();
        $this->request->headers['token'] = 'test';
    }
}