<?php

namespace App\Controller;

use AltoRouter;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
use App\Engine\Header;
use App\Engine\Printer;



class HomeController extends MainController
{

    private $Header;
    private $Printer;

    public function __construct()
    {
        parent::__construct();

        $this->Header = new Header();
        $this->Printer = new Printer();

    }

    public function home()
    {
        
        $this->twig->display('home.html.twig');
    }

    public function emailSending()
    {

        try {
            //Server settings
            $phpmailer = new PHPMailer();
            $phpmailer->isSMTP();
            $phpmailer->Host = 'smtp.mailtrap.io';
            $phpmailer->SMTPAuth = true;
            $phpmailer->Port = 2525;
            $phpmailer->Username = '01cc50757f2fca';
            $phpmailer->Password = 'ef6c4351cfe845';                                 
        
            //Recipients
            $phpmailer->setFrom(filter_input(INPUT_POST, 'email'), filter_input(INPUT_POST, 'nom') . filter_input(INPUT_POST, 'prenom'));
            $phpmailer->addAddress('ruiz.nico64@gmail.com', 'Nicolas Ruiz');     //Add a recipient
        
            //Content
            $phpmailer->isHTML(true);                                  //Set email format to HTML
            $phpmailer->Subject = 'Mail de contact blog';
            $phpmailer->Body    = filter_input(INPUT_POST, 'message');
        
            $phpmailer->send();
            $this->Printer->set('Message envoyé');
            $this->Header->set('Location: home');
        } catch (Exception $e) {
            $this->Printer->set('Le message n a pas pu être envoyé');
            $this->Header->set('refresh:3;url=home');
        }
    

    }



    public function notFound()
    {
        $this->twig->display('not_found.html.twig', ['message' => 'Erreur 404']);
    }


}