<?php
namespace NocVissor\Papi\Auth;
use NocVissor\Papi\Request;

class BasicAuth extends Auth{
    function __construct($login, $password)
    {
        $this->request = new Request([
            'headers' => [
                'Authorization' => "Basic ".base64_encode("$login:$password")
            ]
        ]);
    }
}