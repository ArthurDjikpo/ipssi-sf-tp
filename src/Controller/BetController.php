<?php


namespace App\Controller;

use App\Form\BetType;
use App\Repository\BetRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormTypeInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

class BetController extends AbstractController
{
    public function addMyBet(Request $request): Response
    {

        $isOk = false;
        $newBetForm = $this->createForm(BetType::class);
        $newBetForm->handleRequest($request);

        if ($newBetForm->isSubmitted() && $newBetForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($newBetForm->getData());
            $em->flush();
            $isOk = true;
        }
        return $this->render('bet/bet.html.twig', [
            'BetForm' => $newBetForm->createView(),
            'isOk' => $isOk,
        ]);
    }
}
