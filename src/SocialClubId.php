<?php

namespace Nve\SocialClub;

class SocialClubId {
    private $token;
    private $id;

    public function setId($id){
        $this->id = $id;
        return $this;
    }

    public function getId(){
        return $this->id;
    }
    
    public function setToken($token){
        $this->token = $token;
        return $this;
    }

    public function getToken(){
        return $this->token;
    }
}
