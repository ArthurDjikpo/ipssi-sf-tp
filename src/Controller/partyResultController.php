<?php


namespace App\Controller;


use App\Repository\BetRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class partyResultController extends AbstractController
{

    public function getMyBet(){

       /* $doctrine = $this->getDoctrine();

        $betRepository= $doctrine->getRepositority(BetRepository::class);

        $playerBet= $betRepository->getPlayerBet();*/

        return $this->render('playerResult/playerResult.html.twig'

            //,['playerBet'=> $playerBet ]
        );



    }

    public function startGame(){

        return $this->render('partyResult/partyResult.html.twig');
    }
}

