<?php
namespace Sipay\Paymethods;

class StoredCard implements Paymethod
{
    public function __construct($token){
        $this->set_token($token);
    }

    public function set_token($token){
        if (gettype($token) != "string"){
            throw new \Exception('$token must be a string.');
        }

        if(!preg_match("/^[\w-]{6,128}$/", $token)){
            throw new \Exception('$token don\'t match with pattern.');
        }

        $this->token = $token;
    }

    public function get_token(){
        return $this->token;
    }

    public function add_to(&$payload){
        $payload['token'] = $this->token;
    }
}
