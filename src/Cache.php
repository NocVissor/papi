<?php
namespace NocVissor\Papi;

class Cache{
    public string $path;
    public function __construct()
    {
        $this->path = './cache';
    }
    public function setPath($path){
        $this->path = $path;
    }
    public function put($name, $data){
        if(!is_dir($this->path)){
            mkdir($this->path);
        }
        return file_put_contents($this->path.'/'.$name, $data);
    }

    public function get($name){
        $path = $this->path.'/'.$name;
        if(!is_dir($this->path)){
            mkdir($this->path);
            return false;
        }
        if(!is_file($path)) return false;
        return file_get_contents($path);
    }
}