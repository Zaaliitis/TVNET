<?php

namespace App\Repositories\Comment;

interface CommentRepository
{
    public function all(int $postId): array;

}