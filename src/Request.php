<?php
namespace Kaliostro\Papi;


class Request{
    public $headers = [];
    public $post = [];
    public $get = [];
    public function __construct($data = [
        'headers' => [],
        'post' => [],
        'get' => []
    ])
    {   
        $this->headers = isset($data['headers'])?$data['headers']:[];
        $this->post = isset($data['post'])?$data['post']:[];
        $this->get = isset($data['get'])?$data['get']:[];
    }

    public static function merge(Request ...$requests){
        $result = new Request();
        foreach($requests as $request){
            $result->headers = self::array_merge($result->headers, $request->headers);
            $result->post = self::array_merge($result->post, $request->post);
            $result->get = self::array_merge($result->get, $request->get);
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