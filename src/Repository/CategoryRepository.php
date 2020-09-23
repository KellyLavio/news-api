<?php

namespace App\Repository;

use App\Entity\Category;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Category|null find($id, $lockMode = null, $lockVersion = null)
 * @method Category|null findOneBy(array $criteria, array $orderBy = null)
 * @method Category[]    findAll()
 * @method Category[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CategoryRepository extends ServiceEntityRepository
{
  public function __construct(ManagerRegistry $registry)
  {
    parent::__construct($registry, Category::class);
  }

  public function createOrRetrieve(string $name): Category
  {
    // Identifies the Category by name
    $category = $this->findOneBy(['name' => $name]);

    // If there is no category in BDD, creates a new category
    if ($category === null) {
      $category = new Category();
      $category->setName($name);

      $this->_em->persist($category);
      $this->_em->flush();
    }
    return $category;
  }
}
