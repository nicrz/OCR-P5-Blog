<?php

namespace App\Controller;

use App\Model\PostModel;
use App\Model\CommentModel;
use App\Model\UserModel;
use App\Engine\Session;
use App\Engine\Header;
use App\Engine\Printer;
use App\Engine\SessionObject;
use App\Engine\ServerObject;


class PostController extends MainController
{
    private $PostModel;
    private $CommentModel;
    private $Header;
    private $Printer;

    public function __construct()
    {
        parent::__construct();

        $this->PostModel = new PostModel();
        $this->CommentModel = new CommentModel();
        $this->UserModel = new UserModel();
        $this->Header = new Header();
        $this->Printer = new Printer();

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
            $this->Header->set('Location: ./../blog');
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
        $this->PostModel->addPost($title, $chapo, $content, $session->vars['id']);
        }
        
        $this->Printer->set('Article ajouté, redirection vers le blog...');
        $this->Header->set('refresh:3;url=blog');
        //$this->Header->set('Location: blog');       

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
            $this->Header->set('Location: ./../blog');
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
        $this->PostModel->editPost($postid, $title, $chapo, $content, $author);
        }
   
        $this->Header->set('Location: ' . $server->vars['HTTP_REFERER']);   

    }

    // Supprime un post

    public function removePost($request)
    {

        $session = new SessionObject();

        if ($session->vars['type'] == 2){
        $this->PostModel->deletePost($request['id']);
        }
   
        $this->Header->set('Location: ./../blog');

    }

    public function notFound()
    {
        $this->twig->display('not_found.html.twig', ['message' => 'Erreur 404']);
    }

}