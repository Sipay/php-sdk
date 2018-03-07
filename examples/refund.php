<?php
require_once realpath(__DIR__.'/../src/autoload.php');

$ecommerce = new \Sipay\Ecommerce(realpath(__DIR__."/../etc/config.ini"));


$amount = new \Sipay\Amount(200, 'EUR');

$card = new \Sipay\Paymethods\Card('4242424242424242', 2018, 12);

$options = array(
  'order' => 'order-test',
  'reference' => '1234',
  'token' => 'new-token'
);

// Devolución
$refund = $ecommerce->refund($card, $amount, $options);

if($refund->code == 0) {
    print("Devolución aceptada!\n");
}else{
    print("Error: ".$refund->description."\n");
}

$stored_card = new \Sipay\Paymethods\StoredCard('new-token');


// Devolución
$refund2 = $ecommerce->refund($stored_card, $amount, $options);

if($refund2->code == 0) {
    print("Devolución aceptada!\n");
}else{
    print("Error: ".$refund2->description."\n");
}

$fast_pay = new \Sipay\Paymethods\FastPay('50d79105f6f848f9ad30f9c5970adf7c');

// Devolución
$refund3 = $ecommerce->refund($fast_pay, $amount, $options);

if($refund3->code == 0) {
    print("Devolución aceptada!\n");
}else{
    print("Error: ".$refund3->description."\n");
}


// Autorización
$auth = $ecommerce->authorization($card, $amount, $options);

if($auth->code == 0) {
    print("Autorización aceptada, el pago ha sido completado!\n");
}else{
    print("Error: ".$auth->description."\n");
}


// Devolución
$refund4 = $ecommerce->refund($auth->transaction_id, $amount, $options);

if($refund4->code == 0) {
    print("Devolución aceptada!\n");
}else{
    print("Error: ".$refund4->description."\n");
}
