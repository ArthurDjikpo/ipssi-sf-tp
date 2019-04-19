<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserRegistrationType;
use Swift_Mailer;
use Swift_Message;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Csrf\TokenGenerator\TokenGeneratorInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{

    public function login(AuthenticationUtils $authenticationUtils): Response
    {

        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/loginForm.html.twig', [
            'title' => 'Bet Rocket | Login',
            'last_username' => $lastUsername,
            'error' => $error,
        ]);
    }

    public function register(Request $request, UserPasswordEncoderInterface $encoder, Swift_Mailer $mailer, TokenGeneratorInterface $tokenGenerator): Response

    {
        /** @var User $user */
        $form = $this->createForm(UserRegistrationType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {


            $token = $tokenGenerator->generateToken();

            $userData = $form->getData();
            $userData->setRoles(['ROLE_USER']);
            $userData->setCertifiedCode($token);
            $userData->setPassword($encoder->encodePassword($user, $user->getPassword()));

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($userData);

            $entityManager->flush();

            // Mail part
            $message = (new Swift_Message('Validate your account'));
            $message->setFrom('contact@betrocket.com');
            $message->setTo($user->getEmail());
            $message->setBody(
                $this->renderView(

                    'email/registrationValidator.html.twig', [
                        'nickname' => $user->getNickname(),
                        'certification' => $token,
                        'randomString' => $token

                    ]
                ),
                'text/html'
            );

            $mailer->send($message);


            return $this->redirectToRoute('blog');

        }

        return $this->render('security/registerForm.html.twig', [
            'UserRegistrationForm' => $form->createView()
        ]);

    }

    public function confirm(Request $request): Response
    {
        $certification = $request->attributes->get('certification');
        $form = $this->createForm(UserRegistrationType::class);
        $entityManager = $this->getDoctrine()->getManager();
        $userRepository = $entityManager->getRepository(User::class);
        $user = $userRepository->findOneBy(['certifiedCode' => $certification]);

        if (!empty($user)) {
            /** @var User $user */
            $user->setIsCertified(true);
            $entityManager->persist($user);
            $entityManager->flush();

            return $this->render('security/confirm.html.twig', array(
                'UserRegistrationForm' => $form->createView(),
                'exist' => true
            ));
        }

        return $this->render('security/confirm.html.twig', array(
            'UserRegistrationForm' => $form->createView(),
            'exist' => false
        ));

    }

    public function passwordForgotten(Request $request, UserPasswordEncoderInterface $encoder, Swift_Mailer $mailer, TokenGeneratorInterface $tokenGenerator): Response
    {

        if ($request->isMethod('POST')) {
            $email = $request->request->get('email');

            $entityManager = $this->getDoctrine()->getManager();

            /* @var $user User */
            $user = $entityManager->getRepository(User::class)->findOneBy(['email' => $email]);


            if ($user === null) {
                $this->addFlash('danger', 'Email Inconnu');
                //dd('nope');
                return $this->render('security/passwordForgotten.html.twig', [
                    'alert' => true,
                    'alerttype' => 'danger',
                    'alerttitle' => 'Erreur',
                    'alertmsg' => 'Cet e-mail n\'existe pas.',
                ]);
            }

            $token = $tokenGenerator->generateToken();

            try {
                $user->setResetToken($token);
                $entityManager->flush();
            } catch (\Exception $e) {
                $this->addFlash('warning', $e->getMessage()); // Demander prof
                return $this->render('security/passwordForgotten.html.twig', [
                    'alert' => true,
                    'alerttype' => 'danger',
                    'alerttitle' => 'Erreur',
                    'alertmsg' => 'Une erreur est survenue...',
                ]);
            }

            $url = $this->generateUrl('reset', array('token' => $token), UrlGeneratorInterface::ABSOLUTE_URL);

            $message = new Swift_Message('Mot de passe oublié');
            $message->setFrom('contact@betrocket.com');
            $message->setTo($user->getEmail());
            $message->setBody(
                $this->renderView(
                    'email/passwordForgotten.html.twig', [
                        'nickname' => $user->getNickname(),
                        'url' => $url,
                    ]
                ),
                'text/html'
            );

            $mailer->send($message);

            $this->addFlash('notice', 'Mail envoyé'); // ???

            //return $this->redirectToRoute('blog');
            return $this->redirectToRoute('password');

        }

        return $this->render('security/passwordForgotten.html.twig');

    }

    public function resetPassword(Request $request, string $token, UserPasswordEncoderInterface $passwordEncoder): Response
    {

        if ($request->isMethod('POST')) {

            $entityManager = $this->getDoctrine()->getManager();

            $user = $entityManager->getRepository(User::class)->findOneBy(['resetToken' => $token]);

            /* @var $user User */
            if ($user === null) {
                $this->addFlash('danger', 'Token Inconnu');
                //return $this->redirectToRoute('blog');
                return $this->redirectToRoute('login');
            }

            $user->setResetToken(null);

            $user->setPassword($passwordEncoder->encodePassword($user, $request->request->get('password')));

            $entityManager->flush();

            $this->addFlash('notice', 'Mot de passe mis à jour'); // ???

            //return $this->redirectToRoute('blog');
            return $this->redirectToRoute('login');

        } else {

            return $this->render('security/passwordReset.html.twig', [
                'token' => $token
            ]);

        }

    }


}
