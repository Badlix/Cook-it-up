<?php

namespace App\Controller;

use App\Entity\Product;
use App\Entity\Recipe;
use App\Repository\ProductRepository;
use App\Repository\RecipeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class RecipeController extends AbstractController
{

    #[Route('/recipe', name: 'app_recipe')]
    public function index(RecipeRepository $recipeRepository): Response
    {
        $lastRecipeGenerated = $recipeRepository->getLastRecipe();
        $lastRecipeGeneratedNames = array_map(function ($recipe) {
            return $recipe->getName();
        }, $lastRecipeGenerated);

        return $this->render('recipe/index.html.twig', [
            'controller_name' => 'RecipeController',
            'generated_recipes' => $lastRecipeGeneratedNames,
        ]);
    }

   #[Route('/createRecipe', name: 'app_create_recipe', methods: ['POST'])]
    public function createRecipe(Request $request, EntityManagerInterface $manager, ProductRepository $productRepository ): Response
    {
        $data = json_decode($request->getContent(), true);
        $name = $data['title'];
        $duration = $data['duration'];
        $ingredients = $data['ingredients'];

        $recipe = new Recipe();
        $recipe->setName($name);
        $recipe->setDuration($duration);

        foreach ($ingredients as $ingredientRecipe) {

            $ingredient = $productRepository->findByName($ingredientRecipe['name']);

            if ($ingredient == null) {
                $ingredient = new Product();
                $ingredient->setName($ingredientRecipe['name']);
                $ingredient->setPrice(rand(1,10));
                $ingredient->setDescription("This is a description");
                $ingredient->setQuantity($ingredientRecipe['quantity']);
                $manager->persist($ingredient);
            }

            $recipe->addIngredient($ingredient);
        }

        $manager->persist($recipe);
        $manager->flush();

        $recipeName = $recipe->getName();


        return $this->redirectToRoute('success', [
            'productName' => $recipeName,
        ]);
    }
}
