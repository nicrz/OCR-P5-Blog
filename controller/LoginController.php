<?php

namespace App\Controller;

use App\Model\UserManager;
use App\Engine\Session;


class LoginController extends MainController
{
    private $UserManager;

    public function __construct()
    {
        parent::__construct();

        $this->UserManager = new UserManager();

    }

    public function loginPage()
    {

        $this->twig->display('login.html.twig');
    }

    public function checkLogin()
    {
        $emailSended = $_POST['email'];
        $passwordSended = $_POST['pwd'];

        $userChecked = $this->UserManager->login($emailSended, $passwordSended);

        if ($userChecked != false){
            foreach ($userChecked as $key => $value){
                session_start();
                Session::set($key, $value);
                header('Location: blog');
            }
        }else{
            echo 'Identifiant ou mot de passe incorrect. Redirection vers la page de connexion...';
            header('refresh:3;url=login');
        }


    }

    public function registerPage()
    {

        $this->twig->display('register.html.twig');
    }

    public function checkRegister()
    {
        $nom = $_POST['nom'];
        $prenom = $_POST['prenom'];
        $identifiant = $_POST['identifiant'];
        $email = $_POST['email'];
        $motdepasse = $_POST['motdepasse'];
        $motdepasseconf = $_POST['motdepasseconf'];

        $emailCheck = $this->UserManager->checkEmailExistence($email);
        $idCheck = $this->UserManager->checkIdExistence($identifiant);

        if ($motdepasse == $motdepasseconf){
            $hashmotdepasse = password_hash($motdepasse, PASSWORD_ARGON2I);
            $passwordCheck = true;
        }else{
            echo 'Le mot de passe de confirmation est différent du mot de passe.';
            header('refresh:3;url=register');
        }

        if ($emailCheck == true){
            echo 'Cet e-mail est déjà utilisé.';
            header('refresh:3;url=register');
        }

        if ($idCheck == true){
            echo 'Cet identifiant est déjà utilisé.';
            header('refresh:3;url=register');
        }

        if ((!empty($passwordCheck) && $passwordCheck == true) && (!empty($emailCheck) && $emailCheck == false) && (!empty($idCheck) && $idCheck == false)){
            $add = $this->UserManager->addUser($nom, $prenom, $identifiant, $email, $hashmotdepasse);
            header('Location: login');
        }


    }

    public function logout()
    {

        session_destroy();
        header('Location: home');

    }

}