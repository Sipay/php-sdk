<?php
namespace Sipay\Responses;

class Query extends Response
{
    public function __construct($request, $response) 
    {
        $payload = $this->set_common($request, $response);
        if(isset($payload['items'])) {
            $this->transactions = array();
            foreach ($payload['items'] as $item) {
                array_push($this->transactions, new Transaction($item));
            }
        }else{
            $this->transactions = null;
        }
    }
}
