<?php
require_once realpath(__DIR__.'/../src/autoload.php');



$config = array(
    'logger' => array(
        'path' => 'logs',  // Nombre del directorio donde se crearan los logs (Nota: si la ruta es relativa se creará en el directorio del paquete)
        'level' => 'warning',  // Nivel mínimo de trazas [debug, info, warning, error, critical]
        'prefix' => 'logger',  // Prefijo del nombre del archivo
        'extension' => 'log',  // Extensión del archivo
        'date_format' => 'd/m/Y H:i:s',  // Formato de fecha de las trazas de log
        'backup_file_rotation' => 5  // Número de ficheros de backup
    ),
    'credentials' => array(
        'key' => 'api-key',  // Key del cliente
        'secret' => 'api-secret',  // Secret del cliente
        'resource' => 'resource' // Recurso al que se quiere acceder
    ),
    'api' => array(
        'environment' => 'sandbox',  // Entorno al que se deben enviar las peticiones ['sandbox', 'staging', 'live']
        'version' => 'v1',  // Versión de la api a usar actualmente solo existe v1
        'mode' => 'sha256'  // Modo de encriptacion de la firma, [sha256, sha512]
    ),
    'connection' => array(
        'timeout' => 30  // Tiempo máximo de respuesta de la petición.
    )
);

$ecommerce = new \Sipay\Ecommerce(realpath(__DIR__."/../etc/config.ini"));
print($ecommerce->getKey()."\n");
print($ecommerce->getSecret()."\n");
print($ecommerce->getresource()."\n");
