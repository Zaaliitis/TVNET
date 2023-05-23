<?php

namespace App\Services\Article\Show;

use App\Exceptions\ArticleNotFoundException;
use App\Repositories\Article\JsonPlaceholderArticleRepository;
use App\Repositories\Comment\JsonPlaceholderCommentRepository;

class ShowArticleService
{
    private JsonPlaceholderArticleRepository $articleRepository;
    private JsonPlaceholderCommentRepository $commentRepository;

    public function __construct()
    {
        $this->articleRepository = new JsonPlaceholderArticleRepository();
        $this->commentRepository = new JsonPlaceholderCommentRepository();
    }

    public function execute(ShowArticleRequest $request): ShowArticleResponse
    {
        $article = $this->articleRepository->getById($request->getArticleId());
        if ($article == null) {
            throw new ArticleNotFoundException("Article " . $request->getArticleId() ." not found");
        }
        $comments = $this->commentRepository->all($request->getArticleId());
        return new ShowArticleResponse($article, $comments);
    }
}