<?php

namespace App\Controller;

use App\Model\UserModel;
use App\Engine\Session;
use App\Engine\SessionObject;


class LoginController extends MainController
{
    private $UserModel;

    public function __construct()
    {
        parent::__construct();

        $this->UserModel = new UserModel();

    }

    // Affiche la page d'identification

    public function loginPage()
    {

        $this->twig->display('login.html.twig');
    }

    // Vérifie si les identifiants rentrés sont bons pour permettre à l'utilisateur de lancer une session

    public function checkLogin()
    {
        $emailSended = filter_input(INPUT_POST, 'email');
        $passwordSended = filter_input(INPUT_POST, 'pwd');

        $userChecked = $this->UserModel->login($emailSended, $passwordSended);

        if ($userChecked != false){
            foreach ($userChecked as $key => $value){
                //session_start();
                Session::set($key, $value);
                header('Location: blog');
            }
        }else{
            print_r('Identifiant ou mot de passe incorrect. Redirection vers la page de connexion...');
            header('refresh:3;url=login');
        }


    }

    // Affiche la page d'inscription

    public function registerPage()
    {

        $this->twig->display('register.html.twig');
    }

    // Execute l'enregistrement d'un utilisateur avec les informations entrées

    public function checkRegister()
    {
        $nom = filter_input(INPUT_POST, 'nom');
        $prenom = filter_input(INPUT_POST, 'prenom');
        $identifiant = filter_input(INPUT_POST, 'identifiant');
        $email = filter_input(INPUT_POST, 'email');
        $motdepasse = filter_input(INPUT_POST, 'motdepasse');
        $motdepasseconf = filter_input(INPUT_POST, 'motdepasseconf');

        $emailCheck = $this->UserModel->checkEmailExistence($email);
        $idCheck = $this->UserModel->checkIdExistence($identifiant);

        if ($motdepasse == $motdepasseconf){
            $hashmotdepasse = password_hash($motdepasse, PASSWORD_ARGON2I);
            $passwordCheck = true;
            
        }else{
            print_r('Le mot de passe de confirmation est différent du mot de passe.');
            header('refresh:3;url=register');
        }

        if ($emailCheck == true){
            print_r('Cet e-mail est déjà utilisé.');
            header('refresh:3;url=register');
        }

        if ($idCheck == true){
            print_r('Cet identifiant est déjà utilisé.');
            header('refresh:3;url=register');
        }

        if ((!empty($passwordCheck) && $passwordCheck == true) && empty($emailCheck) && empty($idCheck)){
            $add = $this->UserModel->addUser($nom, $prenom, $identifiant, $email, $hashmotdepasse);
            header('Location: login');
        }


    }

    // Déconnecte un utilisateur et redirige vers la page d'accueil

    public function logout()
    {

        session_destroy();
        header('Location: home');

    }

}