<?php
require 'vendor/autoload.php';

use App\Controller\HomeController as HomeController;
use App\Controller\PostController as PostController;


$router = new AltoRouter();
$HomeController = new HomeController();
$PostController = new PostController();

$router->setBasePath('/OCR-P5-Blog');
$router->map('GET','/', [$HomeController, "home"]);
$router->map('GET','/index.php', [$HomeController, "home"]);
$router->map('GET','/home', [$HomeController, "home"]);
$router->map('GET','/blog', [$PostController, "postsList"]);
$router->map('GET','/post/[i:id]', [$PostController, "post"]);



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