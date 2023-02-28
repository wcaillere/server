<?php

use DI\Container;
use Dotenv\Dotenv;
use Slim\Factory\AppFactory;
use Psr\Container\ContainerInterface;

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

// Middlewares app
require("../src/middlewares/Headers.php");

//
require("../src/routes/Home.php");
require("../src/routes/Cart.php");

$app->run();
