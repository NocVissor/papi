<?php
namespace NocVissor\Papi\Auth;
use NocVissor\Papi\{
    Api,
    Auth\Auth,
    Request
};
use NocVissor\Papi\Auth\BearerAuth;





class SkorozvonAuth extends Auth{
    private $login;
    private $api_key;
    private $id;
    private $secret;
    public function __construct($login, $api_key, $id, $secret)
    {
        parent::__construct();
        $this->login = $login;
        $this->api_key = $api_key;
        $this->id = $id;
        $this->secret = $secret;
    }


    private function get_token(){
        $file = $this->api->post('https://app.skorozvon.ru/oauth/token', [
            'post' => [
                'grant_type' => 'password',
                'username' => $this->login,
                'api_key' => $this->api_key,
                'client_id' => $this->id,
                'client_secret' => $this->secret,
            ]
        ]);
        $this->api->cache->put('skorozvon', json_encode($file));

        return $file->access_token;
    }
    private function refresh_token($access, $refresh){
        $file = $this->api->post('https://app.skorozvon.ru/oauth/token', [
            'post' => [
                'grant_type' => 'refresh_token',
                'refresh_token' => $refresh,
                'client_id' => $this->id,
                'client_secret' => $this->secret,
            ],
            'headers' => [
                'Authorization' => 'Bearer '.$access
            ]
        ]);
        $this->api->cache->put('skorozvon', json_encode($file));
        return $file->access_token;
    }

    public function link(Api $api){
        parent::__construct();
        $this->api = $api;
        if($file = $api->cache->get('skorozvon')){
            $file = json_decode($file);
            if(!isset($file->access_token)){
                $token = $this->get_token();
            }
            else if(strtotime('now') - $file->created_at > 60*60*1.95){
                $token = $this->refresh_token($file->access_token, $file->refresh_token);
            }
            else{
                $token = $file->access_token;
            }
        }
        else{
            $token = $this->get_token();
        }
        $api->base_url = "https://app.skorozvon.ru/api/v2";
        $api->auth(new BearerAuth($token));
    }
}