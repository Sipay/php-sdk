<?php
require_once realpath(__DIR__.'/../src/autoload.php');

$ecommerce = new \Sipay\Ecommerce(realpath(__DIR__."/../etc/config.ini"));

$amount = new \Sipay\Amount(200, 'EUR');

$card = new \Sipay\Paymethods\Card('6712009000000205', 2018, 12);

$options = array(
  'order' => 'order-test',
  'reference' => '1234',
  'token' => 'new-token'
);

$refund = $ecommerce->refund($card, $amount, $options);

if($refund->code == 0) {
    print("Devolución aceptada!\n");
}else{
    print("Error: ".$refund->description."\n");
}

$stored_card = new \Sipay\Paymethods\StoredCard('new-token');

$refund2 = $ecommerce->refund($stored_card, $amount, $options);

if($refund2->code == 0) {
    print("Devolución aceptada!\n");
}else{
    print("Error: ".$refund2->description."\n");
}

$fast_pay = new \Sipay\Paymethods\FastPay('0f266784e7ba4e438040fdd1dbbfcd73');

$refund3 = $ecommerce->refund($fast_pay, $amount, $options);

if($refund3->code == 0) {
    print("Devolución aceptada!\n");
}else{
    print("Error: ".$refund3->description."\n");
}



$auth = $ecommerce->authorization($card, $amount, $options);

if($auth->code == 0) {
    print("Autorización aceptada, el pago ha sido completado!\n");
}else{
    print("Error: ".$auth->description."\n");
}


$refund4 = $ecommerce->refund($auth->transaction_id, $amount, $options);

if($refund4->code == 0) {
    print("Devolución aceptada!\n");
}else{
    print("Error: ".$refund4->description."\n");
}
