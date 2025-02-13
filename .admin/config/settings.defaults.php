<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;

// Configure defaults for the whole application.

// Error reporting
error_reporting(E_ALL ^ E_NOTICE ^ E_DEPRECATED ^ E_WARNING);
ini_set('display_errors', true);


// Settings
$settings = [
    'displayErrorDetails'    => true,

    // App Settings
    'app'                    => [
        'api_version'  => 1,
    ],
    'locale' => [
        'path' =>  '/locale',
        'cache' =>  '/locale/cache',
        'locale' => 'en_US',
        'domain' => 'messages',
        // Should be set to false in production
        'debug' => false,
        'supported_locale' => ['en_US', 'fr_CA'],
    ],
    //CORS config
    'cors' => [
        'defaults' => [
            "origin" => "*",
            "methods" => ["GET", "POST", "PUT", "PATCH", "DELETE"],
            "headers.allow" => ["Authorization", "Content-Type"],
            "headers.expose" => [],
            "credentials" => true,
            "cache" => 20,
            "error" => function ($request, $response, $arguments) {
                $data["status"] = "failure";
                $data["message"] = $arguments["message"];
                return $response
                    ->withHeader("Content-Type", "application/json")
                    ->write(json_encode($data, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT));
            }
        ],
        'paths' => [
            'v1/*' => [
                'allowedOrigins' => ['*'],
                'allowedHeaders' => ["Authorization", "If-Match", "If-Unmodified-Since"],
                'allowedMethods' => ["GET", "POST", "PUT", "PATCH", "DELETE"],
                'maxAge' => 3600,
            ]
        ]
    ],
    // jwt settings
    'jwt_middleware'  => [
        'secret' => '9sKjdjuue8sSjwh6',
        'algorithm' => 'HS256',
        'secure' => false,
        'path' => _SUB_DIR_URL . 'api/',
        "ignore" => [_SUB_DIR_URL . 'api/v[0-9]/Authy/auth', _SUB_DIR_URL . 'api/v[0-9]/oauth/[a-z]+'],
        'expire' => "now +8 hours"
    ],
    // Oauth strategies
    'oauth' => [
        'path' => _SUB_DIR_URL . "oauth/",
        'host' => "https://" . $_SERVER['SERVER_NAME'],
        'debug' => true,
        'callback_url' => _SITE_URL . 'oauth/callback',
        'callback_transport' => 'post',
        'security_salt' => '',
        'security_iteration ' => '300',
        'security_timeout' => '2 minutes',
        'Strategy' => [
            'Github' => [
                'client_id' => '',
                'client_secret' => '',

            ],
            'Facebook' => [
                'app_id' => '',
                'app_secret' => ''
            ],
        ],
        'auto_register' => false
    ],
    // API acl config
    'rbac' => [
        'excludes' => []
    ],
    // Error Handling Middleware settings
    'error_handler_middleware' => [
        // Should be set to false in production
        'display_error_details' => true,
        // Parameter is passed to the default ErrorHandler
        // View in rendered output by enabling the "displayErrorDetails" setting.
        // For the console and unit tests we also disable it
        'log_errors' => true,
        // Display error details in error log
        'log_error_details' => true,
    ],
    'assets' => [
        'public_dir' => "",
        'css_dir' => "public/css",
        'js_dir' => "public/js",
        'packages_dir' => "packages",
        'composer_dir' => "",
        'pipeline_dir' => ""
    ],
    'email' => [
        'host' => '',
        'smptauth' => false,
        'username' => '',
        'password' => '',
        'smtp_secure' => PHPMailer::ENCRYPTION_STARTTLS,
        'port' => '587',
        'smtp_debug' => SMTP::DEBUG_SERVER,
        'default_from' => _PROJECT_NAME . '@apigoat.com'
    ],
    'admin_panel' => [
        // top nav icons ['url', 'caption', 'title' ]
        'top_nav' => [
            'profil' => [],
            'support' => [],
            'dashboard' => [],
        ]

    ]
];

$settings['log'] = [
    'facility' => "Variable"
];

// Path settings
$settings['root'] = dirname(__DIR__) . "/..";
$settings['temp'] = $settings['root'] . '/tmp';
$settings['public'] = $settings['root'] . '/public';

return $settings;
