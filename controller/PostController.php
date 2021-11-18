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
        $comments = $this->CommentManager->getCommentsFromPost($request['id']);
        $pendingcomments = $this->CommentManager->getPendingCommentsFromPost($request['id']);

        if (!empty($_SESSION['id'])){

            $awaitingcomment = $this->CommentManager->checkIfCommentAwaiting($request['id'], $_SESSION['id']);
    
            $this->twig->display('post.html.twig', ['post' => $post, 'comments' => $comments, 'pendingcomments' => $pendingcomments, 'awaitingcomment' => $awaitingcomment]);

        }else{

            $this->twig->display('post.html.twig', ['post' => $post, 'comments' => $comments, 'pendingcomments' => $pendingcomments]);

        }

    }

    public function addComment()
    {
        $postId = $_POST['postid'];
        $userId = $_POST['userid'];
        $comment = $_POST['commentaire'];

        $add = $this->CommentManager->addComment($comment, $postId, $userId);

        if ($add == true){        
            header('Location: ' . $_SERVER['HTTP_REFERER']);         
        }else{
            echo 'Erreur. Redirection dans 3 secondes...';
            header('refresh:3;url=' . $_SERVER['HTTP_REFERER']);
        }

    }

    public function validateComment($request)
    {

        if ($_SESSION['type'] == 2){
        $add = $this->CommentManager->updateCommentStatus(1, $request['id']);
        }
   
        header('Location: ' . $_SERVER['HTTP_REFERER']);         

    }

    public function removeComment($request)
    {

        if ($_SESSION['type'] == 2){
        $add = $this->CommentManager->deleteComment($request['id']);
        }
   
        header('Location: ' . $_SERVER['HTTP_REFERER']);         

    }

    public function notFound()
    {
        $this->twig->display('not_found.html.twig', ['message' => 'Erreur 404']);
    }

}