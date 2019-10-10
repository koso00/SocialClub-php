<?php

namespace Nve\SocialClub\Requests;

use Nve\SocialClub\Constants;
use GuzzleHttp\Message\Response;
use Nve\SocialClub\SocialClubId;

class Users {

    private $container;

    public function __construct($container){
        $this->container = $container;
    }

    private function generateRandomString($length = 10) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    public function signup($email,$username,$password,$name){
        $request = (new BaseRequest($this->container,false))->post('users/signup')->send(array(
            "email" => $email,
            "username" => $username,
            "password" => $password,
            "name" => $name,
            "deviceModel" => $this->generateRandomString(),
            "countryCode" => 'IT'
        ))->execute();
        
        if (isset($request->field)){
            switch($request->field){
                case "email":
                        throw new Exceptions\EmailAlreadyTakenException($request->message);
                    break;
                case "username":
                        throw new Exceptions\UsernameAlreadyTakenException($request->message);
                    break;
            }
        }
        echo json_encode($request);

        $this->container->register("id",(new SocialClubId())->setToken($request->token)->setId($request->user->id));
    }

    public function login($username,$password){
        
        $request = (new BaseRequest($this->container,false))->post('users/login')->send(array(
            "emailOrUsername" => $username,
            "password" => $password
        ))->execute();
    
        echo json_encode($request);


        $this->container->register("id",(new SocialClubId())->setToken($request->token)->setId($request->user->id));
        
    }

    public function follow($followingId){
        $request = (new BaseRequest($this->container,true))->post('follows')->send(array(
            "followerId" => $this->container->get('id')->getId(),
            "followingId" => $followingId
        ))->execute();
    
        echo json_encode($request);
        
        
        //$this->container->register("id",(new SocialClubId())->setToken($request->token));
    }

    
}