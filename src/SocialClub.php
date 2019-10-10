<?php

namespace Nve\SocialClub;
use Nve\SocialClub\Container;

class SocialClub {

    private $container;

    public function __construct(){
        $this->container = new Container();
        
    }
 
    public function setProxy($proxy){
        $this->container->register("proxy",$proxy);
    }
    public function login($username,$password){
        return (new Requests\Users($this->container))->login($username,$password);
    }

    public function signup($email,$username,$password,$name){
        return (new Requests\Users($this->container))->signup($email,$username,$password,$name);
    }
    public function follow($followingId){
        return (new Requests\Users($this->container))->follow($followingId);
    }
    


}