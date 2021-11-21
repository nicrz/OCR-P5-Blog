<?php

namespace App\Controller;

use App\Model\UserManager;


class AdminController extends MainController
{

    private $UserManager;

    public function __construct()
    {
        parent::__construct();

        $this->UserManager = new UserManager();

    }

    public function usersList()
    {
        if ($_SESSION['type'] == 2){
            $users = $this->UserManager->getUsers();
            $this->twig->display('users_list.html.twig', ['users' => $users]);
        }else{
            header('Location: /OCR-P5-Blog');
        }

    }

    public function userEdit($request)
    {
        if ($_SESSION['type'] == 2){
            $user = $this->UserManager->getUserById($request['id']);
            $this->twig->display('user_edit.html.twig', ['user' => $user]);
        }else{
            header('Location: /OCR-P5-Blog');
        }

    }

    public function userEditConfirm()
    {

        if ($_SESSION['type'] == 2){
        $userid = $_POST['userid'];  
        $nom = $_POST['nom'];
        $prenom = $_POST['prenom'];
        $identifiant = $_POST['identifiant'];   
        $email = $_POST['email'];  
        $actif = $_POST['actif'];    
        $type = $_POST['type'];    
        $edit = $this->UserManager->editUser($userid, $nom, $prenom, $identifiant, $email, $actif, $type);
        }
   
        header('Location: ' . $_SERVER['HTTP_REFERER']);         

    }


}