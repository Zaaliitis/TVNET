<?php

namespace App\Services\User\Show;

use App\Exceptions\UserNotFoundException;
use app\Repositories\Article\JsonPlaceholderArticleRepository;
use app\Repositories\User\JsonPlaceholderUserRepository;

class ShowUserService
{
    private JsonPlaceholderUserRepository $userRepository;
    private JsonPlaceholderArticleRepository $articleRepository;

    public function __construct()
    {
        $this->userRepository = new JsonPlaceholderUserRepository();
        $this->articleRepository = new JsonPlaceholderArticleRepository();
    }

    public function execute(ShowUserRequest $request): ShowUserResponse
    {
        $user = $this->userRepository->getById($request->getUserId());
        $articles = $this->articleRepository->getByUserId($request->getUserId());

        if ($user == null) {
            throw new UserNotFoundException("User " . $request->getUserId() . " not found");
        }
        return new ShowUserResponse($user, $articles);
    }
}
