<?php

declare(strict_types=1);

use Phalcon\Mvc\Dispatcher;
use Phalcon\Mvc\View;

/** @var Phalcon\Di\FactoryDefault $di */

$di->setShared('router', function () {
    return require BASE_PATH . '/config/routes.php';
});

$di->setShared('dispatcher', function () use ($di) {
    $dispatcher = new Dispatcher();
    $dispatcher->setDefaultNamespace('App\\Controllers');

    return $dispatcher;
});

$di->setShared('view', function () use ($di) {
    $config = $di->getShared('config');
    $view = new View();
    $view->setViewsDir($config->application->viewsDir);

    return $view;
});
