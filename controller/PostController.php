<?php

namespace App\Controller;

use App\Model\PostManager;


class PostController extends MainController
{
    private $PostManager;

    public function __construct()
    {
        parent::__construct();

        $this->PostManager = new PostManager();

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