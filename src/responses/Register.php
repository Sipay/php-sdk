<?php
namespace Sipay\Responses;

class Register extends Response
{
    public $expired_at;
    public $masked_card;
    public $card;
    public $token;

    public function __construct($request, $response) 
    {
        $payload = $this->set_common($request, $response);
        $this->expired_at = isset($payload['expired_at']) ? $payload['expired_at'] : null;
        $this->masked_card = isset($payload['card_mask']) ? $payload['card_mask'] : null;
        $this->token = isset($payload['token']) ? $payload['token'] : null;
        $this->card = null;

        if(!is_null($this->expired_at)) {
            $this->expired_at = \DateTime::createFromFormat('Y-m-d H:i:s', $this->expired_at.' 23:59:59');
        }

        if (!is_null($this->token)) {
            $this->card = new \Sipay\Paymethods\StoredCard($this->token);
        }
    }
}
