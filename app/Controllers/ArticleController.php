<?php

namespace App\Controllers;

use App\ApiClient;
use App\Core\View;

class ArticleController
{
    private ApiClient $client;

    public function __construct()
    {
        $this->client = new ApiClient();
    }

    public function home(): View
    {
        $articles = $this->client->getArticles();
        $articleContent = [];

        foreach ($articles as $article) {
            $userId = $article->getUserId();
            $user = $this->client->getUser($userId);
            $articleContent[] = [
                'article' => $article,
                'user' => $user,
            ];
        }

        return new View('articles', ['articles' => $articleContent]);
    }

    public function article(int $id): View
    {
        $article = $this->client->getArticle($id);
        $comments = $this->client->getComments($id);
        return new View('article', [
            'article' => $article,
            'comments' => $comments
        ]);
    }

    public function user(int $id): View
    {
        $user = $this->client->getUser($id);
        $articles = $this->client->getUserPosts($id);
        return new View('user', [
            'articles' => $articles,
            'user' => $user
        ]);
    }
}