<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class MailController extends AbstractController
{

    private $mailer;


    public function __construct(\Swift_Mailer $mailer)
    {
        $this->mailer = $mailer;
    }

    public function testMail(): Response
    {
        $mail= new \Swift_Message();

        $mail->setFrom('test@test.fr');
        $mail->setTo('tim@test.fr');
        $mail->setSubject('Hello you');

        $mail->setBody($this->render('mail/test.txt.twig'), 'text/html');

        $this->mailer->send($mail);

        return new Response('test');
    }
}
