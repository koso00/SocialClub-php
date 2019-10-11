<?php

namespace Nve\SocialClub\Requests;

use Nve\SocialClub\Constants;
use GuzzleHttp\Message\Response;
use Nve\SocialClub\SocialClubId;

class Posts {

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

    public function lovePost($postId){

        $request = (new BaseRequest($this->container,true))->post('loves')->send(array(
            "userId" => $this->container->get('id')->getId(),
            "postId" => $commentId,
        ))->execute();
    
        //echo json_encode($request);
        return $request;
        //$this->container->register("id",(new SocialClubId())->setToken($request->token));
    }

    public function unlovePost($postId){
        //alias because is the same endpoint
        return $this->lovePost($postId);
    }

    public function getComments($postId,$maxId = null){
        $request = (new BaseRequest($this->container,true))->get("posts/$postId/comments")->send(array(
            "userId" => $this->container->get('id')->getId(),
            "maxId" => $maxId
        ))->execute();
    
        //echo json_encode($request);
        return $request;
    }
    
    public function commentPost($postId,$content){

        if ($content == null || $content === ''){
            throw new Exceptions\EmptyContentException('Content must not be empty');
        }

        $request = (new BaseRequest($this->container,true))->post('comments')->send(array(
            "userId" => $this->container->get('id')->getId(),
            "postId" => $postId,
            "content" => $content
        ))->execute();
    
        //echo json_encode($request);
        return $request;
        //$this->container->register("id",(new SocialClubId())->setToken($request->token));
    }

    public function viewPost($postId,$viewCount){

        $request = (new BaseRequest($this->container,true))->post('posts/view')->send(array(
            "userId" => $this->container->get('id')->getId(),
            "postId" => $postId,
            "viewCount" => $viewCount
        ))->execute();
    
        //echo json_encode($request);
        return $request;

    }
    public function loveComment($commentId){

        $request = (new BaseRequest($this->container,true))->post('comments/love')->send(array(
            "userId" => $this->container->get('id')->getId(),
            "commentId" => $commentId,
        ))->execute();
    
        //echo json_encode($request);
        return $request;
        //$this->container->register("id",(new SocialClubId())->setToken($request->token));
    }

    public function unloveComment($commentId){

        $request = (new BaseRequest($this->container,true))->post('comments/unlove')->send(array(
            "userId" => $this->container->get('id')->getId(),
            "commentId" => $commentId,
        ))->execute();
    
        //echo json_encode($request);
        return $request;
        //$this->container->register("id",(new SocialClubId())->setToken($request->token));
    }

    public function getFeed($userId,$maxId = null){

        $request = (new BaseRequest($this->container,true))->get('users/feed')->send(array(
            "userId" => $userId,
            "maxId" => $commentId,
        ))->execute();
    
        //echo json_encode($request);
        return $request;
    }

    public function getMyFeed($maxId = null){

        $request = (new BaseRequest($this->container,true))->get('users/feed')->send(array(
            "userId" => $this->container->get('id')->getId(),
            "maxId" => $commentId,
        ))->execute();
    
        //echo json_encode($request);
        return $request;
    }
    
    
}