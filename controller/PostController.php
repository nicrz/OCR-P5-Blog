<?php

namespace App\Controller;

use App\Model\PostManager;
use App\Model\CommentManager;
use App\Engine\Session;


class PostController extends MainController
{
    private $PostManager;
    private $CommentManager;

    public function __construct()
    {
        parent::__construct();

        $this->PostManager = new PostManager();
        $this->CommentManager = new CommentManager();

    }

    public function postsList()
    {
        $posts = $this->PostManager->getPosts();

        $this->twig->display('listPostsView.html.twig', ['posts' => $posts]);
    }

    public function post($request)
    {

        $post = $this->PostManager->getById($request['id']);

        $this->twig->display('post.html.twig', ['post' => $post]);
    }

    public function notFound()
    {
        $this->twig->display('not_found.html.twig', ['message' => 'Erreur 404']);
    }

}