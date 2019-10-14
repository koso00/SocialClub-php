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
       // echo json_encode($request);

       $this->container->get("id")->setToken($request->token)->setId($request->user->id);
       return $request;
    }

    public function login($username,$password){
        
        $request = (new BaseRequest($this->container,false))->post('users/login')->send(array(
            "emailOrUsername" => $username,
            "password" => $password
        ))->execute();
    
        //echo json_encode($request);


        $this->container->get("id")->setToken($request->token)->setId($request->user->id);
        return $request;

    }

    public function follow($followingId){
        $request = (new BaseRequest($this->container,true))->post('follows')->send(array(
            "followerId" => $this->container->get('id')->getId(),
            "followingId" => $followingId
        ))->execute();
    
        //echo json_encode($request);
        return $request;
        //$this->container->register("id",(new SocialClubId())->setToken($request->token));
    } 

    public function changePassword($oldPassword,$newPassword){
        $request = (new BaseRequest($this->container,true))->post('follows')->send(array(
            "userId" => $this->container->get('id')->getId(),
            "oldPassword" => $oldPassword,
            "newPassword" => $newPassword
        ))->execute();
    
//        echo json_encode($request);
        return $request;

        //$this->container->register("id",(new SocialClubId())->setToken($request->token));
    }

    public function getActivity($category,$maxId = null){

        switch($category){
            case Constants::ACTIVITY_CATEGORY_ALL:break;
            case Constants::ACTIVITY_CATEGORY_COMMENT:break;
            case Constants::ACTIVITY_CATEGORY_MENTION:break;
            case Constants::ACTIVITY_CATEGORY_FRIEND:break;
            case Constants::ACTIVITY_CATEGORY_LOVE:break;
            default:
                throw new Exceptions\ActivityCategoryNotFoundException("$category is not an activity category");
                break;
        }

        $request = (new BaseRequest($this->container,true))->post('users/activity')->send(array(
            "userId" => $this->container->get('id')->getId(),
            "category" => $category,
            "maxId" => $maxId
        ))->execute();
    
//        echo json_encode($request);
        return $request;
        //$this->container->register("id",(new SocialClubId())->setToken($request->token));
    }

    public function getActivityForMe($category,$maxId = null){

        switch($category){
            case Constants::ACTIVITY_CATEGORY_ALL:break;
            case Constants::ACTIVITY_CATEGORY_COMMENT:break;
            case Constants::ACTIVITY_CATEGORY_MENTION:break;
            case Constants::ACTIVITY_CATEGORY_FRIEND:break;
            case Constants::ACTIVITY_CATEGORY_LOVE:break;
            default:
                throw new Exceptions\ActivityCategoryNotFoundException("$category is not an activity category");
                break;
        }

        $request = (new BaseRequest($this->container,true))->post('users/activity/for-me')->send(array(
            "userId" => $this->container->get('id')->getId(),
            "category" => $category,
            "maxId" => $maxId
        ))->execute();
    
//        echo json_encode($request);
        return $request;
        //$this->container->register("id",(new SocialClubId())->setToken($request->token));
    }
    
    
}