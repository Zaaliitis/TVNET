<?php

namespace App\Repositories\User;


use App\Core\Cache;
use App\Models\User;
use GuzzleHttp\Client;
use stdClass;

class JsonPlaceholderUserRepository implements UserRepository
{
    private Client $client;

    public function __construct()
    {
        $this->client = new Client([
            'base_uri' => 'https://jsonplaceholder.typicode.com'
        ]);
    }
    public function getById($id): ?User
    {
        try {
            if (!Cache::has('user_' . $id)) {
                $response = $this->client->get('users/' . $id);
                $responseContent = $response->getBody()->getContents();
                Cache::remember('user_' . $id, $responseContent);
            } else {
                $responseContent = Cache::get('user_' . $id);
            }
            return $this->buildModel(json_decode($responseContent));
        } catch (\RuntimeException $exception) {
            return null;
        }
    }
    private function buildModel(stdClass $userContents): User
    {
        return new User(
            $userContents->id,
            $userContents->name,
            $userContents->username,
            $userContents->email,
            $userContents->phone
        );
    }
}