<?php

namespace App\Controller;

use App\Model\UserModel;
use App\Engine\Session;
use App\Engine\SessionObject;
use App\Engine\Header;
use App\Engine\Printer;


class LoginController extends MainController
{
    private $UserModel;
    private $Header;

    public function __construct()
    {
        parent::__construct();

        $this->UserModel = new UserModel();
        $this->Header = new Header();
        $this->Printer = new Printer();

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

        if (!empty($emailSended) && !empty($passwordSended)){
            $userChecked = $this->UserModel->login($emailSended, $passwordSended);
        }else{
            $this->Printer->set('Tous les champs doivent être renseignés.');
            $this->Header->set('refresh:3;url=login');
        }       

        if ($userChecked != false){
            foreach ($userChecked as $key => $value){
                //session_start();
                Session::set($key, $value);
                $this->Header->set('Location: blog');
            }
        }else{
            $this->Printer->set('Identifiant ou mot de passe incorrect. Redirection vers la page de connexion...');
            $this->Header->set('refresh:3;url=login');
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
            $this->Printer->set('Le mot de passe de confirmation est différent du mot de passe.');
            $this->Header->set('refresh:3;url=register');
        }

        if ($emailCheck == true){
            $this->Printer->set('Cet e-mail est déjà utilisé.');
            $this->Header->set('refresh:3;url=register');
        }

        if ($idCheck == true){
            $this->Printer->set('Cet identifiant est déjà utilisé.');
            $this->Header->set('refresh:3;url=register');
        }

        // Verification que tous les champs sont remplis

        if (empty($nom) || empty($prenom) || empty($identifiant) || empty($email) || empty($motdepasse) || empty($motdepasseconf)){
            $this->Printer->set('Tous les champs ne sont pas remplis');
            $this->Header->set('refresh:3;url=register');
            
        }else{
        
            if ($passwordCheck == true && $emailCheck == false && $idCheck == false){
                $this->UserModel->addUser($nom, $prenom, $identifiant, $email, $hashmotdepasse);
                $this->Printer->set('Inscription réussie, redirection vers la page de connexion...');
                $this->Header->set('refresh:3;url=login');   
            }
        }




    }

    // Déconnecte un utilisateur et redirige vers la page d'accueil

    public function logout()
    {

        session_destroy();
        $this->Header->set('Location: home');

    }

}