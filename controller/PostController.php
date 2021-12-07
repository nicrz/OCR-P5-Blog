<?php

namespace App\Controller;

use App\Model\PostModel;
use App\Model\CommentModel;
use App\Model\UserModel;
use App\Engine\Session;
use App\Engine\SessionObject;
use App\Engine\ServerObject;


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

    // Retourne la liste de tous les posts

    public function postsList()
    {
        $posts = $this->PostModel->getPosts();

        $this->twig->display('listPostsView.html.twig', ['posts' => $posts]);
    }

    // Affiche les détails d'un post

    public function post($request)
    {

        $post = $this->PostModel->getById($request['id']);
        $comments = $this->CommentModel->getCommentsFromPost($request['id']);
        $pendingcomments = $this->CommentModel->getPendingCommentsFromPost($request['id']);

        $session = new SessionObject();

        if (!empty($session->vars['id'])){

            $awaitingcomment = $this->CommentModel->checkIfCommentAwaiting($request['id'], $session->vars['id']);
    
            $this->twig->display('post.html.twig', ['post' => $post, 'comments' => $comments, 'pendingcomments' => $pendingcomments, 'awaitingcomment' => $awaitingcomment]);

        }else{

            $this->twig->display('post.html.twig', ['post' => $post, 'comments' => $comments, 'pendingcomments' => $pendingcomments]);

        }

    }

    // Retourne le formulaire d'ajout d'un post si l'utilisateur dispose du rôle ADMIN

    public function addPost()
    {

        $session = new SessionObject();

        if ($session->vars['type'] == 2){
            $this->twig->display('post_add.html.twig');
        }else{
            header('Location: /OCR-P5-Blog');
        }
        
    }

    // Confirme l'ajout d'un post

    public function addPostConfirm()
    {

        $session = new SessionObject();

        if ($session->vars['type'] == 2){
        $title = filter_input(INPUT_POST, 'titre');
        $chapo = filter_input(INPUT_POST, 'chapo');
        $content = filter_input(INPUT_POST, 'contenu');      
        $add = $this->PostModel->addPost($title, $chapo, $content, $session->vars['id']);
        }
   
        header('Location: blog');         

    }

    // Retourne le formulaire de modification d'un post si l'utilisateur dispose du rôle ADMIN

    public function editPost($request)
    {

        $session = new SessionObject();

        if ($session->vars['type'] == 2){
        $post = $this->PostModel->getById($request['id']);
        $users = $this->UserModel->getUsers();

        $this->twig->display('post_edit.html.twig', ['post' => $post, 'users' => $users]);

        }else{
            header('Location: /OCR-P5-Blog');
        }
    }

    // Confirme la modification du post

    public function editPostConfirm()
    {

        $session = new SessionObject();
        $server = new ServerObject();

        if ($session->vars['type'] == 2){
        $postid = filter_input(INPUT_POST, 'postid');  
        $title = filter_input(INPUT_POST, 'titre');
        $chapo = filter_input(INPUT_POST, 'chapo');
        $content = filter_input(INPUT_POST, 'contenu');   
        $author = filter_input(INPUT_POST, 'auteur');      
        $add = $this->PostModel->editPost($postid, $title, $chapo, $content, $author);
        }
   
        header('Location: ' . $server->vars['HTTP_REFERER']);         

    }

    // Supprime un post

    public function removePost($request)
    {

        $session = new SessionObject();

        if ($session->vars['type'] == 2){
        $add = $this->PostModel->deletePost($request['id']);
        }
   
        header('Location: /OCR-P5-Blog');       

    }

    // Confirme la modification du post

    public function addComment()
    {

        $server = new ServerObject();
        
        $postId = filter_input(INPUT_POST, 'postid');
        $userId = filter_input(INPUT_POST, 'userid');
        $comment = filter_input(INPUT_POST, 'commentaire');

        $add = $this->CommentModel->addComment($comment, $postId, $userId);

        if ($add == true){        
            header('Location: ' . $server->vars['HTTP_REFERER']);         
        }else{
            print_r('Erreur. Redirection dans 3 secondes...');
            header('refresh:3;url=' . $server->vars['HTTP_REFERER']);
        }

    }

    // Confirme la validation d'un commentaire

    public function validateComment($request)
    {

        $session = new SessionObject();

        if ($session->vars['type'] == 2){
        $add = $this->CommentModel->updateCommentStatus(1, $request['id']);
        }
   
        header('Location: /OCR-P5-Blog/blog');       

    }

    // Supprime un commentaire

    public function removeComment($request)
    {

        $session = new SessionObject();

        if ($session->vars['type'] == 2){
        $add = $this->CommentModel->deleteComment($request['id']);
        }
   
        header('Location: /OCR-P5-Blog/blog');       

    }

    public function notFound()
    {
        $this->twig->display('not_found.html.twig', ['message' => 'Erreur 404']);
    }

}