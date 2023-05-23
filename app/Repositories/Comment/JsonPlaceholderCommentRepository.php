<?php

namespace App\Repositories\Comment;

use App\Core\Cache;
use App\Models\Comment;
use GuzzleHttp\Client;
use stdClass;

class JsonPlaceholderCommentRepository implements CommentRepository
{
    private Client $client;
    private array $commentCollection = [];
    public function __construct()
    {
        $this->client = new Client([
            'base_uri' => 'https://jsonplaceholder.typicode.com'
        ]);
    }
    public function all(int $postId): array
    {
        if (!Cache::has('comments_' . $postId)) {
            $response = $this->client->get('comments?postId=' . $postId);
            $responseContent = $response->getBody()->getContents();
            Cache::remember('comments_' . $postId, $responseContent);
        } else {
            $responseContent = Cache::get('comments_' . $postId);
        }
        return $this->createCollection(json_decode($responseContent));
    }
    private function createCollection($comments): array
    {
        foreach ($comments as $comment) {
            $this->commentCollection[] = $this->buildModel($comment);
        }
        return $this->commentCollection;
    }
    private function buildModel(stdClass $commentContents): Comment
    {
        return new Comment(
            $commentContents->postId,
            $commentContents->id,
            $commentContents->name,
            $commentContents->email,
            $commentContents->body
        );
    }
}