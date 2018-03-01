<?php
require_once realpath(__DIR__.'/../src/autoload.php');

$ecommerce = new \Sipay\Ecommerce(realpath(__DIR__."/../etc/config.ini"));

$amount = new \Sipay\Amount(200, 'EUR');

$card = new \Sipay\Paymethods\Card('6712009000000205', 2018, 12);

$options = array(
  'order' => 'order-test'
);

$auth = $ecommerce->authorization($card, $amount, $options);

if($auth->code == 0) {
    print("Autorización aceptada, el pago ha sido completado!\n");
}else{
    print("Error: ".$auth->description."\n");
}

$auth2 = $ecommerce->authorization($card, $amount, $options);

if($auth2->code == 0) {
    print("Autorización aceptada, el pago ha sido completado!\n");
}else{
    print("Error: ".$auth2->description."\n");
}

$query = $ecommerce->query(array('order' => 'order-test'));

if($query->code == 0) {
    print(count($query->transactions)." transacciones recuperadas con éxito!\n");
}else{
    print("Error: ".$query->description."\n");
}
