<?php

declare(strict_types=1);

use Phalcon\Mvc\Router;

$router = new Router(false);
$router->setDefaults([
    'namespace' => 'App\\Controllers',
    'controller' => 'index',
    'action' => 'index',
]);

$router->addPost('/mail/test', [
    'controller' => 'mail',
    'action' => 'test',
]);

return $router;
