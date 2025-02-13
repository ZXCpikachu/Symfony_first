<?php

namespace App\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class LoginController extends AbstractController
{
    #[Route('/login', name: 'app_login')]
    public function index(AuthenticationUtils $authenticationUtils): Response
    {	print_r($_POST);
        $access_denied = false;
        if ($this->isGranted("ROLE_ADMIN")) {
            return $this->redirectToRoute('app_article_index');
        } else if ($this->isGranted('ROLE_USER')) {
            $access_denied = 'Недействительные аутентификационные данные.';
        }
        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();
        return $this->render('login/index.html.twig', [
            'last_username' => $lastUsername,
            'error' => $error,
            'access_denied' => $access_denied
        ]);
    }
    #[Route('/login_check', name: 'app_login_check', methods: ['POST'])]
    public function loginCheck(): void
    {
        throw new \Exception('Этот маршрут должен перехватываться механизмом безопасности.');
    }
    #[Route('/logout', name: 'app_logout')]
    public function logout() : Response
    {
        throw new \LogicException('This method can be blank');
    }

}