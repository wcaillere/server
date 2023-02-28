<?php

namespace Administrateur\Server\controllers;

use PDO;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Administrateur\Server\controllers\AbstractController;

class CartController extends AbstractController
{
    public function getCartWithLocalStorage(RequestInterface $request, ResponseInterface $response, array $args)
    {
        $idBooks = $args["localStorageData"];

        $sqlId = "(" . implode(", ", explode("&", $idBooks)) . ")";

        $pdo = $this->container->get("pdo");

        // Requête préparée
        $sql = "SELECT * FROM allbooksview WHERE id IN $sqlId";
        $statement = $pdo->prepare($sql);
        $statement->execute();

        // Récupération et envoi des données
        $bookList = $statement->fetchAll(PDO::FETCH_ASSOC);

        $response->getBody()->write(json_encode(
            [
                "success" => true,
                "data" => $bookList,
                "is" => $sqlId
            ]
        ));

        return $response->withHeader("Content-Type", "Application/json");
    }
}
