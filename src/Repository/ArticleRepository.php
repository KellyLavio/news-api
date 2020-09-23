<?php

namespace App\Repository;

use App\Entity\Article;
use App\Entity\Source;
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
     * Return an Article array of objects
     *
     * @param array $article
     * @return void
     */
    public function createArticleFromApiData(array $article, Source $source, string $url): int
    {
        $articleEntity = $this->findOneBy(['url' => $url]);

        if ($articleEntity !== null) {
            return 0;
        }
        // Formats the date & converts it from string to Datetime
        $replaceDate = substr(substr_replace($article["publishedAt"], ' ', 10, 1), 0, -1);
        $formatedDate = date_create_from_format('Y-m-d H:i:s', $replaceDate);

        $articleEntity = new Article();
        $articleEntity->setUrl($article["url"])
            ->setDate($formatedDate)
            ->setImageUrl($article["urlToImage"])
            ->setDescription($article["description"])
            ->setTitle($article["title"])
            ->setSource($source);
        $this->_em->persist($articleEntity);


        return 1;
    }

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
