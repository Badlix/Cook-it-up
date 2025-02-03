<?php

namespace App\DataFixtures;

use App\Entity\Product;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Persistence\ObjectManager;

class ProductFixtures extends Fixture implements FixtureGroupInterface
{

    // symfony console doctrine:fixtures:load --group=resetData
    public function load(ObjectManager $manager): void
    {
        $products = [];
        $products[] = (new Product())->setName("Tomate")->setDescription("Tomate fraîche, idéale pour les salades ou les sauces.")->setPrice(1)->setQuantity(1);
        $products[] = (new Product())->setName("Pomme")->setDescription("Pomme croquante et sucrée, parfaite pour un goûter ou une tarte.")->setPrice(2)->setQuantity(10);
        $products[] = (new Product())->setName("Banane")->setDescription("Banane mûre et sucrée, idéale pour les smoothies ou les snacks.")->setPrice(1.5)->setQuantity(8);
        $products[] = (new Product())->setName("Carotte")->setDescription("Carotte tendre, parfaite pour les salades, soupes ou à croquer nature.")->setPrice(0.5)->setQuantity(15);
        $products[] = (new Product())->setName("Poire")->setDescription("Poire juteuse et sucrée, excellente à manger nature ou en dessert.")->setPrice(1.8)->setQuantity(6);
        $products[] = (new Product())->setName("Concombre")->setDescription("Concombre frais, idéal pour les salades ou en tranches pour l'apéritif.")->setPrice(0.8)->setQuantity(12);
        $products[] = (new Product())->setName("Salade")->setDescription("Salade verte croquante, parfaite pour accompagner vos repas.")->setPrice(1.2)->setQuantity(5);
        $products[] = (new Product())->setName("Aubergine")->setDescription("Aubergine violette, idéale pour les ratatouilles, grillades ou plats méditerranéens.")->setPrice(2.5)->setQuantity(4);
        $products[] = (new Product())->setName("Fraise")->setDescription("Fraise sucrée et parfumée, parfaite pour les desserts ou à déguster nature.")->setPrice(2)->setQuantity(12);
        $products[] = (new Product())->setName("Pomme de Terre")->setDescription("Pomme de terre idéale pour les purées, frites ou gratins.")->setPrice(1.3)->setQuantity(9);

        foreach ($products as $product) {
            $manager->persist($product);
        }
        $manager->flush();
    }

    public static function getGroups(): array {
        return ['resetData'];
    }
}
