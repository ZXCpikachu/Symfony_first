<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException as Unique;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

#[AsController]
class ErrorController extends AbstractController
{
    public function show(Request $request, SessionInterface $session): Response
    {
        $exception = $request->attributes->get('exception');
        $path = $request->getPathInfo();  // переименовано в $path для ясности
        if ($exception instanceof Unique) {
            // Убираем создание события, если оно не используется
            $data = $request->request->get('user') ?? [];
            $session->set('userdata', $data);
            $login = $data['login'] ?? null;
            if ($login !== null) {
                $this->addFlash('unique_login', 'логин ' . $login . ' занят');
            }
            return $this->redirect($path);
        }
        return new Response('Неизвестная ошибка');
    }
}
