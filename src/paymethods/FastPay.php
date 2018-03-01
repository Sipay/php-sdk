<?php
namespace Sipay\Paymethods;

class FastPay implements Paymethod
{
    public function __construct($token)
    {
        $this->set_token($token);
    }

    public function set_token($token)
    {
        if (gettype($token) != "string") {
            throw new \Exception('$token must be a string.');
        }

        if(!preg_match("/^[0-9a-fA-F]{32}$/", $token)) {
            throw new \Exception('$token don\'t match with pattern.');
        }

        $this->token = $token;
    }

    public function get_token()
    {
        return $this->token;
    }

    public function to_json()
    {
        return array('fastpay' => array('request_id' => $this->token));
    }
}
