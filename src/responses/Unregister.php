<?php
namespace Sipay\Responses;

class Unregister extends Response
{
    public function __construct($request, $response) 
    {
        $this->set_common($request, $response);
    }
}
