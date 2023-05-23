<?php

namespace App\Repositories\User;

use App\Models\User;

interface UserRepository
{
    public function getById($id): ?User;

}