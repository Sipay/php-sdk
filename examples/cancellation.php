<?php
require_once realpath(__DIR__.'/../src/autoload.php');

$ecommerce = new \Sipay\Ecommerce(realpath(__DIR__."/../etc/config.ini"));

$amount = new \Sipay\Amount(200, 'EUR');

$card = new \Sipay\Paymethods\Card('4242424242424242', 2042,12,424);

$auth = $ecommerce->authorization($card, $amount);

if($auth->code == 0) {
    print("Autorización aceptada, el pago ha sido completado!\n");
}else{
    print("Error: ".$auth->description."\n");
}

$cancel = $ecommerce->cancellation($auth->transaction_id);

if($cancel->code == 0) {
    print("Cancelación aceptada!\n");
}else{
    print("Error: ".$cancel->description."\n");
}
