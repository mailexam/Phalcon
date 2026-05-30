<?php

declare(strict_types=1);

use Phalcon\Config\Config;

return new Config([
    'application' => [
        'controllersDir' => BASE_PATH . '/app/Controllers/',
        'viewsDir' => BASE_PATH . '/app/views/',
    ],
]);
