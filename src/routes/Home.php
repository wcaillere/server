<?php

use Administrateur\Server\controllers\CartController;
use Administrateur\Server\controllers\HomeController;

$app->get('/home', [HomeController::class, "home"]);
$app->get('/books', [HomeController::class, "getAllBooks"]);
$app->get('/books/{id}', [HomeController::class, "getOneBook"]);
$app->get('/categories', [HomeController::class, "getAllcategories"]);
