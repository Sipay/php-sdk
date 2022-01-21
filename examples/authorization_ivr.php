<?php
require_once realpath(__DIR__.'/../src/autoload.php');

$ecommerce = new \Sipay\Ecommerce(realpath(__DIR__."/../etc/config.ini"));

print("Autorización \n");

$amount = new \Sipay\Amount(0, 'EUR');

$card = new \Sipay\Paymethods\Card('4242424242424242', 2042,12,424);

$options = array(
  'order' => 'order-test',
  'reference' => '1234',
  'token' => 'token',
  'moto' => 'phone'
);

$auth = $ecommerce->authentication($card, $amount, $options);
//var_dump($auth);

if($auth->code == 0) {
    print("Autorización aceptada, la autorización ha sido completada!\n");
}else{
    print("Error: ".$auth->description."\n");
}

$auth1 = $ecommerce->confirm(array('request_id' => $auth->request_id));
//var_dump($auth1);

if($auth1->code == 0) {
    print("Confirm correcto, el pago ha sido completado!\n");
}else{
    print("Error: ".$auth->description."\n");
}