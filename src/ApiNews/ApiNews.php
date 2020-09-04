<?php

namespace App\ApiNews;

use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;

class ApiNews
{
  private $client;
  private $apiKey;
  private $baseUrl;
  const TOP_HEADLINES = '/top-headlines';
  const SOURCES = '/sources';

  public function __construct(string $baseUrl, string $apiKey, HttpClientInterface $client)
  {
    $this->client = $client;
    $this->apiKey = $apiKey;
    $this->baseUrl = $baseUrl;
  }

  public function fetchArticles(): array
  {
    $response = $this->getResponse(
      $this->baseUrl . self::TOP_HEADLINES,
      [
        'country' => 'fr',
        'pageSize' => '100'
      ]
    );

    $content = $response->toArray();
    return $content["articles"];
  }

  public function fetchSources(): array
  {
    $response = $this->getResponse($this->baseUrl . self::SOURCES);

    $content = $response->toArray();
    return $content['sources'];
  }

  private function getResponse(string $url, array $query = []): ResponseInterface
  {
    $queryString = array_merge([
      'apiKey' => $this->apiKey
    ], $query);

    return $this->client->request(
      'GET',
      $url,
      ['query' => $queryString]
    );
  }
}
