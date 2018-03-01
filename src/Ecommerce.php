<?php

namespace Sipay;

class Ecommerce
{
    protected $logger;
    protected $key;
    protected $secret;
    protected $resource;
    protected $environment;
    protected $version;
    protected $mode;
    protected $timeout;

    public function __construct($config_path)
    {
        if (gettype($config_path) != "string") {
            throw new \Exception('$config_path must be a string.');
        }

        $config = parse_ini_file($config_path, true);

        $this->logger = new Logger($config['logger']);

        $cred = $config['credentials'];
        $this->setKey(isset($cred['key']) ? $cred['key'] : '');
        $this->setSecret(isset($cred['secret']) ? $cred['secret'] : '');
        $this->setResource(isset($cred['resource']) ? $cred['resource'] : '');

        $api = $config['api'];
        $this->setEnvironment(isset($api['environment']) ? $api['environment'] : '');
        $this->setVersion(isset($api['version']) ? $api['version'] : '');
        $this->setMode(isset($api['mode']) ? $api['mode'] : '');

        $connection = $config['connection'];
        $this->setTimeout(isset($connection['timeout']) ? $connection['timeout'] : '30');
    }

    public function getKey()
    {
        return $this->key;
    }

    public function setKey($key)
    {
        if (gettype($key) != "string") {
            throw new \Exception('$key must be a string.');
        }
        if(!preg_match("/^[\w-]{6,32}$/", $key)) {
            throw new \Exception('$key don\'t match with pattern.');
        }
        $this->key = $key;
    }

    public function getSecret()
    {
        return $this->secret;
    }

    public function setSecret($secret)
    {
        if (gettype($secret) != "string") {
            throw new \Exception('$secret must be a string.');
        }
        if(!preg_match("/^[\w-]{6,32}$/", $secret)) {
            throw new \Exception('$secret don\'t match with pattern.');
        }
        $this->secret = $secret;
    }

    public function getResource()
    {
        return $this->resource;
    }

    public function setResource($resource)
    {
        if (gettype($resource) != "string") {
            throw new \Exception('$resource must be a string.');
        }
        if(!preg_match("/^[\w-]{6,32}$/", $resource)) {
            throw new \Exception('$resource don\'t match with pattern.');
        }
        $this->resource = $resource;
    }

    public function getEnvironment()
    {
        return $this->environment;
    }

    public function setEnvironment($environment)
    {
        if (gettype($environment) != "string") {
            throw new \Exception('$environment must be a string.');
        }
        if(!in_array($environment, array('sandbox', 'staging', 'live'))) {
            throw new \Exception('$environment must be sandbox, staging or live.');
        }
        $this->environment = $environment;
    }

    public function getVersion()
    {
        return $this->version;
    }

    public function setVersion($version)
    {
        if (gettype($version) != "string") {
            throw new \Exception('$version must be a string.');
        }
        if($version != "v1") {
            throw new \Exception('$version must be v1.');
        }
        $this->version = $version;
    }

    public function getMode()
    {
        return $this->mode;
    }

    public function setMode($mode)
    {
        if (gettype($mode) != "string") {
            throw new \Exception('$mode must be a string.');
        }
        if(!in_array($mode, array('sha256','sha512'))) {
            throw new \Exception('$mode must be sha256 or sha512.');
        }
        $this->mode = $mode;
    }

    public function getTimeout()
    {
        return $this->timeout;
    }

    public function setTimeout($timeout)
    {
        if (!is_numeric($timeout)) {
            throw new \Exception('$timeout must be a integer.');
        }
        $timeout = intval($timeout);
        if($timeout <= 0) {
            throw new \Exception('$timeout must be geater than 0.');
        }
        $this->timeout = $timeout;
    }

    private function send($payload, $endpoint)
    {
        $this->logger->info(
            'sipay.request', 'request.send', 'I-0001', 'Request Send',
            array('payload' => $payload, 'endpoint' => $endpoint)
        );

        $url = 'https://'.$this->environment.'.sipay.es/mdwr/'.$this->version.'/'.$endpoint;
        $data = array(
        'key' => $this->key,
        'nonce' => "".time(),
        'mode' => $this->mode,
        'resource' => $this->resource,
        'payload' => $payload
        );

        $body = json_encode($data);
        $signature = hash_hmac($this->mode, $body, $this->secret);

        $options = array(
        'http' => array(
        'header'  => "Content-type: application/json\r\nContent-Signature: ".$signature."\r\n",
        'method'  => 'POST',
        'content' => $body,
        'timeout' => $this->timeout,
        'ignore_errors' => true
        ),
        );
        $context  = stream_context_create($options);
        try {
            $response_body = file_get_contents($url, false, $context);
        } catch (Exception $e) {
            $this->logger->error(
                'sipay.request', 'request.response', 'E-0004', 'Request Error',
                array('error_msg' => $e->getMessage())
            );
            $response = null;
            $response_body = null;
        }

        if(!is_null($response_body)) {
            if(isset($http_response_header)) {
                if($response_body == "") {
                    $this->logger->error('sipay.request', 'request.response', 'E-0001', 'Request Error', array());
                    $response = null;

                }else{
                    $is_json = false;
                    foreach($http_response_header as $header){
                        if(substr($header, 0, 30) === "Content-Type: application/json") {
                            $is_json = true;
                            break;
                        }
                    }

                    if($is_json) {
                        $response = json_decode($response_body, true);

                    }else{
                        $this->logger->error('sipay.request', 'request.response', 'E-0003', 'Response no json', array());
                        $response = null;
                    }
                }

            }else{
                $this->logger->error('sipay.request', 'request.response', 'E-0002', 'Request Error', array());
                $response = null;
            }
        }

        $this->logger->info(
            'sipay.request', 'request.response', 'I-0002', 'Request Response',
            array(
                           'payload' => $payload,
                           'endpoint' => $endpoint,
            'response' => $response_body)
        );

                         return array($body, $response);
    }

