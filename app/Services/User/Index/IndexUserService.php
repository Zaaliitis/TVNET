<?php

namespace app\Services\User\Index;

use App\ApiClient;
use App\Models\User;

class IndexUserService
{
    private ApiClient $client;

    public function __construct()
    {
        $this->client = new ApiClient();
    }

    public function execute(int $id): User
    {
        return $this->client->getUser($id);
    }
}