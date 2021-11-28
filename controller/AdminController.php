<?php

namespace App\Controller;

use App\Model\UserModel;


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
        if ($_SESSION['type'] == 2){
            $users = $this->UserModel->getUsers();
            $this->twig->display('users_list.html.twig', ['users' => $users]);
        }else{
            header('Location: /OCR-P5-Blog');
        }

    }

    public function userEdit($request)
    {
        if ($_SESSION['type'] == 2){
            $user = $this->UserModel->getUserById($request['id']);
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
        $edit = $this->UserModel->editUser($userid, $nom, $prenom, $identifiant, $email, $actif, $type);
        }
   
        header('Location: ' . $_SERVER['HTTP_REFERER']);         

    }


}