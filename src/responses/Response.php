<?php
namespace Sipay\Responses;

class Response
{
    protected $request;
    protected $response;
    public $code;
    public $detail;
    public $description;
    public $request_id;
    public $type;
    public $uuid;

    protected function set_common($request, $response) {
        $this->request = $request;
        $this->response = $response;
        if(is_array($response)){
            $this->code = isset($response['code']) ? $response['code'] : null;
            $this->detail = isset($response['detail']) ? $response['detail'] : null;
            $this->description = isset($response['description']) ? $response['description'] : null;
            $this->request_id = isset($response['request_id']) ? $response['request_id'] : null;
            $this->type = isset($response['type']) ? $response['type'] : null;
            $this->uuid = isset($response['uuid']) ? $response['uuid'] : null;


            if($this->code !== ""){
                $this->code = intval($this->code);
            }

            return isset($response['payload']) ? $response['payload'] : null;
        }else{
          return array();
        }

    }
}
