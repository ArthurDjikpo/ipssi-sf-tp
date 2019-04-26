<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\User;
use App\Repository\ArticleRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class UserController extends AbstractController
{

    public function index()
    {
        return $this->render('user/index.html.twig', [
            'controller_name' => 'UserController',
        ]);
    }

    public function userarticles(User $user): Response
    {

        $doctrine = $this->getDoctrine();
        /** @var ArticleRepository $articleRepository */
        $articleRepository = $doctrine->getRepository(Article::class);

        $articles = $articleRepository->getAllArticlesOfUser($user->getId());

        return $this->render('user/articles.html.twig', [
            'user' => $user,
            'articles' => $articles,
        ]);
    }

    public function profile(User $user): Response
    {

        $doctrine = $this->getDoctrine();
        $userRepository = $doctrine->getRepository(User::class);

        /** @var User $user */
        $user = $userRepository->findOneBy(['id' => $user->getId()]);

        return $this->render('user/profile.html.twig', [
            'user' => $user,
        ]);
    }
}
