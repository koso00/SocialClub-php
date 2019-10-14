# SocialClub-php 

SocialClub is a freedom of speech inspired instagram clone.
Here the unofficial api supporting almost every basic operation

## Installation

For now, just download the repo and import the auloader like this

```
<?php

require __DIR__. '/vendor/autoload.php';


```


## Usage

To use SocialClub-php instantiate SocialClub object

```
$client = new Nve\SocialClub\Client();
```

Login

```
$client->users->login('username','password');
```

after the login your $client will be logged in and you can use every other resource

##### Note that you must relogin each time you restart the library

## Methods


#### Users

to access user resource you need to instantiate the client and then access


```
- $client->users->login($username,$password)
- $client->users->signup($email,$username,$password,$name)

(After hitting login or signup your client will be logged in and you can use every other resource)

- $client->users->follow($followingId)
- $client->users->changePassword($oldPassword,$newPassword)
- $client->users->getActivity($category,$maxId = null) (category can be all,comment,mention,friend,love)
- $client->users->getActivityForMe($category,$maxId = null)
```

#### Posts

to access posts resource you need to instantiate the client and then access


```
- $client->posts->lovePost($postId)
- $client->posts->unlovePost($postId)
- $client->posts->getComments($postId,$maxId = null)
- $client->posts->commentPost($postId,$content)
- $client->posts->viewPost($postId,$viewCount)
- $client->posts->loveComment($commentId)
- $client->posts->unloveComment($commentId)
- $client->posts->getFeed($userId,$maxId = null)
- $client->posts->getMyFeed($maxId = null)

```
