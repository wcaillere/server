<?php

use Administrateur\Server\controllers\CartController;

$app->get('/cart/[{localStorageData}]', [CartController::class, "getCartWithLocalStorage"]);
