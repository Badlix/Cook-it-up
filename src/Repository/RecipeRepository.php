<?php

namespace App\Repository;

use App\Entity\Recipe;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Recipe>
 */
class RecipeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Recipe::class);
    }

    /**
     * @return Recipe[] Returns an array of Recipe objects
     */
    public function getAllRecipes(): array
    {
        return $this->createQueryBuilder('recipe')
            ->orderBy('recipe.id', 'ASC')
            ->setMaxResults(15)
            ->getQuery()
            ->getResult()
            ;
    }

    /**
     * @return Recipe[] Returns an array of Recipe objects
     */
    public function getLastRecipe($limit = 10): array
    {
        return $this->createQueryBuilder('recipe')
            ->orderBy('recipe.id', 'DESC')
            ->setMaxResults($limit)
            ->getQuery()
            ->getResult()
            ;
    }

    //    public function findOneBySomeField($value): ?Recipe
    //    {
    //        return $this->createQueryBuilder('r')
    //            ->andWhere('r.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
