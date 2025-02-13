<?php

use Slim\App;
use Slim\Factory\AppFactory;
use Slim\Interfaces\CallableResolverInterface;
use Slim\CallableResolver;
use Psr\Http\Message\ResponseFactoryInterface;
use Slim\Psr7\Factory\ResponseFactory;

use Psr\Container\ContainerInterface;
use Selective\Config\Configuration;
use ApiGoat\Middlewares\RecallMiddleware;
use ApiGoat\Middlewares\AuthyMiddleware;
use ApiGoat\Middlewares\RouteParser;
use ApiGoat\Middlewares\RbacMiddleware;
use ApiGoat\Handlers\ExceptionHandler;
use ApiGoat\Handlers\HtmlErrorRenderer;
use ApiGoat\Handlers\JsonErrorRenderer;

use Tuupola\Middleware\JwtAuthentication;
use Tuupola\Middleware\CorsMiddleware;
use Northwoods\Middleware\ConditionalMiddleware;
use Psr\Http\Message\ServerRequestInterface as Request;

use Analog\Logger;
use Psr\Http\Message\ResponseInterface;

return [
    Configuration::class => function () {
        return new Configuration(require __DIR__ . '/../config/settings.php');
    },
    App::class => function (ContainerInterface $container) {
        AppFactory::setContainer($container);
        $app = AppFactory::create();

        $config = $container->get(Configuration::class);

        $_SESSION[_AUTH_VAR]->config['jwt'] = $config->getArray('jwt_middleware');
        $_SESSION[_AUTH_VAR]->config['locale'] = $config->getArray('locale');
        return $app;
    },
    RecallMiddleware::class => function ($container) {
        $standard_actions = $container->get(Configuration::class)->getArray('route.standard_actions');

        return new RecallMiddleware($standard_actions);
    },
    CorsMiddleware::class => function ($container) {
        $cors_defaults_settings = $container->get(Configuration::class)->getArray('cors');
        return new CorsMiddleware($cors_defaults_settings['defaults']);
    },
    JwtAuthentication::class => function ($container) {
        $jwt_defaults_settings = $container->get(Configuration::class)->getArray('jwt_middleware');
        $jwt_callbacks = [
            "before" => function ($request, $args) use ($container) {
                $container->set("token", $args["decoded"]);
                // to exploit cookie add :  && $_SESSION[_AUTH_VAR]->get('connected') == 'NO'
                if (is_array($args["decoded"]) && isset($args["decoded"]['authyId']) && $_SESSION[_AUTH_VAR]->get('connected') == 'NO') {
                    $AuthyService = new \App\AuthyServiceWrapper($request, $response, $args);
                    $Authy = \App\AuthyQuery::create()->findPk($args["decoded"]['authyId']);
                    if ($Authy) {
                        $AuthyService->setSession($Authy, $args["decoded"]['username']);
                    }
                }
            },
            "error" => function (ResponseInterface $response, array $arguments) {
                $data["status"] = "failure";
                $data['error'] = 'Invalid token on private route';
                $data['messages'] = [$arguments["message"]];

                return $response
                    ->withHeader("Content-Type", "application/json")
                    ->getBody()->write(json_encode($data, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT));
            }
        ];
        $jwt_settings = array_merge($jwt_defaults_settings, $jwt_callbacks);
        $jwtAuth = new JwtAuthentication($jwt_settings);

        return new ConditionalMiddleware($jwtAuth, function (Request $request): bool {
            // skip if is not API call
            if ($request->getAttribute('parsed_args')['is_api'] != true) {
                return false;
            }

            // skip if session exists
            if ($_SESSION[_AUTH_VAR]->get('connected') === 'YES') {
                return false;
            }

            // skip on public route
            if ($request->getAttribute('rbac_public') === 'passed') {
                return false;
            }

            return true;
        });
    },
    Logger::class => function ($container) {
        $log_settings = $container->get(Configuration::class)->getArray('log');
        $logger = new Logger;
        $logger->handler($log_settings['facility']::init());
        return $logger;
    },
    RouteParser::class => function ($container) {
        return new RouteParser();
    },
    Authy::class => function ($container) {
        return new AuthyMiddleware();
    },
    RbacMiddleware::class => function ($container) {
        return new RbacMiddleware();
    },
    CallableResolverInterface::class => static function (ContainerInterface $container): CallableResolverInterface {
        return new CallableResolver($container);
    },
    ResponseFactoryInterface::class => static function (): ResponseFactoryInterface {
        return new ResponseFactory();
    },
    ExceptionHandler::class => function ($container) {
        $errorHandler =  new ExceptionHandler(
            $container->get(CallableResolverInterface::class),
            $container->get(ResponseFactoryInterface::class),
            null,
            $container
        );
        $errorHandler->registerErrorRenderer('text/html', HtmlErrorRenderer::class);
        $errorHandler->registerErrorRenderer('application/json', JsonErrorRenderer::class);
        return $errorHandler;
    }
];
