<?php
namespace Sipay\Responses;

class Transaction{
    public function __construct($data) {
        $this->channel_name = isset( $data['channel_name']) ? $data['channel_name'] : null;
        $this->channel = isset($data['channel']) ? $data['channel'] : null;
        $this->method = isset($data['method']) ? $data['method'] : null;
        $this->order = isset($data['order']) ? $data['order'] : null;
        $this->transaction_id = isset($data['transaction_id']) ? $data['transaction_id'] : null;
        $this->internal_code = isset($data['internal_code']) ? $data['internal_code'] : null;
        $this->method_name = isset($data['method_name']) ? $data['method_name'] : null;
        $this->operation = isset($data['operation']) ? $data['operation'] : null;
        $this->authorization_id = isset($data['authorization_id']) ? $data['authorization_id'] : null;
        $this->description = isset($data['description']) ? $data['description'] : null;
        $this->masked_card = isset($data['masked_card']) ? $data['masked_card'] : null;
        $this->operation_name = isset( $data['operation_name']) ? $data['operation_name'] : null;
        $this->status = isset( $data['status']) ? $data['status'] : null;

        if(isset($data['date']) && isset($data['time'])){
            $this->date = \DateTime::createFromFormat('Y-m-dH:i:s', $data['date'].$data['time']);
        }else{
            $this->date = null;
        }

        if(isset($data['amount']) && isset($data['currency'])){
            $this->amount = new \Sipay\Amount(intval($data['amount']), $data['currency']);
        }else{
            $this->amount = null;
        }

    }
}
