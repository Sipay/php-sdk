<?php
require_once realpath(__DIR__.'/../src/autoload.php');

$ecommerce = new \Sipay\Ecommerce(realpath(__DIR__."/../etc/config.ini"));

print("Autorización \n");

$amount = new \Sipay\Amount(200, 'EUR');

$storedCard = new \Sipay\Paymethods\StoredCard('token');

$options = array(
  'order' => 'order-test_2',
  'reference' => '1234',
  'token' => 'token',
  'sca_exemptions' => 'MIT'
);

$auth2 = $ecommerce->authentication($storedCard, $amount, $options);
//var_dump($auth2);

if($auth2->code == 0) {
  print("Autenticación, la autorización ha sido completada!\n");
}else{
  print("Error: ".$auth2->description."\n");
}

$auth3 = $ecommerce->confirm(array('request_id' => $auth2->request_id));

if($auth3->code == 0) {
  print("Confirm correcto, el pago ha sido completado!\n");
}else{
  print("Error: ".$auth3->description."\n");
}
//var_dump($auth3);
