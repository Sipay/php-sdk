<?php
namespace Sipay\Paymethods;

class Catcher implements Paymethod
{
    public function __construct(array $array_opts)
    {
        $this->options = $array_opts;
    }

    public function to_json()
    {
        return array('catcher' => $this->options);
    }
}
