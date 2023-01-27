<?php
namespace NocVissor\Papi;


class Request{
    public $headers = [];
    public $post = [];
    public $post_raw = "";
    public $get = [];
    public $curl_setpot = [];
    public $forfield = true;
    public function __construct($data = [
        'headers' => [],
        'post' => [],
        'get' => [],
        'curl_setpot' => [],
        'forfield' => true
    ])
    {   
        $this->headers = isset($data['headers'])?$data['headers']:[];
        $this->post_raw = isset($data['post_raw'])?$data['post_raw']:[];
        $this->post = isset($data['post'])?$data['post']:[];
        $this->get = isset($data['get'])?$data['get']:[];
        $this->curl_setpot = isset($data['curl_setpot'])?$data['curl_setpot']:[];
        $this->forfield = isset($data['forfield'])?$data['forfield']:true;

    }

    public static function merge(Request ...$requests){
        $result = new Request(['forfield' => $requests[0]->forfield]);
        foreach($requests as $request){
            $result->headers = self::array_merge($result->headers, $request->headers);
            $result->post = self::array_merge($result->post, $request->post);
            $result->get = self::array_merge($result->get, $request->get);
            $result->curl_setpot = self::array_merge($result->curl_setpot, $request->curl_setpot);
            if($request->post_raw) $result->post_raw = $request->post_raw;
        }
        return $result;
    }

    private static function array_merge($general, $additional){
        $result = $general;
        foreach($additional as $key => $val){
            if(!isset($result[$key])){
                $result[$key] = $val;
            }
        }
        return $result;
    }
}