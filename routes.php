<?php
return [
    ['GET', '/', [\App\Controllers\ArticleController::class, "home"]],
    ['GET', '/home', [\App\Controllers\ArticleController::class, "home"]],
    ['GET', '/article/{id:\d+}', [\App\Controllers\ArticleController::class, "article"]],
    ['GET', '/user/{id:\d+}', [\App\Controllers\ArticleController::class, "user"]],
];