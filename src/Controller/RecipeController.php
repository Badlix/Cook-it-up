<?php

namespace App\Controller;

use App\Entity\Recipe;
use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class RecipeController extends AbstractController
{
    #[Route('/createRecipe', name: 'app_recipe')]
    public function index(ProductRepository $productRepository, string $name, array $ingredients, int $duration): Response
    {
        $recipe = new Recipe();
        $recipe->setName($name);
        $recipe->setDuration($duration);

        foreach ($ingredients as $ingredient) {
            $recipe->addIngredient($ingredient);
        }

        $productRepository->persist($recipe);
        $productRepository->flush();

        return $this->redirectToRoute('success', ['productName' => $recipe->getName()]);
    }
}
