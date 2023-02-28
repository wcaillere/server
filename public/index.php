<?php

use DI\Container;
use Dotenv\Dotenv;
use Slim\Factory\AppFactory;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Administrateur\Server\controllers\CartController;
use Administrateur\Server\controllers\HomeController;


require "../vendor/autoload.php";

// Chargement des variables d'environement dotenv

$dotenv = Dotenv::createImmutable(dirname(__DIR__));
$dotenv->load();

$container = new Container;

AppFactory::setContainer($container);
$app = AppFactory::create();

$container->set("pdo", function (ContainerInterface $container) {
    return new PDO(
        $_ENV["DSN"],
        $_ENV["DB_USER"],
        $_ENV["DB_PASS"],
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
    );
});

$app->add(
    function (ServerRequestInterface $request, RequestHandlerInterface $handler) {
        $response = $handler->handle($request);
        return $response
            ->withHeader("Access-Control-Allow-Origin", "*")
            ->withHeader("Access-Control-Allow-Methods", "GET, POST, PUT, DELETE, OPTIONS")
            ->withHeader("Access-Control-Allow-Headers", "Content-Type, Accept,  Origin, Authorization");
    }
);

$app->get('/home', [HomeController::class, "home"]);
$app->get('/books', [HomeController::class, "getAllBooks"]);
$app->get('/books/{id}', [HomeController::class, "getOneBook"]);
$app->get('/categories', [HomeController::class, "getAllcategories"]);

$app->get('/cart/[{localStorageData}]', [CartController::class, "getCartWithLocalStorage"]);

$app->run();
