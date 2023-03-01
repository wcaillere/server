<?php

namespace Administrateur\Server\controllers;

use Firebase\JWT\JWT;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Administrateur\Server\controllers\AbstractController;

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

        // Génération du token JWT
        $token = JWT::encode(
            [
                "iat" => time(),
                "exp" => time() * 60 * 5,
                "user" => $data
            ],
            $_ENV["JWTKEY"],
            "HS256"
        );

        // Gestion de la réponse
        $response->getBody()->write(json_encode([
            "success" => true,
            "user" => $token
        ]));

        return $response->withHeader("Content-Type", "Application/json");
    }
}
