<?php

namespace App;

ini_set('memory_limit', '128M');

if (php_sapi_name() != 'cli') {
    $subdir_url = str_replace((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off' ? 'https' : 'http').'://' . $_SERVER['SERVER_NAME'], '', "https://gc.local/cryptobboy/.admin/") ;
} else {
    $subdir_url = "";
}

$project_root = "/var/www/gc/p/cryptobboy/.admin/";

$defines = [
    "_DATA_SRC" => "cryptobboy",
    "_PROJECT_NAME" => "cryptobboy",
    "_PROJECT_PRFX" => "",
    "API_VERSION" => "1",
    "_DEPLOYMENT_TYPE" => "Standalone",
    "_SYSTEM_USER" => "web1",
    "_SITE_TITLE" => "",
    "_SUB_DIR_URL" => $subdir_url,	 # Routes prefix
    "_ASSET_RELATIVE_PATH" => "",
    "_BASE_DIR" => realpath("/var/www/gc/p/cryptobboy/.admin/").DIRECTORY_SEPARATOR, 
    "_AUTH_VAR" => "09389f9c0d",
    "_CRYPT_KEY" => "d6439cb6cff515c5",
    "_CRYPT_IV" => "9ecbfcff6051c4ee",
];

$locales = [
    LC_MONETARY => 'en_CA.UTF-8',
    LC_NUMERIC => 'en_CA.UTF-8',
    LC_TIME => 'en_CA.UTF-8'
];

if(!isset($skipConfig)){
    foreach($defines as $define => $val){
        define($define, $val);
    }

    if (php_sapi_name() != 'cli') {
            define("_SITE_URL", "https://" . $_SERVER['SERVER_NAME'] . _SUB_DIR_URL);
    } else {
        define("_SITE_URL", "");
    }
    
    define("_SRC_URL", _SITE_URL);

    define("_INSTALL_PATH", "/var/www/gc/p/cryptobboy/.admin/");
    define("_VENDOR_DIR", _BASE_DIR . "vendor/");

    define("_PROPEL_BASE_PATH", _VENDOR_DIR . "propel/propel1/");
    define("_PROPEL_RUNTIME_PATH", _PROPEL_BASE_PATH . 'runtime');
    define("_PEAR_LOG_PATH", _PROPEL_RUNTIME_PATH);
    define("_PROPEL_GEN", _PROPEL_BASE_PATH . "generator/bin/propel-gen");

    foreach($locales as $locale => $val){
        setlocale($locale, $val);
    }
}
