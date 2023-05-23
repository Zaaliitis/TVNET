<?php

namespace App\Repositories\Article;

use App\Core\Cache;
use App\Models\Article;
use GuzzleHttp\Client;
use stdClass;

class JsonPlaceholderArticleRepository implements ArticleRepository
{
    private Client $client;
    private array $articleCollection = [];


    public function __construct()
    {
        $this->client = new Client([
            'base_uri' => 'https://jsonplaceholder.typicode.com'
        ]);
    }

    public function all(): array
    {
        if (!Cache::has('articles')) {
            $response = $this->client->get('posts');
            $responseContent = $response->getBody()->getContents();
            Cache::remember('articles', $responseContent);
        } else {
            $responseContent = Cache::get('articles');
        }
        return $this->createCollection(json_decode($responseContent));
    }

    public function getById(int $id): ?Article
    {
        try {
            if (!Cache::has('article_' . $id)) {
                $response = $this->client->get('posts/' . $id);
                $responseContent = $response->getBody()->getContents();
                Cache::remember('article_' . $id, $responseContent);
            } else {
                $responseContent = Cache::get('article_' . $id);
            }
            return $this->buildModel(json_decode($responseContent));
        } catch (\RuntimeException $exception) {
            return null;
        }
    }
    public function getByUserId(int $userId): array
    {
        if (!Cache::has('userPosts_' . $userId)) {
            $response = $this->client->get('posts?userId=' . $userId);
            $responseContent = $response->getBody()->getContents();
            Cache::remember('userPosts_' . $userId, $responseContent);
        } else {
            $responseContent = Cache::get('userPosts_' . $userId);
        }
        return $this->createCollection(json_decode($responseContent));
    }

    private function createCollection($articles): array
    {
        foreach ($articles as $article) {
            $this->articleCollection[] = $this->buildModel($article);
        }
        return $this->articleCollection;
    }

    private function buildModel(stdClass $articleContents): Article
    {
        return new Article(
            $articleContents->userId,
            $articleContents->id,
            $articleContents->title,
            $articleContents->body,
        );
    }
}