<?php

namespace App\Controller;

use App\Model\PostManager;
use App\Model\CommentManager;
use App\Model\UserManager;
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
        $this->UserManager = new UserManager();

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

    public function addPost()
    {

        if ($_SESSION['type'] == 2){
            $this->twig->display('post_add.html.twig');
        }else{
            header('Location: home');  
        }
        
    }

    public function addPostConfirm()
    {

        if ($_SESSION['type'] == 2){
        $title = $_POST['titre'];
        $chapo = $_POST['chapo'];
        $content = $_POST['contenu'];      
        $add = $this->PostManager->addPost($title, $chapo, $content, $_SESSION['id']);
        }
   
        header('Location: blog');         

    }

    public function editPost($request)
    {

        if ($_SESSION['type'] == 2){
        $post = $this->PostManager->getById($request['id']);
        $users = $this->UserManager->getUsers();

        $this->twig->display('post_edit.html.twig', ['post' => $post, 'users' => $users]);

        }else{
            header('Location: home');  
        }
    }

    public function editPostConfirm()
    {

        if ($_SESSION['type'] == 2){
        $postid = $_POST['postid'];  
        $title = $_POST['titre'];
        $chapo = $_POST['chapo'];
        $content = $_POST['contenu'];   
        $author = $_POST['auteur'];      
        $add = $this->PostManager->editPost($postid, $title, $chapo, $content, $author);
        }
   
        header('Location: ' . $_SERVER['HTTP_REFERER']);         

    }

    public function removePost($request)
    {

        if ($_SESSION['type'] == 2){
        $add = $this->PostManager->deletePost($request['id']);
        }
   
        header('Location: ' . $_SERVER['HTTP_REFERER']);         

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