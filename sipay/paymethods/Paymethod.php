<?php
namespace Sipay\Paymethods;

interface Paymethod
{
    public function add_to(&$payload);
}
