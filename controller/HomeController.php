<?php

namespace App\Controller;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;


class HomeController extends MainController
{

    public function __construct()
    {
        parent::__construct();

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
            $phpmailer->setFrom($_POST['email'], $_POST['nom'] . $_POST['prenom']);
            $phpmailer->addAddress('ruiz.nico64@gmail.com', 'Nicolas Ruiz');     //Add a recipient
        
            //Content
            $phpmailer->isHTML(true);                                  //Set email format to HTML
            $phpmailer->Subject = 'Mail de contact blog';
            $phpmailer->Body    = filter_input(INPUT_POST, 'message');
        
            $phpmailer->send();
            print_r('Message has been sent');
            header('Location: home');
        } catch (Exception $e) {
            print_r("Message could not be sent. Mailer Error: {$phpmailer->ErrorInfo}");
            header('refresh:3;url=home');
        }
    

    }



    public function notFound()
    {
        $this->twig->display('not_found.html.twig', ['message' => 'testzer']);
    }


}