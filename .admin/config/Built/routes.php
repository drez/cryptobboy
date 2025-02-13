<?php

namespace App;


/**
 * Backend default routes
 */

use Slim\App;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use ApiGoat\Utility\BuilderLayout;
use ApiGoat\Utility\BuilderMenus;
use ApiGoat\Services\GuiManager;
use ApiGoat\Routes\RouteHelper;

use ApiGoat\Services\EmailService;
use ApiGoat\Services\PasswordService;
use ApiGoat\Services\AccountService;
use ApiGoat\Services\OauthService;

const API_VERSION = '1';
$builderRoutes = require _BASE_DIR . '/config/Built/settings.routes.php';

# Home route
$app->get(_SUB_DIR_URL . '[admin]', function (Request $request, Response $response, $args) {
    $RouteHelper = new RouteHelper($request, $args);
    if (file_exists(_BASE_DIR . 'public/view/welcome.html')) {
        $Layout = new BuilderLayout(new BuilderMenus($RouteHelper->getArgs()));
        $response->getBody()->write($Layout->render(['html' => swheader() . file_get_contents(_BASE_DIR . 'public/view/welcome.html')]));
    } else {
        $Service = new \ApiGoat\Services\WelcomeService($request, $response, $RouteHelper->getArgs());
        $response->getBody()->write($Service->getResponse());
        return $response;
    }

    return $response;
})->setName('Home');

# Authentication request
$app->post(_SUB_DIR_URL . 'Authy/auth', function (Request $request, Response $response, $args) {
    $args['a'] = 'auth';
    $RouteHelper = new RouteHelper($request, $args);
    $Service = new \App\AuthyServiceWrapper($request, $response, $RouteHelper->getArgs());
    return $Service->getResponse();
})->setName('Auth');

# Keep track of users history
$app->post(_SUB_DIR_URL . 'GuiManager', function (Request $request, Response $response, $args) {
    $RouteHelper = new RouteHelper($request, $args);
    $Service = new GuiManager($request, $response, $RouteHelper->getArgs());
    return $Service->getApiResponse();
})->setName('GuiMgr');

# Foreach defined builder routes
# Add post and get
foreach ($builderRoutes['html']['GET'] as $route => $params) {
    $app->get(_SUB_DIR_URL . $route . '[/{a}[/{params:.*}]]', function (Request $request, Response $response, $args) {
        $RouteHelper = new RouteHelper($request, $args);
        $Service = $RouteHelper->getService($response);
        $response->getBody()->write($Service->getResponse());

        if ($Service->request['a'] == 'file') {
            return $response->withHeader('Content-Type', 'application/force-download')
                ->withHeader('Content-Description', 'File Transfer')
                ->withHeader('Content-Transfer-Encoding', 'binary')
                ->withHeader('Content-Disposition', 'attachment; filename="' . $Service->Name . '"')
                ->withHeader('Expires', '0')
                ->withHeader('Cache-Control', 'must-revalidate, post-check=0, pre-check=0')
                ->withHeader('Content-Length', $Service->length);
        } elseif ($Service->request['a'] == 'open') {
            return $response->withHeader('Content-Type', $Service->contentType);
        } else {
            if($Service->contentType){
                $response = $response->withHeader('Content-Type', $Service->contentType);
            }
            if ($Service->headers) {
                foreach($Service->headers as $headers)
                $response = $response->withHeader($headers[0], $headers[1]);
            }
            return $response;
        }
    })->setName($route);
}

foreach ($builderRoutes['html']['POST'] as $route => $params) {
    $app->post(_SUB_DIR_URL . $route . '[/{a}[/{params:.*}]]', function (Request $request, Response $response, $args) {
        $RouteHelper = new RouteHelper($request, $args);
        $Service = $RouteHelper->getService($response);
        $response->getBody()->write($Service->getResponse());
        if($Service->contentType){
            $response = $response->withHeader('Content-Type', $Service->contentType);
        }
        if ($Service->headers) {
            foreach($Service->headers as $headers)
            $response = $response->withHeader($headers[0], $headers[1]);
        }
        return $response;
    })->setName($route);
}

$app->map(['GET', 'POST'], _SUB_DIR_URL . 'oauth/{p}[/{c}]', function (Request $request, Response $response, $args) {
        $RouteHelper = new RouteHelper($request, $args);

        $Service = new OauthService($request, $response, $RouteHelper->getArgs());
        $result = $Service->getResponse();
        if ($result['error']) {
            $response->getBody()->write($result['error']);
        } else {
            return $response->withHeader('Location', _SUB_DIR_URL)->withStatus(301);
        }

        return $response;
    })->setName('oAuth');
# API
$app->options('/api/v' . API_VERSION . '/{routes:.+}', function ($request, $response, $args) {
    return $response;
});

$app->post(_SUB_DIR_URL . 'api/v' . API_VERSION . '/Authy/{a:auth|renew}', function (Request $request, Response $response, $args) {
    $RouteHelper = new RouteHelper($request, $args);
    $RouteHelper->setArgs('method', 'AUTH');
    $Service = new \App\AuthyServiceWrapper($request, $response, $RouteHelper->getArgs());
    return $Service->getApiResponse();
})->setName('api/Auth');

foreach ($builderRoutes['json']['GET'] as $route => $params) {
    $app->map(['GET', 'DELETE', 'PATCH', 'PUT', 'POST'], _SUB_DIR_URL . "api/v" . API_VERSION . "/{$route}[/{a}[/{params:.*}]]", function ($request, $response, $args) {
        $RouteHelper = new RouteHelper($request, $args);
        $Service = $RouteHelper->getService($response);
        return $Service->getApiResponse();
    })->setName('api/' . $route);
}

$app->map(['GET', 'POST'], _SUB_DIR_URL . 'api/v' . API_VERSION . '/ApiGoat/sendEmail[/{i}]', function (Request $request, Response $response, $args) {
    $RouteHelper = new RouteHelper($request, $args);
    $Service = new EmailService($request, $response, $RouteHelper->getArgs());
    return $Service->getApiResponse();
})->setName('sendEmail');

$app->map(['PATCH', 'POST'], _SUB_DIR_URL . 'api/v' . API_VERSION . '/ApiGoat/reset[/{k}]', function (Request $request, Response $response, $args) {
    $RouteHelper = new RouteHelper($request, $args);
    $Service = new PasswordService($request, $response, $RouteHelper->getArgs());
    return $Service->getApiResponse();
})->setName('resetPassword');

$app->map(['GET', 'POST'], _SUB_DIR_URL . 'api/v' . API_VERSION . '/ApiGoat/account[/{i}]', function (Request $request, Response $response, $args) {
    $RouteHelper = new RouteHelper($request, $args);
    $Service = new AccountService($request, $response, $RouteHelper->getArgs());
    return $Service->getApiResponse();
})->setName('resetPassword');

$app->map(['GET', 'POST'], _SUB_DIR_URL . 'api/v' . API_VERSION . '/oauth/{p}[/{c}]', function (Request $request, Response $response, $args) {
    $RouteHelper = new RouteHelper($request, $args);

    $Service = new OauthService($request, $response, $RouteHelper->getArgs());
    return $Service->getApiResponse();
})->setName('oAuth-api');
