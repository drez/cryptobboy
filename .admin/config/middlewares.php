<?php

use Slim\App;
use ApiGoat\Handlers\HtmlErrorRenderer;
use ApiGoat\Handlers\JsonErrorRenderer;
use Selective\Config\Configuration;
use ApiGoat\Middlewares\RecallMiddleware;
use ApiGoat\Middlewares\RbacMiddleware;
use ApiGoat\Middlewares\AuthyMiddleware;
use ApiGoat\Middlewares\RouteParser;
use ApiGoat\Handlers\ExceptionHandler;
use Tuupola\Middleware\JwtAuthentication;
use Tuupola\Middleware\CorsMiddleware;
use Slim\Interfaces\CallableResolverInterface;

return function (App $app) {
    $container = $app->getContainer();


    // Keep track of current user backend options
    //$app->add(RecallMiddleware::class);

    //$app->add(Logger::class);

    $app->addRoutingMiddleware();
    $app->add(RbacMiddleware::class);
    // Standard authentication
    $app->add(AuthyMiddleware::class);
    // Authentication for the API
    $app->add(JwtAuthentication::class);
    $app->add(RbacMiddleware::class);
    $app->add(RouteParser::class);

    $app->add(CorsMiddleware::class);

    // Parse json, form data and xml
    $app->addBodyParsingMiddleware();

    $settings = $container->get(Configuration::class)->getArray('error_handler_middleware');
    $displayErrorDetails = (bool) $settings['display_error_details'];
    $logErrors = (bool) $settings['log_errors'];
    $logErrorDetails = (bool) $settings['log_error_details'];


    $errorMiddleware = $app->addErrorMiddleware($displayErrorDetails, $logErrors, $logErrorDetails);
    $errorMiddleware->setErrorHandler(['IOException','RuntimeException','DirectoryNotFoundException','PropelException', 'ExitStatusException','BuildException','ConfigurationException','Exception','Throwable','HJSON\HJSONException', 'Error'], ExceptionHandler::class);
    //$errorHandler = $errorMiddleware->getDefaultErrorHandler();
    //$errorHandler->registerErrorRenderer('text/html', HtmlErrorRenderer::class);
    //$errorHandler->registerErrorRenderer('application/json', JsonErrorRenderer::class);
};
