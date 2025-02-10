<?php

namespace App\Controller;
use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
//#[IsGranted('ROLE_ADMIN')]
#[Route('/user')]
class UserController extends AbstractController
{
    #[Route('/', name:'app_user_index', methods: ['GET'])]
    public function index (UserRepository $userRepository) :Response
    {
        return $this->render('/user/index.html.twig',[
            'users' => $userRepository->findAll(),
        ]);
    }
    #[Route('/new', name: 'app_user_new', methods: ['GET', 'POST'])]
    public function new (EntityManagerInterface $entityManager, Request $request, UserPasswordHasherInterface $passwordHasher) :Response
    {
        $user = new User();
        $form = $this->createForm(UserType::class,$user);
        if (null === $request->request->get('cancel')){
            $form->handleRequest($request);
        }else {
            return  $this->redirectToRoute('app_user_index',[],Response::HTTP_SEE_OTHER);
        }
        if ($form->isSubmitted() && $form->isValid()){
            $this->passwordHashing(true,$user,$passwordHasher);
            $entityManager->persist($user);
            $entityManager->flush();
            return $this->redirectToRoute('app_user_index',[],Response::HTTP_SEE_OTHER);
        }
        return $this->render('/user/new.html.twig',[
            'user' => $user,
            'form' => $form,
        ]);
    }
    #[Route('/{id}',name: 'app_user_show',methods: ['GET'])]
    public function show(User $user): Response
    {
       return $this->render('user/show.html.twig',[
            'user' => $user,
        ]);
    }
    #[Route('/{id}/edit',name:'app_user_edit',methods: ['GET','POST'])]
    public function edit(Request $request,EntityManagerInterface $entityManager,User $user): Response
    {
        $form = $this->createForm(UserType::class, $user,['required'=>false]);
        if (null === $request->request->get('cancel')){
            $form->handleRequest($request);
        }else {
            return  $this->redirectToRoute('app_user_index',[],Response::HTTP_SEE_OTHER);
        }
        if ($form->isSubmitted() && $form->isValid()){
            $entityManager->flush();
            $this->addFlash('user_success','Изменения сохранены');
            return $this->json("Успешная обработка запроса");
        }
        return $this->render('user/edit.html.twig',[
            'user' => $user,
            'form' => $form,
        ]);
    }
    #[Route('/{id}', name: 'app_user_delete', methods: ['POST'])]
    public function delete (Request $request, User $user, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$user->getId(), $request->request->get('_token'))){
            $entityManager->remove($user);
            $entityManager->flush();
        }
        return $this->redirectToRoute('app_user_index',[],Response::HTTP_SEE_OTHER);
    }
    private function passwordHashing($field,$user,$passwordHasher) : void
    {
        if ($field !== ''){
            $textPassword = $user->getPassword();
            $hashedPassword = $passwordHasher->hashPassword($user,$textPassword);
            $user->setPassword($hashedPassword);
        }
    }
}