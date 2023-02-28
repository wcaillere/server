<?php

namespace Administrateur\Server\controllers;

use Psr\Container\ContainerInterface;

abstract class AbstractController
{
    public function __construct(protected ContainerInterface $container)
    {
    }
}
