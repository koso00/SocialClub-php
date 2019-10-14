<?php

require __DIR__. '/vendor/autoload.php';



$username = getenv("USERNAME");
$password = getenv("PASSWORD");
$startId = intval(getenv("START"));
$endId = intval(getenv("END"));

if ($endId <= $startID){
    throw new \Exception("End must not be minor than start");
}
//("percosets","Jewell4Life691029");
//setProxy( $socialclub);
$socialclub = new Nve\SocialClub\Client(); 
$i = $startId;
$socialclub->users->login($username,$password);
while($i < $endId){
    //$socialclub->signup("danisdnsaskd@".generateRandomString().".com",generateRandomString(),generateRandomString(),generateRandomString());
    $socialclub->users->follow($i);
    $socialclub->users->unfollow($i);
    //sleep(0.5);
    $i++;
}