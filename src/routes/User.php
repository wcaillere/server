<?php

use Administrateur\Server\controllers\UserController;

$app->post('/user/register', [UserController::class, "register"]);
