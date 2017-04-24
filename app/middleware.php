<?php

use Slim\Middleware\JwtAuthentication;

$app->add($app->getContainer()->get(JwtAuthentication::class));