<?php
return [
    ['GET', '/', [\App\Controllers\ArticleController::class, "index"]],
    ['GET', '/home', [\App\Controllers\ArticleController::class, "index"]],
    ['GET', '/article/{id:\d+}', [\App\Controllers\ArticleController::class, "show"]],
    ['GET', '/user/{id:\d+}', [\App\Controllers\UserController::class, "show"]],
];