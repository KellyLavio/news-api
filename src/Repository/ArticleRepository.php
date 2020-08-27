<?php

namespace App\Repository;

use App\Entity\Article;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Article|null find($id, $lockMode = null, $lockVersion = null)
 * @method Article|null findOneBy(array $criteria, array $orderBy = null)
 * @method Article[]    findAll()
 * @method Article[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ArticleRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Article::class);
    }

    /**
     * @return Article[] Returns an array of Article objects
     */
    // public function findAllArticles()
    // {
    //     return $this->repository->findAll();
    // }

    public function createNewArticle(array $article)
    {
        // Formate la date et convertit de string to Datetime
        $rawDate = $article["publishedAt"];
        $replaceDate = substr(substr_replace($rawDate, ' ', 10, 1), 0, -1);
        $format = 'Y-m-d H:i:s';
        $formatedDate = date_create_from_format($format, $replaceDate);

        $newArticle = new Article();
        $newArticle->setUrl($article["url"]);
        $newArticle->setDate($formatedDate);

        if($article["urlToImage"] !== null) {
            $newArticle->setImageUrl($article["urlToImage"]);
        } else {
            return json_decode ("Pas d'URL à cette image");
        }
        
        $newArticle->setDescription($article["description"]);
        $newArticle->setTitle($article["title"]);

        return $newArticle;
    }

    // public function createNewArticle(array $article)
    // {
    //     // Formate la date et convertit de string to Datetime
    //     $rawDate = $article["publishedAt"];
    //     $replaceDate = substr(substr_replace($rawDate, ' ', 10, 1), 0, -1);
    //     $format = 'Y-m-d H:i:s';
    //     $formatedDate = date_create_from_format($format, $replaceDate);

    //     if (
    //         !is_null($article["url"])
    //         & !is_null($formatedDate)
    //         & !is_null($article["urlToImage"])
    //         & !is_null($article["description"])
    //         & !is_null($article["title"])
    //     ) {
    //         $newArticle = new Article();
    //         $newArticle->setUrl($article["url"]);
    //         $newArticle->setDate($formatedDate);
    //         $newArticle->setImageUrl($article["urlToImage"]);
    //         $newArticle->setDescription($article["description"]);
    //         $newArticle->setTitle($article["title"]);
    //         return $newArticle;
    //     }
    // }

    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult();
    }
    */

    /*
    public function findOneBySomeField($value): ?Article
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
