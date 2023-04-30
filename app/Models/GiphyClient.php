<?php

declare(strict_types=1);

namespace Giphy\Models;

require_once __DIR__ . '/../bootstrap.php';

use GuzzleHttp\Client;
use Psr\Http\Message\ResponseInterface;

class GiphyClient
{
    private Client $client;
    private array $gifs;
    private string $apiKey;

    public function __construct()
    {
        $this->apiKey = $_ENV['API_KEY'];
        $this->client = new Client();
    }

    public function getTrending(): array
    {
        $response = $this->client->request(
            'GET',
            'https://api.giphy.com/v1/gifs/trending',
            [
                'query' => [
                    'api_key' => $this->apiKey,
                    'limit' => 20,
                    'offset' => 0,
                    'rating' => 'g',
                    'lang' => 'en',
                ],
            ]
        );

        return $this->extractGifs($response);
    }

    public function getSearched(string $query, int $count = 20): array
    {
        $response = $this->client->request(
            'GET',
            'https://api.giphy.com/v1/gifs/search',
            [
                'query' => [
                    'api_key' => $this->apiKey,
                    'q' => urlencode($query),
                    'limit' => $count,
                    'offset' => 0,
                    'rating' => 'g',
                    'lang' => 'en',
                ],
            ]
        );

        return $this->extractGifs($response);
    }

    public function getRandom(): string
    {
        $response = $this->client->request(
            'GET',
            'https://api.giphy.com/v1/gifs/random',
            [
                'query' => [
                    'api_key' => $this->apiKey,
                    'tag' => '',
                    'rating' => 'g',
                ],
            ]
        );

        $body = json_decode($response->getBody()->getContents());
        $gifUrl = $body->data->images->original->url;

        return (new Gif($gifUrl))->getUrl();
    }

    private function extractGifs(ResponseInterface $response): array
    {
        $body = json_decode($response->getBody()->getContents());
        $gifs = [];

        if (!empty($body->data)) {
            foreach ($body->data as $gif) {
                if (isset($gif->images->fixed_height_small->url)) {
                    $gifs[] = new Gif($gif->images->fixed_height_small->url);
                }
            }
        }

        return $gifs;
    }
}