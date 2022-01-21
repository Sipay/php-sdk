<?php
namespace Sipay\Responses;

class Confirm extends Response
{
    public $request_id;
    public $url;

    public function __construct($request, $response) 
    {
        $payload = $this->set_common($request, $response);
        $this->request_id = isset($payload['request_id']) ? $payload['request_id'] : null;
        $this->url = isset($payload['request_id']) ? $payload['url'] : null;
    }
}
