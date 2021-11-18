<?php
require 'vendor/autoload.php';

use App\Controller\HomeController as HomeController;
use App\Controller\PostController as PostController;
use App\Controller\LoginController as LoginController;


$router = new AltoRouter();
$HomeController = new HomeController();
$PostController = new PostController();
$LoginController = new LoginController();

$router->setBasePath('/OCR-P5-Blog');
$router->map('GET','/', [$HomeController, "home"]);
$router->map('GET','/index.php', [$HomeController, "home"]);
$router->map('GET','/home', [$HomeController, "home"]);
$router->map('GET','/blog', [$PostController, "postsList"]);
$router->map('GET','/post/[i:id]', [$PostController, "post"]);
$router->map('GET','/login', [$LoginController, "loginPage"]);
$router->map('POST','/authenticate', [$LoginController, "checkLogin"]);
$router->map('GET','/logout', [$LoginController, "logout"]);
$router->map('POST','/addcomment', [$PostController, "addComment"]);
$router->map('GET','/comment_validation/[i:id]', [$PostController, "validateComment"]);
$router->map('GET','/comment_delete/[i:id]', [$PostController, "removeComment"]);



$match = $router->match();

if($match && is_callable($match['target'])) {
    if(!empty($match['params'])){
        call_user_func($match['target'], $match['params']);
    }else{
        call_user_func($match['target']);
    }
} else {
    $HomeController->notFound();
}