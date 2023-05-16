<?php

namespace App\Models;
class Article
{
    private int $userId;
    private int $id;
    private string $title;
    private string $body;

    public function __construct(
        int $userId,
        int $id,
        string $title,
        string $body
    )
    {

        $this->userId = $userId;
        $this->id = $id;
        $this->title = $title;
        $this->body = $body;
    }


    public function getId(): int
    {
        return $this->id;
    }


    public function getTitle(): string
    {
        return $this->title;
    }

    public function getBody(): string
    {
        return $this->body;
    }

    public function getUserId(): int
    {
        return $this->userId;
    }
}