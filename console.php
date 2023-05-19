<?php

use App\Models\Article;
use App\Models\Comment;
use App\Services\Article\Index\IndexArticleService;
use App\Services\Article\Show\ShowArticleRequest;
use App\Services\Article\Show\ShowArticleService;
use App\Services\User\Show\ShowUserRequest;
use App\Services\User\Show\ShowUserService;

require_once 'vendor/autoload.php';

$resource = $argv[1] ?? null;
$id = $argv[2] ?? null;

switch ($resource) {
    case 'articles':
        if ($id == null) {
            $service = new IndexArticleService();
            $articles = $service->execute();
            foreach ($articles as $article) {
                /** @var Article $article */
                echo "---------------------------------------------" . PHP_EOL;
                echo "-------" . $article['article']->getTitle() . "-------" . PHP_EOL;
                echo "---------------------------------------------" . PHP_EOL;
                echo "|" . $article['article']->getBody() . "|" . PHP_EOL;
                echo "------------------------------------" . PHP_EOL;
                echo "ARTICLE BY: [ " . $article['user']->getName() . " ]" . PHP_EOL;
            }
        } else {
            $service = new ShowArticleService();
            $request = new ShowArticleRequest($id);
            $articleResponse = $service->execute($request);
            $article = $articleResponse->getArticle();
            $comments = $articleResponse->getComments();
            echo ">>>>" . $article->getTitle() . "<<<<" . PHP_EOL;
            echo "-|-" . $article->getBody() . "-|-" . PHP_EOL;
            echo "<- Comments ->" . PHP_EOL;
            foreach ($comments as $comment) {
                /** @var Comment $comment */
                echo "----" . $comment->getName() . "----" . PHP_EOL;
                echo "----" . $comment->getEmail() . "----" . PHP_EOL;
                echo "------------------------------" . PHP_EOL;
                echo $comment->getBody() . PHP_EOL;
                echo "------------------------------" . PHP_EOL;
            }
        }
        break;
    case
    'users';
        if ($id == null) {
            echo "enter user ID" . PHP_EOL;
        } else {
            $service = new ShowUserService();
            $request = new ShowUserRequest($id);
            $userResponse = $service->execute($request);
            $user = $userResponse->getUser();
            $articles = $userResponse->getArticles();
            echo ">>>>" . $user->getName() . "<<<<" . PHP_EOL;
            echo "-|-" . $user->getEmail() . "-|-" . PHP_EOL;
            echo "<- Articles ->" . PHP_EOL;
            foreach ($articles as $article) {
                /** @var Article $article */
                echo "----" . $article->getTitle() . "----" . PHP_EOL;
                echo "------------------------------" . PHP_EOL;
                echo $article->getBody() . PHP_EOL;
                echo "------------------------------" . PHP_EOL;
            }
        }
        break;
    default:
        echo "Invalid resource provided";
}