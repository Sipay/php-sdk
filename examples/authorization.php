<?php
require_once realpath(__DIR__.'/../src/autoload.php');

$ecommerce = new \Sipay\Ecommerce(realpath(__DIR__."/../etc/config.ini"));

print("Autorización \n");

$amount = new \Sipay\Amount(200, 'EUR');

$card = new \Sipay\Paymethods\Card('4242424242424242', 2042,12,424);

$options = array(
  'order' => 'order-test',
  'reference' => '1234',
  'token' => 'token'
);

$auth = $ecommerce->authentication($card, $amount, $options);

if($auth->code == 0) {
    print("Autorización aceptada, el pago ha sido completado!\n");
}else{
    print("Error: ".$auth->description."\n");
}
print("Autorización tokenizada \n");

$stored_card = new \Sipay\Paymethods\StoredCard('token');

$auth2 = $ecommerce->authentication($stored_card, $amount, $options);

if($auth2->code == 0) {
    print("Autorización aceptada, el pago ha sido completado!\n");
}else{
    print("Error: ".$auth2->description."\n");
}

print("Autorización con FPAY \n");
$fast_pay = new \Sipay\Paymethods\FastPay('0f266784e7ba4e438040fdd1dbbfcd73');

$auth3 = $ecommerce->authentication($fast_pay, $amount, $options);

if($auth3->code == 0) {
    print("Autorización aceptada, el pago ha sido completado!\n");
}else{
    print("Error: ".$auth3->description."\n");
}
