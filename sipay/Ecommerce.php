<?php

namespace Sipay;

class Ecommerce{
    protected $logger;
    protected $key;
    protected $secret;
    protected $resource;
    protected $environment;
    protected $version;
    protected $mode;
    protected $timeout;

    public function __construct($config_path){
        if (gettype($config_path) != "string"){
            throw new \Exception('$config_path must be a string.');
        }

        $config = parse_ini_file($config_path, true);

        $this->logger = new Logger($config['logger']);

        $cred = $config['credentials'];
        $this->setKey(array_key_exists('key', $cred) ? $cred['key'] : '');
        $this->setSecret(array_key_exists('secret', $cred) ? $cred['secret'] : '');
        $this->setResource(array_key_exists('resource', $cred) ? $cred['resource'] : '');

        $api = $config['api'];
        $this->setEnvironment(array_key_exists('environment', $api) ? $api['environment'] : '');
        $this->setVersion(array_key_exists('version', $api) ? $api['version'] : '');
        $this->setMode(array_key_exists('mode', $api) ? $api['mode'] : '');

        $connection = $config['connection'];
        $this->setTimeout(array_key_exists('timeout', $connection) ? $connection['timeout'] : '30');
    }

  	public function getKey(){
  		return $this->key;
  	}

  	public function setKey($key){
      if (gettype($key) != "string"){
          throw new \Exception('$key must be a string.');
      }
      if(!preg_match("/^[\w-]{6,32}$/", $key)){
          throw new \Exception('$key don\'t match with pattern.');
      }
  		$this->key = $key;
  	}

  	public function getSecret(){
  		return $this->secret;
  	}

  	public function setSecret($secret){
      if (gettype($secret) != "string"){
          throw new \Exception('$secret must be a string.');
      }
      if(!preg_match("/^[\w-]{6,32}$/", $secret)){
          throw new \Exception('$secret don\'t match with pattern.');
      }
  		$this->secret = $secret;
  	}

  	public function getResource(){
  		return $this->resource;
  	}

  	public function setResource($resource){
      if (gettype($resource) != "string"){
          throw new \Exception('$resource must be a string.');
      }
      if(!preg_match("/^[\w-]{6,32}$/", $resource)){
          throw new \Exception('$resource don\'t match with pattern.');
      }
  		$this->resource = $resource;
  	}

  	public function getEnvironment(){
  		return $this->environment;
  	}

  	public function setEnvironment($environment){
      if (gettype($environment) != "string"){
          throw new \Exception('$environment must be a string.');
      }
      if(!in_array($environment, array('develop','sandbox', 'staging', 'live'))){
          throw new \Exception('$environment must be sandbox, staging or live.');
      }
  		$this->environment = $environment;
  	}

  	public function getVersion(){
  		return $this->version;
  	}

  	public function setVersion($version){
      if (gettype($version) != "string"){
          throw new \Exception('$version must be a string.');
      }
      if($version != "v1"){
          throw new \Exception('$version must be v1.');
      }
  		$this->version = $version;
  	}

  	public function getMode(){
  		return $this->mode;
  	}

  	public function setMode($mode){
      if (gettype($mode) != "string"){
          throw new \Exception('$mode must be a string.');
      }
      if(!in_array($mode, array('sha256','sha512'))){
          throw new \Exception('$mode must be sha256 or sha512.');
      }
  		$this->mode = $mode;
  	}

  	public function getTimeout(){
  		return $this->timeout;
  	}

  	public function setTimeout($timeout){
      if (!is_numeric($timeout)){
          throw new \Exception('$timeout must be a integer.');
      }
      $timeout = intval($timeout);
      if($timeout <= 0){
          throw new \Exception('$timeout must be geater than 0.');
      }
  		$this->timeout = $timeout;
  	}

  public function send($payload, $endpoint){
    $url = 'https://'.$this->environment.'.sipay.es/mdwr/'.$this->version.'/'.$endpoint;
    // $url = 'http://localhost:8081/odor/api/v1/verify';
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
    $response_body = file_get_contents($url, false, $context);

    if(isset($http_response_header)){
      if($response_body == ""){
        $this->logger->error('sipay.request', 'request.response', 'E-0001', 'Request Error', array());
        $response = null;

      }else{
        $is_json = false;
        foreach($http_response_header as $header){
          if(substr($header, 0, 30) === "Content-Type: application/json"){
            $is_json = true;
            break;
          }
        }

        if($is_json){
          $response = json_decode($response_body);

        }else{
          $this->logger->error('sipay.request', 'request.response', 'E-0003', 'Response no json', array());
          $response = null;
        }
      }

    }else{
      $this->logger->error('sipay.request', 'request.response', 'E-0002', 'Request Error', array());
      $response = null;
    }

    return $response;
  }
}
