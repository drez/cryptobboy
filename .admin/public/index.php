<?php
require __DIR__ . '/../config/Built/config.php';
require _VENDOR_DIR . 'autoload.php';
require __DIR__ . '/../config/legacy.php';

use DI\ContainerBuilder;
use Slim\App;

$containerBuilder = new ContainerBuilder();

// Set up settings
$containerBuilder->addDefinitions(__DIR__ . '/../config/container.php');

// Build PHP-DI Container instance
$container = $containerBuilder->build();

// Create App instance
$app = $container->get(App::class);

require __DIR__ . '/../config/dependencies.php';

(require __DIR__ . '/../config/routes.php')($app);
(require __DIR__ . '/../config/middlewares.php')($app);

$app->run();
