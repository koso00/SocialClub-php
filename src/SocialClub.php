<?php

namespace Nve\SocialClub;
use Nve\SocialClub\Container;

class SocialClub {

    private $container;

    public $users;
    public $posts;

    public function __construct(){
        $this->container = new Container();
        $this->container->register("id",new SocialClubId());
        $this->users = (new Requests\Users($this->container));
        $this->posts = (new Requests\Posts($this->container));

    }
 
    public function setProxy($proxy){
        $this->container->register("proxy",$proxy);
    }
   


}