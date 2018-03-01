<?php
namespace Sipay\Responses;

class Authorization extends Response
{
    public $approval;
    public $authorizator;
    public $card_trade;
    public $card_type;
    public $masked_card;
    public $order;
    public $reference;
    public $transaction_id;
    public $amount;

    public function __construct($request, $response)
    {
        $payload = $this->set_common($request, $response);
        $this->approval = isset($payload['approval']) ? $payload['approval'] : null;
        $this->authorizator = isset($payload['authorizator']) ? $payload['authorizator'] : null;
        $this->card_trade = isset($payload['card_trade']) ? $payload['card_trade'] : null;
        $this->card_type = isset($payload['card_type']) ? $payload['card_type'] : null;
        $this->masked_card = isset($payload['masked_card']) ? $payload['masked_card'] : null;
        $this->order = isset($payload['order']) ? $payload['order'] : null;
        $this->reference = isset($payload['reconciliation']) ? $payload['reconciliation'] : null;
        $this->transaction_id = isset($payload['transaction_id']) ? $payload['transaction_id'] : null;

        if(isset($payload['amount']) && isset($payload['currency'])) {
            $this->amount = new \Sipay\Amount($payload['amount'], $payload['currency']);
        }else{
            $this->amount = null;
        }
    }
}
