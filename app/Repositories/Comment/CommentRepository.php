<?php

namespace App\Repositories\Article;

use App\Models\Comment;

interface CommentRepository
{
    public function all(): array;

}