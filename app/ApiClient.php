<?php

namespace App;

use App\Core\Cache;
use GuzzleHttp\Client;
use stdClass;
use App\Models\Article;
use App\Models\Comment;
use App\Models\User;

class ApiClient
{
    private Client $client;
    private array $articleCollection = [];
    private array $commentCollection = [];
    private array $userCollection = [];

    public function __construct()
    {
        $this->client = new Client([
            'base_uri' => 'https://jsonplaceholder.typicode.com'
        ]);
    }

    public function getArticles(): array
    {
        if (!Cache::has('articles')) {
            $response = $this->client->get('posts');
            $responseContent = $response->getBody()->getContents();
            Cache::remember('articles', $responseContent);
        } else {
            $responseContent = Cache::get('articles');
        }
        return $this->articleCollection(json_decode($responseContent));
    }

    public function getComments(int $postId): array
    {
        if (!Cache::has('comments_' . $postId)) {
            $response = $this->client->get('comments?postId=' . $postId);
            $responseContent = $response->getBody()->getContents();
            Cache::remember('comments_' . $postId, $responseContent);
        } else {
            $responseContent = Cache::get('comments_' . $postId);
        }
        return $this->commentCollection(json_decode($responseContent));
    }

    public function getArticle(int $id): Article
    {
        if (!Cache::has('article_' . $id)) {
            $response = $this->client->get('posts/' . $id);
            $responseContent = $response->getBody()->getContents();
            Cache::remember('article_' . $id, $responseContent);
        } else {
            $responseContent = Cache::get('article_' . $id);
        }
        return $this->createArticle(json_decode($responseContent));
    }

    public function getUser($id): User
    {
        if (!Cache::has('user_' . $id)) {
            $response = $this->client->get('users/' . $id);
            $responseContent = $response->getBody()->getContents();
            Cache::remember('user_' . $id, $responseContent);
        } else {
            $responseContent = Cache::get('user_' . $id);
        }
        return $this->createUser(json_decode($responseContent));
    }
    public function getUserPosts(int $userId): array
    {
        if (!Cache::has('userPosts_' . $userId)) {
            $response = $this->client->get('posts?userId=' . $userId);
            $responseContent = $response->getBody()->getContents();
            Cache::remember('userPosts_' . $userId, $responseContent);
        } else {
            $responseContent = Cache::get('userPosts_' . $userId);
        }
        return $this->articleCollection(json_decode($responseContent));
    }

    private function articleCollection($articles): array
    {
        foreach ($articles as $article) {
            $this->articleCollection[] = $this->createArticle($article);
        }
        return $this->articleCollection;
    }
    private function commentCollection($comments): array
    {
        foreach ($comments as $comment) {
            $this->commentCollection[] = $this->createComment($comment);
        }
        return $this->commentCollection;
    }

    private function createComment(stdClass $commentContents): Comment
    {
        return new Comment(
            $commentContents->postId,
            $commentContents->id,
            $commentContents->name,
            $commentContents->email,
            $commentContents->body
        );
    }

    private function createUser(stdClass $userContents): User
    {
        return new User(
            $userContents->id,
            $userContents->name,
            $userContents->username,
            $userContents->email,
            $userContents->phone
        );
    }

    private function createArticle(stdClass $articleContents): Article
    {
        return new Article(
            $articleContents->userId,
            $articleContents->id,
            $articleContents->title,
            $articleContents->body,
        );
    }
}