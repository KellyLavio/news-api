<?php

namespace App\Command;

use App\ApiNews\ApiNews;
use App\Repository\CategoryRepository;
use App\Repository\ArticleRepository;
use App\Repository\SourceRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class ApiArticlesFetchCommand extends Command
{
  protected static $defaultName = 'app:fetch-articles';

  private $apiService;
  private $articleRepository;
  private $categoryRepository;
  private $sourceRepository;

  private $em;

  public function __construct(
    ApiNews $apiNews,
    ArticleRepository $articleRepository,
    CategoryRepository $categoryRepository,
    SourceRepository $sourceRepository,
    EntityManagerInterface $em
  ) {
    $this->apiService = $apiNews;
    $this->articleRepository = $articleRepository;
    $this->categoryRepository = $categoryRepository;
    $this->sourceRepository = $sourceRepository;
    $this->em = $em;

    parent::__construct();
  }

  protected function configure()
  {
    $this->setDescription('Fetches articles from the external API.');
  }

  protected function execute(InputInterface $input, OutputInterface $output)
  {
    $io = new SymfonyStyle($input, $output);
    
    $output->writeln([
      'Fetching articles',
      '================',
      '',
    ]);

    $articles = $this->apiService->fetchArticles();
    $total = 0;
    
    foreach ($articles as $article) {
      // $source = $article['source']['name'];
      $url = $article['url'];
      if ($article['source']['id'] !== null) {
        $source = $this->sourceRepository->createOrRetrieve(strtolower ($article['source']['name']));
        $total += $this->articleRepository->createArticleFromApiData($article, $source, $url);
      }
    }

    $this->em->flush();

    $io->success("$total articles persisted");
  }
}
