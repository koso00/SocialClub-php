<?php

namespace Nve\SocialClub;
use Nve\SocialClub\Container;

class Client {

    private $container;

    public $users;
    public $posts;

    public function __construct(){
        $this->container = new Container();

        $proxy = getenv("PROXY");
        if ($proxy == false){
            $proxy = null;
        }
        $this->container->register("proxy",$proxy);
        $this->container->register("id",new SocialClubId());
        $this->users = (new Requests\Users($this->container));
        $this->posts = (new Requests\Posts($this->container));

    }
 
    public function setProxy($proxy){
        $this->container->register("proxy",$proxy);
    }
   


}