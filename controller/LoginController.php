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
                //session_start();
                Session::set($key, $value);
                header('Location: blog');
            }
        }else{
            echo 'Identifiant ou mot de passe incorrect. Redirection vers la page de connexion...';
            header('refresh:3;url=login');
        }


    }

    public function logout()
    {

        session_destroy();
        header('Location: home');

    }

}