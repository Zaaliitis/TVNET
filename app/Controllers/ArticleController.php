<?php

namespace App\Controllers;

use App\Core\View;
use App\Services\Article\Index\IndexArticleService;
use App\Services\Article\Show\ShowArticleRequest;
use App\Services\Article\Show\ShowArticleService;

class ArticleController
{
    public function index(): View
    {
        $service = new IndexArticleService();
        $articles = $service->execute();

        return new View('articles', ['articles' => $articles]);
    }

    public function show(int $id): View
    {
        $service = new ShowArticleService();
        $response = $service->execute(new ShowArticleRequest($id));

        return new View('article', [
            'article' => $response->getArticle(),
            'comments' => $response->getComments()
        ]);
    }

}