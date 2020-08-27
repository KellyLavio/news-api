<?php

namespace App\ApiNews;
namespace App\Controller;

use App\ApiNews\ApiNews;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Article;
use App\Repository\ArticleRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;


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
    public function getArticles(Request $request, ApiNews $apiNews, EntityManagerInterface $em, ArticleRepository $articleRepository)
    {
        $articleList = $apiNews->fetchArticles();

        // $allArticles = $em->getRepository(Article::class)->findAll();

        foreach($articleList as $article) {
            $newArticle = $articleRepository->createNewArticle($article);

            // $this->serializer->deserialize($article, Article::class, 'json');
            // dd($articleList);
            // $objArticle = $this->serializer->deserialize($article, Article::class, 'json', []);

            $em->persist($newArticle);
        };

        $em->flush();
    }
}
