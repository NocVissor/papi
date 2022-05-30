<?php
namespace NocVissor\Papi\Auth;
use NocVissor\Papi\Request;

class BearerAuth extends Auth{
    function __construct($token)
    {
        $this->request = new Request([
            'headers' => [
                'Authorization' => "Bearer $token"
            ]
        ]);
    }
}