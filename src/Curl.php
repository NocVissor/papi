<?php
namespace NocVissor\Papi;

use Exception;

class Curl {

    public static function forfield_build($data){
        $strs = [];
        if(is_object($data)) $data = (array) $data;
        if(is_array($data)){
            foreach($data as $key => $value){
                if(is_array($value)){
                    foreach($value as $k2 => $v2){
                        if(is_array($v2)){
                            $strs[] = self::forfield_build($v2);
                        }
                        else{
                            $strs[] = urlencode($key)."[][$k2]=".urlencode($v2);
                        }
                    }

                }
                else{
                    $strs[] = urlencode($key)."=".urlencode($value);
                }
            }
        }
        return implode('&', $strs);
    }


    //required ch, url, method, request
    public static function query($data){
        if($data["debug"]){
            echo "<pre>";
            print_r($data);
            echo "</pre>";
        }

        $request = $data['request'];
        //print_r($request);

        if($request->post_raw){
            $request->post = $request->post_raw;
        }
        else if(!empty($request->post) && $request->forfield){
            $request->post = self::forfield_build($request->post);
        }

        $url = $data['url'];
        if(!empty($request->get)){
            $url .= '?'.http_build_query($request->get);
        }
        
        if($data['ch']){
            $ch = $data['ch'];
        }
        else{
            $ch = curl_init();
        }
        // echo  $url;
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER, true);
        $postfields = false;

        switch($data['method']){
            case 'post':
                curl_setopt($ch, CURLOPT_POST, 1);
                $postfields = true;
                break;
            case 'put':
                curl_setopt($ch, CURLOPT_PUT, 1);
                $postfields = true;
                break;
            case 'patch':
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PATCH');
                $postfields = true;
                break;
            case 'delete':
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'DELETE');
                $postfields = true;
                break;
        }
        if($postfields){
            if(!empty($request->post)){
                curl_setopt($ch, CURLOPT_POSTFIELDS, $request->post);
            }
        }

        if(!empty($request->headers)){
            $headers = [];
            foreach($request->headers as $key=>$header){
                $headers[] = $key.": ".$header;
            }
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        }

        if(!empty($request->curl_setpot)){
            foreach($request->curl_setpot as $key=>$value){
                curl_setopt($ch, $key, $value);
            }
        }

        $result = curl_exec($ch);
        if($data["debug"]){
            print_r($result);
            echo "result";
        }
        if($message = curl_error($ch)) {
            throw new Exception($message);
        }
        curl_close ($ch);
        return $result;
    }


    public static function stringValid($string){
        return mb_strtolower(trim($string));
    }
}