<?php
require 'vendor/autoload.php';

use App\Controller\HomeController as HomeController;
use App\Controller\PostController as PostController;
use App\Controller\LoginController as LoginController;
use App\Controller\AdminController as AdminController;



$router = new AltoRouter();
$HomeController = new HomeController();
$PostController = new PostController();
$LoginController = new LoginController();
$AdminController = new AdminController();

$router->setBasePath('/OCR-P5-Blog');
$router->map('GET','/', [$HomeController, "home"]);
$router->map('GET','/index.php', [$HomeController, "home"]);
$router->map('GET','/home', [$HomeController, "home"]);
$router->map('GET','/blog', [$PostController, "postsList"]);
$router->map('GET','/post/[i:id]', [$PostController, "post"]);
$router->map('GET','/login', [$LoginController, "loginPage"]);
$router->map('GET','/register', [$LoginController, "registerPage"]);
$router->map('POST','/authenticate', [$LoginController, "checkLogin"]);
$router->map('POST','/register_confirm', [$LoginController, "checkRegister"]);
$router->map('GET','/logout', [$LoginController, "logout"]);
$router->map('POST','/addcomment', [$PostController, "addComment"]);
$router->map('GET','/comment_validation/[i:id]', [$PostController, "validateComment"]);
$router->map('GET','/comment_delete/[i:id]', [$PostController, "removeComment"]);
$router->map('GET','/post_edit/[i:id]', [$PostController, "editPost"]);
$router->map('POST','/post_edit_confirm', [$PostController, "editPostConfirm"]);
$router->map('GET','/post_add', [$PostController, "addPost"]);
$router->map('POST','/post_add_confirm', [$PostController, "addPostConfirm"]);
$router->map('GET','/post_delete/[i:id]', [$PostController, "removePost"]);
$router->map('GET','/users_list', [$AdminController, "usersList"]);
$router->map('GET','/user_edit/[i:id]', [$AdminController, "userEdit"]);
$router->map('POST','/user_edit_confirm', [$AdminController, "userEditConfirm"]);


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