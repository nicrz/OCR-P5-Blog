<?php

namespace App\Controller;

use App\Model\PostModel;
use App\Model\CommentModel;
use App\Model\UserModel;
use App\Engine\Session;
use App\Engine\SessionObject;
use App\Engine\ServerObject;
use App\Engine\Header;
use App\Engine\Printer;


class CommentController extends MainController
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

    // Confirme la modification du post

    public function addComment()
    {

        $server = new ServerObject();
        
        $postId = filter_input(INPUT_POST, 'postid');
        $userId = filter_input(INPUT_POST, 'userid');
        $comment = filter_input(INPUT_POST, 'commentaire');

        $add = $this->CommentModel->addComment($comment, $postId, $userId);

        if ($add == true){        
            $this->Header->set('Location: ' . $server->vars['HTTP_REFERER']);         
        }else{
            $this->Printer->set('Erreur. Redirection dans 3 secondes...');
            $this->Header->set('refresh:3;url=' . $server->vars['HTTP_REFERER']);   
        }

    }

    // Confirme la validation d'un commentaire

    public function validateComment($request)
    {

        $session = new SessionObject();

        if ($session->vars['type'] == 2){
        $this->CommentModel->updateCommentStatus(1, $request['id']);
        }
   
        $this->Header->set('Location: /OCR-P5-Blog/blog');     

    }

    // Supprime un commentaire

    public function removeComment($request)
    {

        $session = new SessionObject();

        if ($session->vars['type'] == 2){
        $this->CommentModel->deleteComment($request['id']);
        }
   
        $this->Header->set('Location: /OCR-P5-Blog/blog');   

    }

}