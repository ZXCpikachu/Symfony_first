<?php

namespace App\Controller;
use App\Entity\Category;
use App\Form\CategoryType;
use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use function Symfony\Component\VarDumper\Dumper\esc;

#[IsGranted('ROLE_ADMIN')]
#[Route('/category')]
class CategoryController extends AbstractController
{
    #[Route('/',name: 'app_category_index',methods: ['GET'])]
    public function index(CategoryRepository $categoryRepository):Response
    {
        return $this->render('category/index.html.twig',[
            'categories' => $categoryRepository->findAll()
        ]);
    }
    #[Route('/new',name: 'app_category_new',methods: ['GET','POST'])]
    public function new(Request $request,EntityManagerInterface $entityManager):Response
    {
        $category = new Category();
        $form = $this->createForm(CategoryType::class,$category);

        if (null === $request->request->get('cancel')){
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()){
                $entityManager->persist($category);
                $entityManager->flush();
                return $this->redirectToRoute('app_category_index',[],Response::HTTP_SEE_OTHER);
            }
        } else {
            return $this->redirectToRoute('app_category_index',[],Response::HTTP_SEE_OTHER);
        }
        return $this->render('category/new.html.twig',[
            'category' => $category,
            'form' => $form
        ]);
    }
    #[Route('/{id}',name: 'app_category_show',methods: ['GET'])]
    public function show (Category $category): Response
    {
        return $this->render('category/show.html.twig',[
           'category' => $category
        ]);
    }
    #[Route('/{id}/edit', name: 'app_category_edit',methods: ['GET','POST'])]
    public function edit(Request $request,EntityManagerInterface $entityManager,Category $category): Response
    {
        $form = $this->createForm(CategoryType::class,$category);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            $entityManager->flush();
            return $this->redirectToRoute('app_category_index',[],Response::HTTP_SEE_OTHER);
        }
        return $this->render('category/edit.html.twig',[
            'category' => $category,
            'form' => $form,
        ]);
    }
    #[Route('/{id}',name: 'app_category_delete',methods: ['POST'])]
    public function delete(Request $request,EntityManagerInterface $entityManager,Category $category): Response
    {
        if ($category->getArticles()->first()){
            $message = 'Ошибка: категория содержится в статье. Удалите статью или '
                . 'назначьте ей другую категорию перед удалением этой категории.';
            $this->addFlash('has_article', $message);
            return $this->redirectToRoute('app_article_index');
        }
        if ($this->isCsrfTokenValid('delete'.$category->getId(),$request->request->get('_token'))){
            $entityManager->remove($category);
            $entityManager->flush();
        }
        return $this->redirectToRoute('app_category_index',[],Response::HTTP_SEE_OTHER);
    }
}