<?php
namespace NocVissor\Papi;

use NocVissor\Papi\Auth\Auth;
use Exception;

class Api{
    private ?Auth $auth = null;
    public Request $based_request;
    public Cache $cache;
    public string $base_url = '';
    public $debug = false;
    public function __construct(string $url = '')
    {
        $this->base_url = $url;
        $this->based_request = new Request();
        $this->cache = new Cache();
    }
    // connect Auth class to Api
    public function auth(Auth $auth){
        $this->auth = $auth;
        $this->auth->link($this);
    } 
    // set new Request
    public function setBase($request){
        $this->based_request = $request;
    }
    // add options Request
    public function mergeBase($request){
        $this->based_request = Request::merge($this->based_request, $request);
    }
    // required: url, method
    // params: url, method, is_absolute, ch, request
    public function query($data){
        if(isset($data['request']) && !is_null($data['request'])){
            $request = $data['request'];
        }
        else{
            $request = new Request();
        }

        if((isset($data['is_absolute']) && $data['is_absolute']) || 
        strripos($data['url'], 'http://') === true ||
        strripos($data['url'], 'https://') === true
        ){
            $url = $data['url'];
        }
        else{
            $url = $this->base_url.$data['url'];
        }
        $result_request = Request::merge($request, $this->based_request);
        if(!is_null($this->auth)){
            $result_request = Request::merge($result_request, $this->auth->request);
        }

        $result = Curl::query([
            'url' => $url,
            'method' => $data['method'],
            'request' => $result_request,
            'ch' => isset($data['ch'])?$data['ch']:false,
            'debug' => $this->debug
        ]);
        $result = json_decode($result);
        return $result;
    }


    public function get($url, Request $request = null){
        return $this->query([
            'url' => $url,
            'request' => $request,
            'method' => 'get'
        ]);
    }
    public function post($url, Request $request = null){
        return $this->query([
            'url' => $url,
            'request' => $request,
            'method' => 'post'
        ]);
    }
    public function put($url, Request $request = null){
        return $this->query([
            'url' => $url,
            'request' => $request,
            'method' => 'put'
        ]);
    }
    public function patch($url, Request $request = null){
        return $this->query([
            'url' => $url,
            'request' => $request,
            'method' => 'patch'
        ]);
    }
    public function delete($url, Request $request = null){
        return $this->query([
            'url' => $url,
            'request' => $request,
            'method' => 'delete'
        ]);
    }

}