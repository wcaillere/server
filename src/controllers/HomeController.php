<?php

namespace Administrateur\Server\controllers;

use PDO;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Administrateur\Server\controllers\AbstractController;

class HomeController extends AbstractController
{
    public function home(RequestInterface $request, ResponseInterface $response)
    {
        $response->getBody()->write("hello word");
        return $response;
    }

    public function getAllBooks(RequestInterface $request, ResponseInterface $response)
    {
        $pdo = $this->container->get("pdo");



        // Requête préparée
        $sql = "SELECT * FROM allbooksview";
        $statement = $pdo->prepare($sql);
        $statement->execute();

        // Récupération et envoi des données
        $bookList = $statement->fetchAll(PDO::FETCH_ASSOC);
        $response->getBody()->write(json_encode(
            [
                "success" => true,
                "data" => $bookList
            ]
        ));

        return $response->withHeader("Content-Type", "Application/json");
    }

    public function getOneBook(RequestInterface $request, ResponseInterface $response, $args)
    {
        $pdo = $this->container->get("pdo");

        // Requête préparée
        $sql = "SELECT * FROM allbooksview WHERE id=:id";
        $statement = $pdo->prepare($sql);
        $statement->execute(["id" => $args["id"]]);

        // Récupération et envoi des données
        $book = $statement->fetch(PDO::FETCH_ASSOC);
        $response->getBody()->write(json_encode(
            [
                "success" => true,
                "data" => $book
            ]
        ));

        return $response->withHeader("Content-Type", "Application/json");
    }

    public function getAllCategories(RequestInterface $request, ResponseInterface $response)
    {
        $pdo = $this->container->get("pdo");

        // Requête préparée
        $statement = $pdo->query("SELECT name_category FROM categories");

        // Récupération et envoi des données
        $categoryList = $statement->fetchAll(PDO::FETCH_COLUMN);
        $response->getBody()->write(json_encode(
            [
                "success" => true,
                "data" => $categoryList
            ]
        ));

        return $response->withHeader("Content-Type", "Application/json");
    }
}
