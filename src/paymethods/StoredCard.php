<?php
namespace Sipay\Paymethods;

class StoredCard implements Paymethod
{
    public function __construct(string $token)
    {
        $this->set_token($token);
    }

    public function set_token(string $token)
    {
        if(!preg_match("/^[\w-]{6,128}$/", $token)) {
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
        return array('token' => $this->token);
    }
}
