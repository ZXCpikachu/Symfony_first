<?php

namespace App\Controller;

use App\Entity\Article;
use App\Repository\ArticleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin')]
class AdminController extends AbstractController
{
//    #[Route('/', name: 'admin_dashboard')]
//    public function index(ArticleRepository $articleRepository): Response
//    {
//        return $this->render('admin/index.html.twig', [
//            'articles' => $articleRepository->findAll(),
//        ]);
//    }
//
//    #[Route('/article/{id}', name: 'admin_article_show', methods: ['GET'])]
//    public function show(Article $article): Response
//    {
//        return $this->render('admin/show.html.twig', [
//            'article' => $article,
//        ]);
//    }
//
//    #[Route('/archive/category/{id}', name: 'admin_article_category', methods: ['GET'])]
//    public function showByCategory(ArticleRepository $articleRepository, Request $request): Response
//    {
//        $categoryId = $request->attributes->get('id');
//        $articles = $articleRepository->findBy(['Category' => $categoryId]);
//        $category = count($articles) > 0 ? $articles[0]->getCategory() : null;
//
//        return $this->render('admin/archive.html.twig', [
//            'articles'    => $articles,
//            'pageHeading' => $category ?? 'Без категории',
//            'description' => $category ? $category->getDescription() : null,
//        ]);
//    }
//
//    #[Route('/archive/subcategory/{id}', name: 'admin_article_subcategory', methods: ['GET'])]
//    public function showBySubcategory(ArticleRepository $articleRepository, Request $request): Response
//    {
//        $subcategoryId = $request->attributes->get('id');
//        $articles = $articleRepository->findBy(['Subcategory' => $subcategoryId]);
//        $subcategory = count($articles) > 0 ? $articles[0]->getSubcategory() : null;
//
//        return $this->render('admin/archive.html.twig', [
//            'articles'    => $articles,
//            'pageHeading' => $subcategory ?? 'Без подкатегории',
//            'description' => $subcategory?->getDescription(),
//        ]);
//    }
//
//    #[Route('/archive', name: 'admin_archive')]
//    public function archive(ArticleRepository $articleRepository): Response
//    {
//        return $this->render('admin/archive.html.twig', [
//            'articles'    => $articleRepository->findAll(),
//            'pageHeading' => 'Архив статей',
//        ]);
//    }
}
