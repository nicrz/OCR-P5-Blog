<?php

namespace App\Controller;

use App\Model\UserModel;
use App\Engine\SessionObject;
use App\Engine\ServerObject;


class AdminController extends MainController
{

    private $UserModel;

    public function __construct()
    {
        parent::__construct();

        $this->UserModel = new UserModel();

    }

    public function usersList()
    {

        $session = new SessionObject();


        if ($session->vars['type'] == 2){
            $users = $this->UserModel->getUsers();
            $this->twig->display('users_list.html.twig', ['users' => $users]);
        }else{
            header('Location: /OCR-P5-Blog');
        }

    }

    public function userEdit($request)
    {

        $session = new SessionObject();
        if ($session->vars['type'] == 2){
            $user = $this->UserModel->getUserById($request['id']);
            $this->twig->display('user_edit.html.twig', ['user' => $user]);
        }else{
            header('Location: /OCR-P5-Blog');
        }

    }

    public function userEditConfirm()
    {

        $session = new SessionObject();
        $server = new ServerObject();

        if ($session->vars['type'] == 2){
        $userid = filter_input(INPUT_POST, 'userid');  
        $nom = filter_input(INPUT_POST, 'nom');
        $prenom = filter_input(INPUT_POST, 'prenom');
        $identifiant = filter_input(INPUT_POST, 'identifiant');   
        $email = filter_input(INPUT_POST, 'email');  
        $actif = filter_input(INPUT_POST, 'actif');    
        $type = filter_input(INPUT_POST, 'type');    
        $edit = $this->UserModel->editUser($userid, $nom, $prenom, $identifiant, $email, $actif, $type);
        }
   
        header('Location: ' . $server->vars['HTTP_REFERER']);         

    }


}