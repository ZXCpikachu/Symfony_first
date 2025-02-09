<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\Category;
use App\Repository\ArticleRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
class HomepageController extends AbstractController
{
     #[Route('/',name:'app_homepage')]
    public function index(ArticleRepository $articleRepository) : Response
    {
        return $this->render('homepage/index.html.twig',[
            'articles' => $articleRepository->findBy(['active' => true],null,100),
        ]);
    }
    #[Route('homepage/article/{id}', name:'app_homepage_article', methods: ['GET'])]
    public function show (Article $article):Response
    {
        return $this->render('homepage/show.html.twig',[
            'article' => $article,
        ]);
    }
    #[Route('homepage/archive/category/{id}', name: 'app_article_category', methods: ['GET'])]
    public function showByCategory(ArticleRepository $articleRepository, Request $request): Response
    {
        $categoryId = $request->attributes->get('id');
        $articles = $articleRepository->findBy(['Category' => $categoryId ? $categoryId : null]);
        $category = $articles[0]->getCategory();
        return $this->render('homepage/archive.html.twig', [
            'articles' => $articles,
            'pageHeading' => $category ?? 'Без категории',
            'description' => $category ? $category->getDescription() : null,
        ]);
    }
    #[Route('homepage/archive/subcategory/{id}', name: 'app_article_subcategory', methods: ['GET'])]
    public function showBySubcategory (ArticleRepository $articleRepository, Request $request): Response
    {
        $subcategoryId = $request->attributes->get('id');
        $articles = $articleRepository->findBy(['Subcategory' => $subcategoryId ? $subcategoryId : null]);
        $subcategory = $articles[0]->getSubcategory();
        return $this->render('homepage/archive.html.twig' , [
            'articles' => $articles,
            'pageHeading' => $subcategory ?? 'Без подкатегории',
            'description' => $subcategory?->getDescription(),
        ]);
    }
    #[Route('homepage/archive', name: 'app_homepage_archive')]
    public function archive (ArticleRepository $articleRepository):Response
    {
        return $this->render('homepage/archive.html.twig',[
            'articles' => $articleRepository->findAll(),
            'pageHeading' => 'Article archive',
        ]);
    }
}