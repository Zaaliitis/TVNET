<?php

namespace App\Services\Article\Index;

use App\ApiClient;
use App\Services\User\Index\IndexUserService;

class IndexArticleService
{
    private ApiClient $client;

    public function __construct()
    {
        $this->client = new ApiClient();
    }

    public function execute(): array
    {
        $articleContent = [];
        $articles = $this->client->getArticles();
        foreach ($articles as $article) {
            $userId = $article->getUserId();
            $user = (new IndexUserService())->execute($userId);
            $articleContent[] = [
                'article' => $article,
                'user' => $user,
            ];
        }
        return $articleContent;
    }
}