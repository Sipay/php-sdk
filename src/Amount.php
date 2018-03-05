<?php

namespace Sipay;

class Amount
{
    private $currency;
    private $amount;

    public function __construct($amount, $currency)
    {
        $this->set($amount, $currency);
    }

    public function get_currency()
    {
        return $this->currency[0];
    }

    public function get_amount()
    {
        return $this->amount;
    }

    public function get_array()
    {
        return array(
            'amount' => $this->amount,
            'currency' => $this->currency[0]
          );
    }

    public function set($amount, $currency)
    {
        if (gettype($currency) != "string") {
            throw new \Exception('$currency must be a string.');
        }

        if(!isset(Catalogs\CURRENCIES[$currency])) {
            throw new \Exception('$currency don\'t exists.');
        }

        if(Catalogs\CURRENCIES[$currency][1] < 0) {
            throw new \Exception('Invalid currency.');
        }

        $this->currency = Catalogs\CURRENCIES[$currency];

        if (gettype($amount) == "string"
            && preg_match("/^[0-9]+\.[0-9]{".$this->currency[1]."}$/", $amount)
        ) {
                $amount = intval(str_replace(".", "", $amount));
        }

        if (gettype($amount) == "string"
            && preg_match("/^[0-9]+$/", $amount)
        ) {
                $amount = intval($amount);
        }

        if (gettype($amount) != "integer") {
            throw new \Exception('$amount must be a integer.');
        }

        if($amount < 0) {
            throw new \Exception('Value of $amount is incorrect.');
        }

        $this->amount = $amount;
    }

    public function __toString()
    {
        $str = str_pad("".$this->amount, $this->currency[1]+1, "0", STR_PAD_LEFT);
        $str = substr_replace($str, '.', strlen($str)-$this->currency[1], 0);
        return $str.$this->currency[0];
    }

}
