<?php
require_once realpath(__DIR__.'/../src/autoload.php');

$ecommerce = new \Sipay\Ecommerce(realpath(__DIR__."/../etc/config.ini"));

print("Autorización \n");

$amount = new \Sipay\Amount(242, 'EUR');

$card = new \Sipay\Paymethods\Card('4242424242424242', 2042,12,424);

$options = array(
  'order' => 'order-test',
  'reference' => '1234',
  'token' => 'token',
  'moto' => 'phone'
);

$auth = $ecommerce->authentication($card, $amount, $options);
var_dump($auth);
$auth1 = $ecommerce->confirm(array('request_id' => $auth->request_id));
var_dump($auth1);

print("\n \n \n \n \n \n \n \n \n \n \n \n");

$storedCard = new \Sipay\Paymethods\StoredCard('token');

$options = array(
  'order' => 'order-test_2',
  'reference' => '1234',
  'token' => 'token',
  'sca_exemptions' => 'MIT'
);

$auth2 = $ecommerce->authentication($storedCard, $amount, $options);
var_dump($auth2);
$auth3 = $ecommerce->confirm(array('request_id' => $auth2->request_id));
var_dump($auth3);
