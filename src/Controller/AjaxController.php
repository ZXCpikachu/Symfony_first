<?php

namespace App\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\Article;
use App\Repository\ArticleRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AjaxController extends AbstractController
{
    #[Route('/get/{id}', name: 'app_ajax_get',methods: ['GET'])]
    public function showByGet(Article $article): Response
    {
        return $this->json($article->getContent());
    }
    #[Route('/post', name: 'app_ajax_post',methods: ['POST'])]
    public function showByPost(ArticleRepository $articleRepository, Request $request) : Response
    {
            $id = $request->request->get('id');
            $content = $articleRepository->find($id)->getContent();
            return $this->json($content);
    }
}