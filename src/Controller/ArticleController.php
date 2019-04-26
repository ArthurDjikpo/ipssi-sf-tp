<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\Comment;
use App\Entity\User;
use App\Form\ArticleCommentType;
use App\Form\ArticleType;
use App\Repository\ArticleRepository;
use App\Repository\CommentRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ArticleController extends AbstractController
{
    public function index(): Response
    {
        $doctrine = $this->getDoctrine();
        /** @var ArticleRepository $articleRepository */
        $articleRepository = $doctrine->getRepository(Article::class);

        $articles = $articleRepository->getAllArticles();

        return $this->render('article/index.html.twig', [
            'articles' => $articles,
        ]);
    }

    public function new(Request $request): Response
    {
        $article = new Article();
        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $article->setCreated(new \DateTime());
            $article->setAuthor($this->getUser());
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($article);
            $entityManager->flush();

            return $this->redirectToRoute('index');
        }

        return $this->render('article/new.html.twig', [
            'article' => $article,
            'form' => $form->createView(),
            'formname' => 'Nouvel article',
        ]);
    }

    /**
     * @param Article $article
     * @param Request $request
     * @return Response
     */
    public function show(Article $article, Request $request): Response
    {

        $form = $this->createForm(ArticleCommentType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var Comment $comment */
            $comment = $form->getData();
            $comment->setAuthor($this->getUser());
            $comment->setCreated(new \DateTime());
            $comment->setIsCensored(false);
            $comment->setArticle($article);
            $article_id = $article->getId();

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($comment);

            $entityManager->flush();

            return $this->redirectToRoute('article', [
                'id' => $article_id,
            ]);
        }

        $article_id = $article->getId();

        $entityManager = $this->getDoctrine()->getManager();
        /** @var CommentRepository $commentRepository */
        $commentRepository = $entityManager->getRepository(Comment::class);
        $comments = $commentRepository->getAllUncensoredComments($article_id);

        if (!empty($this->getUser())) {
            return $this->render('article/show.html.twig', [
                'article' => $article,
                'comments' => $comments,
                'ArticleCommentForm' => $form->createView()
            ]);
        } else {
            return $this->render('article/show.html.twig', [
                'article' => $article,
                'comments' => $comments,
            ]);
        }
    }

    public function edit(Request $request, Article $article): Response
    {
        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('article', [
                'id' => $article->getId(),
            ]);
        }

        return $this->render('article/edit.html.twig', [
            'article' => $article,
            'form' => $form->createView(),
            'formname' => 'Edition d\'article',
        ]);
    }

    public function delete(Request $request, Article $article): Response
    {
        /** @var User $user */
        $user = $this->getUser();
        if ($this->isCsrfTokenValid('delete' . $article->getId(), $request->request->get('_token'))
            && in_array('ROLE_ADMIN', $user->getRoles())) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($article);
            $entityManager->flush();
        }

        return $this->redirectToRoute('index');
    }
}
