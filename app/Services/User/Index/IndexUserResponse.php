<?php

namespace App\Services\User\Index;

use App\Models\User;

class IndexUserResponse
{
    private User $user;
    private array $articles;

    public function __construct(User $user, array $articles)
{
    $this->user = $user;
    $this->articles = $articles;
}

    public function getArticles(): array
    {
        return $this->articles;
    }

    public function getUser(): User
    {
        return $this->user;
    }
}
