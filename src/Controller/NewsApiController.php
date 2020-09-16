<?php

namespace App\ApiNews;

namespace App\Controller;

use App\ApiNews\ApiNews;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\ArticleRepository;
use App\Repository\SourceRepository;
use Symfony\Component\Serializer\SerializerInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;


class NewsApiController extends AbstractController
{
    /**
     * @var SerializerInterface
     */
    private $serializer;

    public function __construct(SerializerInterface $serializer)
    {
        $this->serializer = $serializer;
    }

    /**
     * @Route("/news/api", name="news_api", methods={"GET"})
     */
    public function getArticles(ApiNews $apiNews, EntityManagerInterface $em, ArticleRepository $articleRepository, SourceRepository $sourceRepository, string $url)
    {
        $articleList = $apiNews->fetchArticles();

        foreach ($articleList as $article) {
            $source = $sourceRepository->createOrRetrieve($article['source']['name']);
            $newArticle = $articleRepository->createArticleFromApiData($article, $source, $url);
            if ($newArticle !== null) {
                    $em->persist($newArticle);
                    $em->flush();
            }
            return new Response("Articles enregistrés en BDD");
        }
    }
}
