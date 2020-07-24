<?php

namespace App\ApiNews;

use Symfony\Contracts\HttpClient\HttpClientInterface;

class ApiNews
{
    private $client;
    private $apiKey;

    public function __construct (string $apiKey, HttpClientInterface $client)
    {
        $this->client = $client;
        $this->apiKey = $apiKey;
    }

    public function fetchArticles(): array
    {
        $response = $this->client->request(
            'GET',
            'http://newsapi.org/v2/top-headlines',
            ['query' => [
                'country' => 'fr',
                'apiKey' => $this->apiKey
                ],
            ]);

        $statusCode = $response->getStatusCode();

        $contentType = $response->getHeaders()['application/json'][0];

        $content = $response->getContent();

        $content = $response->toArray();

        return $content;
    }
}