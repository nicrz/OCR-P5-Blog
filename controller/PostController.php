<?php

namespace App\Controller;

use App\Model\PostModel;
use App\Model\CommentModel;
use App\Model\UserModel;
use App\Engine\Session;


class PostController extends MainController
{
    private $PostModel;
    private $CommentModel;

    public function __construct()
    {
        parent::__construct();

        $this->PostModel = new PostModel();
        $this->CommentModel = new CommentModel();
        $this->UserModel = new UserModel();

    }

    public function postsList()
    {
        $posts = $this->PostModel->getPosts();

        $this->twig->display('listPostsView.html.twig', ['posts' => $posts]);
    }

    public function post($request)
    {

        $post = $this->PostModel->getById($request['id']);
        $comments = $this->CommentModel->getCommentsFromPost($request['id']);
        $pendingcomments = $this->CommentModel->getPendingCommentsFromPost($request['id']);

        if (!empty($_SESSION['id'])){

            $awaitingcomment = $this->CommentModel->checkIfCommentAwaiting($request['id'], $_SESSION['id']);
    
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
            header('Location: /OCR-P5-Blog');
        }
        
    }

    public function addPostConfirm()
    {

        if ($_SESSION['type'] == 2){
        $title = $_POST['titre'];
        $chapo = $_POST['chapo'];
        $content = $_POST['contenu'];      
        $add = $this->PostModel->addPost($title, $chapo, $content, $_SESSION['id']);
        }
   
        header('Location: blog');         

    }

    public function editPost($request)
    {

        if ($_SESSION['type'] == 2){
        $post = $this->PostModel->getById($request['id']);
        $users = $this->UserModel->getUsers();

        $this->twig->display('post_edit.html.twig', ['post' => $post, 'users' => $users]);

        }else{
            header('Location: /OCR-P5-Blog');
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
        $add = $this->PostModel->editPost($postid, $title, $chapo, $content, $author);
        }
   
        header('Location: ' . $_SERVER['HTTP_REFERER']);         

    }

    public function removePost($request)
    {

        if ($_SESSION['type'] == 2){
        $add = $this->PostModel->deletePost($request['id']);
        }
   
        header('Location: /OCR-P5-Blog');       

    }

    public function addComment()
    {
        $postId = $_POST['postid'];
        $userId = $_POST['userid'];
        $comment = $_POST['commentaire'];

        $add = $this->CommentModel->addComment($comment, $postId, $userId);

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
        $add = $this->CommentModel->updateCommentStatus(1, $request['id']);
        }
   
        header('Location: /OCR-P5-Blog');       

    }

    public function removeComment($request)
    {

        if ($_SESSION['type'] == 2){
        $add = $this->CommentModel->deleteComment($request['id']);
        }
   
        header('Location: /OCR-P5-Blog');       

    }

    public function notFound()
    {
        $this->twig->display('not_found.html.twig', ['message' => 'Erreur 404']);
    }

}