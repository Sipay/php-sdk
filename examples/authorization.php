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

$auth = $ecommerce->authorization($card, $amount, $options);

if($auth->code == 0) {
    print("Autorización aceptada, el pago ha sido completado!\n");
}else{
    print("Error: ".$auth->description."\n");
}

$stored_card = new \Sipay\Paymethods\StoredCard('new-token');

$auth2 = $ecommerce->authorization($stored_card, $amount, $options);

if($auth2->code == 0) {
    print("Autorización aceptada, el pago ha sido completado!\n");
}else{
    print("Error: ".$auth2->description."\n");
}

$fast_pay = new \Sipay\Paymethods\FastPay('0f266784e7ba4e438040fdd1dbbfcd73');

$auth3 = $ecommerce->authorization($fast_pay, $amount, $options);

if($auth3->code == 0) {
    print("Autorización aceptada, el pago ha sido completado!\n");
}else{
    print("Error: ".$auth3->description."\n");
}
