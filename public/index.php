<?php

declare(strict_types=1);

use Phalcon\Di\FactoryDefault;
use Phalcon\Mvc\Application;

define('BASE_PATH', dirname(__DIR__));

require BASE_PATH . '/vendor/autoload.php';

Dotenv\Dotenv::createImmutable(BASE_PATH)->safeLoad();

$config = require BASE_PATH . '/config/config.php';

$di = new FactoryDefault();
$di->setShared('config', $config);
require BASE_PATH . '/config/services.php';

$application = new Application($di);

try {
    $response = $application->handle($_SERVER['REQUEST_URI'] ?? '/');
} catch (Throwable $exception) {
    $response = $di->getShared('response');
    $response->setStatusCode(500, 'Internal Server Error');
    $response->setJsonContent(['error' => $exception->getMessage()]);
}

$response->send();
