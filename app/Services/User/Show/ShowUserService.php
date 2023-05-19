<?php

namespace App\Services\User\Show;

use App\ApiClient;
use App\Exceptions\UserNotFoundException;

class ShowUserService
{
    private ApiClient $client;

    public function __construct()
    {
        $this->client = new ApiClient();
    }

    public function execute(ShowUserRequest $request): ShowUserResponse
    {
        $user = $this->client->getUser($request->getUserId());
        $articles = $this->client->getUserPosts($request->getUserId());

        if ($user == null) {
            throw new UserNotFoundException("User " . $request->getUserId() . " not found");
        }
        return new ShowUserResponse($user, $articles);
    }
}
