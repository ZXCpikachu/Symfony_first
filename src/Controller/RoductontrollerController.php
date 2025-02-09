<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use App\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;


final class RoductontrollerController extends AbstractController
{
    #[Route('/product', name: 'create_product')]
    public function createProduct(EntityManagerInterface $entityManager): Response
    {
        $product = new Product();
        $product->setName('Keyboard');
        $product->setPrice(1999);
        $product->setDescription('Ergonomic and stylish!');

        // сообщить Doctrine, что вы хотите (в итоге) сохранить Продукт (пока без запросов)
        $entityManager->persist($product);

        // действительно выполнить запросы (например, запрос INSERT)
        $entityManager->flush();

        return new Response('Saved new product with id '.$product->getId());
    }
}
