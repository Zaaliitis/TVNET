<?php

namespace App\Services\Article\Show;

use App\ApiClient;
use App\Exceptions\ArticleNotFoundException;

class ShowArticleService
{
    private ApiClient $client;

    public function __construct()
    {
        $this->client = new ApiClient();
    }

    public function execute(ShowArticleRequest $request): ShowArticleResponse
    {
        $article = $this->client->getArticle($request->getArticleId());
        if ($article == null) {
            throw new ArticleNotFoundException("Article " . $request->getArticleId() ." not found");
        }
        $comments = $this->client->getComments($request->getArticleId());
        return new ShowArticleResponse($article, $comments);
    }
}