<?php

namespace App\Services\Article\Index;

use app\Repositories\Article\JsonPlaceholderArticleRepository;
use App\Services\User\Index\IndexUserService;

class IndexArticleService
{
    private JsonPlaceholderArticleRepository $articleRepository;


    public function __construct()
    {
        $this->articleRepository = new JsonPlaceholderArticleRepository();
    }

    public function execute(): array
    {
        $articleContent = [];
        $articles = $this->articleRepository->all();
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