    private function clean_parameters(array $array_options, array $array_schema)
    {
        $options = array();
        foreach ($array_options as $name => $option) {
            if(isset($array_schema[$name])) {
                $schema = $array_schema[$name];

                if(gettype($option) != $schema['type']) {
                    throw new \Exception("$name incorrect type.");
                }

                if(is_string($option) && isset($schema['pattern']) && !preg_match($schema['pattern'], $option)) {
                    throw new \Exception("$name don't match with pattern.");
                }

                $options[$name] = $option;
            }
        }

        return $options;

    }

    public function authorization(Paymethods\Paymethod $paymethod, Amount $amount, array $array_options = array())
    {

        $array_schema = array(
            'order' => array(
                'type' => 'string',
                'pattern' => '/^[\w-]{6,64}$/'
            ),
            'reference' => array(
                'type' => 'string',
                'pattern' => '/^[0-9]{4}[a-zA-Z0-9]{0,8}$/'
            ),
            'token' => array(
                'type' => 'string',
                'pattern' => '/^[\w-]{6,128}$/'
            ),
            'custom_01' => array(
                'type' => 'string'
            ),
            'custom_02' => array(
                'type' => 'string'
            ),
          );

        $options = $this->clean_parameters($array_options, $array_schema);

        if(isset($options['reference'])) {
            $options['reconciliation'] = $options['reference'];
            unset($options['reference']);
        }


        $payload = array_replace($options, $amount->get_array(), $paymethod->to_json());

        $args = $this->send($payload, 'authorization');
        return new Responses\Authorization($args[0], $args[1]);

    }

    public function refund($identificator, Amount $amount, array $array_options = array())
    {
        $is_paymethod = is_subclass_of($identificator, 'Sipay\Paymethods\Paymethod');
        $is_tx_id = gettype($identificator) == "string" && preg_match('/^[0-9]{6,22}$/', $identificator);

        if (!$is_paymethod && !$is_tx_id) {
            throw new \Exception('incorrect $identificator.');
        }

        $array_schema = array(
            'order' => array(
                'type' => 'string',
                'pattern' => '/^[\w-]{6,64}$/'
            ),
            'reference' => array(
                'type' => 'string',
                'pattern' => '/^[0-9]{4}[a-zA-Z0-9]{0,8}$/'
            ),
            'token' => array(
                'type' => 'string',
                'pattern' => '/^[\w-]{6,128}$/'
            ),
            'custom_01' => array(
                'type' => 'string'
            ),
            'custom_02' => array(
                'type' => 'string'
            ),
          );

        $options = $this->clean_parameters($array_options, $array_schema);

        if(isset($options['reference'])) {
            $options['reconciliation'] = $options['reference'];
            unset($options['reference']);
        }

        if($is_paymethod) {
            $id_array = $identificator->to_json();
        }else{
            $id_array = array('transaction_id' => $identificator);
        }

        $payload = array_replace($options, $amount->get_array(), $id_array);

        $args = $this->send($payload, 'refund');
        return new Responses\Refund($args[0], $args[1]);

    }

    public function register(Paymethods\Paymethod $card, string $token)
    {

        if ($card instanceof Paymethods\StoredCard) {
            throw new \Exception('$card can\'t be StoredCard.');
        }

        if(!preg_match('/^[\w-]{6,128}$/', $token)) {
            throw new \Exception('$token don\'t match with pattern.');
        }

        $payload = array(
          'token' => $token
        );

        $payload = array_replace($payload, $card->to_json());

        $args = $this->send($payload, 'register');
        return new Responses\Register($args[0], $args[1]);

    }

    public function card(string $token)
    {
        if(!preg_match('/^[\w-]{6,128}$/', $token)) {
            throw new \Exception('$token don\'t match with pattern.');
        }

        $payload = array(
          'token' => $token
        );

        $args = $this->send($payload, 'card');
        return new Responses\Card($args[0], $args[1]);

    }

    public function unregister(string $token)
    {
        if(!preg_match('/^[\w-]{6,128}$/', $token)) {
            throw new \Exception('$token don\'t match with pattern.');
        }

        $payload = array(
          'token' => $token
        );

        $args = $this->send($payload, 'unregister');
        return new Responses\Unregister($args[0], $args[1]);

    }

    public function cancellation(string $transaction_id)
    {

        if(!preg_match('/^[0-9]{6,22}$/', $transaction_id)) {
              throw new \Exception('$transaction_id don\'t match with pattern.');
        }

        $payload = array(
          'transaction_id' => $transaction_id
        );

        $args = $this->send($payload, 'cancellation');
        return new Responses\Cancellation($args[0], $args[1]);

    }

    public function query(array $query)
    {
        $payload = array();

        $array_schema = array(
            'order' => array(
                'type' => 'string',
                'pattern' => '/^[\w-]{6,64}$/'
            ),
            'transaction_id' => array(
                'type' => 'string',
                'pattern' => '/^[0-9]{6,22}$/'
            )
          );

        $payload = $this->clean_parameters($query, $array_schema);

        $args = $this->send($payload, 'query');
        return new Responses\Query($args[0], $args[1]);
    }
}

}
