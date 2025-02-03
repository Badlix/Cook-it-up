<?php

namespace App\Controller;

use App\Entity\Product;
use App\Entity\Recipe;
use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class RecipeController extends AbstractController
{

    #[Route('/recipe', name: 'app_recipe')]
    public function index(): Response
    {
        return $this->render('recipe/index.html.twig', [
            'controller_name' => 'RecipeController',
        ]);
    }

   #[Route('/createRecipe', name: 'app_create_recipe', methods: ['POST'])]
    public function createRecipe(Request $request, ProductRepository $productRepository): Response
    {
        $data = json_decode($request->getContent(), true);
        $name = $data['title'];
        $duration = $data['duration'];
        $ingredients = $data['ingredients'];

        $recipe = new Recipe();
        $recipe->setName($name);
        $recipe->setDuration($duration);



        foreach ($ingredients as $ingredientRecipe) {
            $ingredient = new Product();
            $ingredient->setName($ingredientRecipe['name']);
            $ingredient->setPrice(rand(1,10));
            $ingredient->setDescription("This is a description");
            $ingredient->setQuantity(1);

            $recipe->addIngredient($ingredient);
        }

    $productRepository->persist($recipe);
    $productRepository->flush();

    return $this->redirectToRoute('success', ['productName' => $recipe->getName()]);
    }
}
