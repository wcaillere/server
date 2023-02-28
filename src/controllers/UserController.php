<?php

namespace Administrateur\Server\controllers;

use Administrateur\Server\controllers\AbstractController;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class UserController extends AbstractController
{
    public function register(ServerRequestInterface $request, ResponseInterface $response)
    {
        // Récupération des données et hashage du mot de passe
        $data = $request->getParsedBody();
        $data["password"] = password_hash($data["password"], PASSWORD_DEFAULT);

        $pdo = $this->container->get("pdo");

        $sql = "INSERT INTO `users` (email, username, password) VALUES (:email, :username, :password)";

        $statement = $pdo->prepare($sql);
        $statement->execute($data);

        $response->getBody()->write(json_encode([
            "success" => true,
            "user" => $data
        ]));



        return $response->withHeader("Content-Type", "Application/json");
    }
}
