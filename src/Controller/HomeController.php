<?php
declare(strict_types=1);

namespace App\Controller;


use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController{


    public function welcome() : Response
    {
        return $this->render(
            'home/home.html.twig', [
                'title' => 'Salut',
            ]
        );
    }

    public function bet(): Response {

        return $this->render(
            'connexion/connexion.html.twig');

    }
}