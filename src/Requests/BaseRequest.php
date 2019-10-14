<?php

namespace Nve\SocialClub\Requests;

use Nve\SocialClub\Constants;
use CloudflareBypass\CFCurlImpl;
use CloudflareBypass\Model\UAMOptions;

class BaseRequest {

    private $loop;
    private $request;
    private $method;
    private $url;
    private $post = [];
    private $requireToken;

    public function __construct($container,$requireToken = false){
        $this->container = $container;
        $this->requireToken = $requireToken;
        return $this;
    }

    public function get($url){
        $this->url =  $url;
        $this->method = 'GET';
        return $this;
    }

    public function post($url){
        $this->url = $url;
        $this->method = 'POST';
        return $this;
    }
    public function delete($url){
        $this->url = $url;
        $this->method = "DELETE";
        return $this;
    }
    public function send(array $post){
        $this->post = $post;
        return $this;
    }

    private function isJson($string) {
        json_decode($string);
        return (json_last_error() == JSON_ERROR_NONE);
    }
    public function execute(){
        
        /*
        $res = "159.65.237.253:8080
        134.209.162.5:80
        159.203.87.130:3128
        165.22.44.147:80
        157.245.123.106:8080
        159.65.253.142:8888
        157.245.139.37:8080
        167.71.182.191:3128
        167.71.97.146:3128
        165.227.220.35:3128
        174.138.38.135:8080
        51.79.78.89:3128
        157.245.0.181:3128
        68.183.147.115:3128
        3.227.191.84:3128
        157.245.14.4:3128
        67.205.165.60:8083
        192.99.203.93:35289
        52.170.232.208:8888
        167.71.165.21:3128
        165.22.184.132:80
        40.76.59.221:80
        45.77.106.122:32125
        167.71.252.107:3128
        149.56.1.48:8181
        159.89.191.89:80
        162.253.55.74:1080
        157.230.182.68:3128
        157.245.6.102:3128";

        $res = explode("\n",$res);

        $p = str_replace("\r", '', $res[mt_rand(0, count($res) - 1)]);
                */
        $headers = array(
            'authorization: Basic Og==',
            'content-type: application/x-www-form-urlencoded',
            "Accept: application/json"
        );

        if ($this->requireToken){

            if ($this->container->get('id')->getToken() == null){
                throw new Exceptions\LoginNeededException("To access this resource you need to login first; use SocialClub->users->login() method");
            }
            array_push($headers,'X-Access-Token: '.$this->container->get('id')->getToken());
        }
        
        $h_ = "";

        foreach ($headers as $h){
            $h_ = $h_." --header '$h' ";
        }
        
        if (count($this->post) != 0){
            $data = array_filter($this->post,function($var){return $var != null;});
            $data =  http_build_query($data,null,"&");
            $data = "--data '$data'";
        }else{
            $data = "";
        }
       
        $method = $this->method;
        $url = Constants::BASE_URL.$this->url;

        $proxy = $this->container->get("proxy") != null ? "--proxy ".$this->container->get("proxy") : '';
        // --max-time 4
        $cmd = "curl $proxy --silent --request $method --url '$url' $h_ $data";
        
        echo $cmd;
        //echo $cmd;
        //echo $cmd;
        $response = shell_exec($cmd);

        echo $response;

        $response = json_decode($response);
        
        /*
        if (!$this->isJson($response)){
            $response = json_decode($response);
        }*/
        //echo $response;
        return $response;
    }



}