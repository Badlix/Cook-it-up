<?php

namespace App\Repository;

use App\Entity\Product;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Product>
 */
class ProductRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Product::class);
    }

    /**
     * @return Product[] Returns an array of Product objects
     */
    public function getAllProducts(): array
    {
        return $this->createQueryBuilder('product')
            ->orderBy('product.id', 'ASC')
            ->setMaxResults(15)
            ->getQuery()
            ->getResult()
        ;
    }

    /**
     * @return int Return the Id of the new Product
     */
    public function addProduct($name, $description, $price, $quantity): int {
        $product = new Product();
        $product->setName($name);
        $product->setDescription($description);
        $product->setPrice($price);
        $product->setPrice($quantity);

        $this->persist($product);
        $this->flush();

        return $product->getId();
    }

    public function findByName($name): ?Product
    {
        return $this->createQueryBuilder('product')
            ->andWhere('product.name = :val')
            ->setParameter('val', $name)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }

}
