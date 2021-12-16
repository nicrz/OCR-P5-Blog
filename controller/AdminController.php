<?php

namespace App\Controller;

use App\Model\UserModel;
use App\Engine\SessionObject;
use App\Engine\ServerObject;
use App\Engine\Header;
use App\Engine\Printer;


class AdminController extends MainController
{

    private $UserModel;
    private $Header;
    private $Printer;

    public function __construct()
    {
        parent::__construct();

        $this->UserModel = new UserModel();
        $this->Header = new Header();
        $this->Printer = new Printer();

    }

    // Retourne la liste de tous les utilisateurs présents dans la base de données

    public function usersList()
    {

        $session = new SessionObject();


        if ($session->vars['type'] == 2){
            $users = $this->UserModel->getUsers();
            $this->twig->display('users_list.html.twig', ['users' => $users]);
        }else{
            $this->Header->set('Location: /OCR-P5-Blog');     
        }

    }

    // Charge un formulaire avec les infos d'un utilisateur

    public function userEdit($request)
    {

        $session = new SessionObject();
        if ($session->vars['type'] == 2){
            $user = $this->UserModel->getUserById($request['id']);
            $this->twig->display('user_edit.html.twig', ['user' => $user]);
        }else{
            $this->Header->set('Location: /OCR-P5-Blog');
        }

    }

    // Execute les modifications apportées à un utilisateur

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
        $this->UserModel->editUser($userid, $nom, $prenom, $identifiant, $email, $actif, $type);
        }
        
        $this->Printer->set('Utilisateur modifié, redirection...');
        $this->Header->set('Location: ' . $server->vars['HTTP_REFERER']);
    }


}