<?php
require_once realpath(__DIR__.'/../src/autoload.php');

$ecommerce = new \Sipay\Ecommerce(realpath(__DIR__."/../etc/config.ini"));

$card = new \Sipay\Paymethods\Card('4242424242424242', 2018, 12);

$register = $ecommerce->register($card, $token = 'new-token');

if($register->code == 0) {
    print("Tarjeta registrada con éxito!\n");
}else{
    print("Error: ".$register->description."\n");
}

$masked_card = $ecommerce->card($token);

if($masked_card->code == 0) {
    print("Tarjeta consultada con éxito!\n");
}else{
    print("Error: ".$masked_card->description."\n");
}

$unregiter = $ecommerce->unregister($token);

if($unregiter->code == 0) {
    print("Tarjeta borrada con éxito!\n");
}else{
    print("Error: ".$unregiter->description."\n");
}
