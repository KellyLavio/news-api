<?php

namespace App\Command;

use App\ApiNews\ApiNews;
use App\Repository\CategoryRepository;
use App\Repository\SourceRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class ApiSourcesFetchCommand extends Command
{
  protected static $defaultName = 'app:fetch-sources';

  private $apiService;
  private $sourceRepository;
  private $categoryRepository;
  private $em;

  public function __construct(
    ApiNews $apiNews,
    SourceRepository $sourceRepository,
    CategoryRepository $categoryRepository,
    EntityManagerInterface $em
  ) {
    $this->apiService = $apiNews;
    $this->sourceRepository = $sourceRepository;
    $this->categoryRepository = $categoryRepository;
    $this->em = $em;

    parent::__construct();
  }

  protected function configure()
  {
    $this->setDescription('Fetches sources from the external API.');
  }

  protected function execute(InputInterface $input, OutputInterface $output)
  {
    $io = new SymfonyStyle($input, $output);
    
    $output->writeln([
      'Fetching sources',
      '================',
      '',
    ]);

    $sources = $this->apiService->fetchSources();
    $total = 0;

    foreach ($sources as $source) {
      $category = $this->categoryRepository->createOrRetrieve($source['category']);
      $total += $this->sourceRepository->createFromApiData($source, $category);
    }

    $this->em->flush();

    $io->success("$total sources persisted");
  }
}
