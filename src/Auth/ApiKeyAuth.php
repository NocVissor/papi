<?php
namespace NocVissor\Papi\Auth;
use NocVissor\Papi\Request;

class ApiKeyAuth extends Auth{
    function __construct($key, $token)
    {
        $this->request = new Request([
            'headers' => [
                $key => $token
            ]
        ]);
    }
}