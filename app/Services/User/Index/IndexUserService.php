<?php

namespace app\Services\User\Index;

use App\Models\User;
use app\Repositories\User\JsonPlaceholderUserRepository;

class IndexUserService
{
    private JsonPlaceholderUserRepository $userRepository;

    public function __construct()
    {
        $this->userRepository = new JsonPlaceholderUserRepository();
    }

    public function execute(int $id): User
    {
        return $this->userRepository->getById($id);
    }
}