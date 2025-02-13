<?php

namespace App;

use Slim\App;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use ApiGoat\Routes\RouteHelper;

/**
 * Routes definitions
 */

return function (App $app) {
    include 'Built/routes.php';

    /* declare new routes here */
    /*$app->map(['POST'], _SUB_DIR_URL . 'RefreshStats', function (Request $request, Response $response, array $args) {
        $RouteHelper = new RouteHelper($request, $args);
        $Service = new StatsService($request, $response, $RouteHelper->getArgs());
        return $Service->getApiResponse();
    })->setName('RefreshStats');*/
};
