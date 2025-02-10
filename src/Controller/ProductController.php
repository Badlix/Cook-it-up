<?php

namespace App\Controller;

use App\Entity\Product;
use App\Form\Type\ProductType;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class ProductController extends AbstractController
{
    #[Route('/product', name: 'product')]
    public function index(Request $request, EntityManagerInterface $productRepository): Response
    {
        $product = new Product();
        $form = $this->createForm(ProductType::class, $product);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $product = $form->getData();
            $productRepository->persist($product);
            $productRepository->flush();

            return $this->redirectToRoute('products');
        }

        return $this->render('product/new.html.twig', [
            'controller_name' => 'ProductController',
            'form' => $form,
        ]);
    }

    #[Route('/products', name: 'products')]
    public function getProductsData(ProductRepository $productRepository): Response
    {
        $result = $productRepository->getAllProducts();

        return $this->render('product/show.html.twig', [
            'products' => $result,
        ]);
    }

    #[Route('/ingredients', name: 'ingredients', methods: ['GET'])]
    public function getAllIngredients(ProductRepository $productRepository): JsonResponse {
        $ingredientsNames = [];
        foreach ($productRepository->getAllProducts() as $item) {
            $ingredientsNames[] = $item->getName();
        }
        return new JsonResponse($ingredientsNames);
    }
}
