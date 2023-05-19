<?php

namespace App\Controllers;

use App\Core\View;
use App\Services\User\Show\ShowUserRequest;
use App\Services\User\Show\ShowUserService;

class UserController
{
    public function show(int $id): View
    {
        $service = new ShowUserService();
        $response = $service->execute(new ShowUserRequest($id));

        return new View('user', [
            'user' => $response->getUser(),
            'articles' => $response->getArticles()
        ]);
    }
}