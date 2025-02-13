<?php

use ApiGoat\Sessions\AuthySession;

ini_set('default_charset', 'utf-8');
//require __DIR__ . '/Built/config.php';
set_include_path(_BASE_DIR . "/src/" . PATH_SEPARATOR . get_include_path());
require __DIR__ . '/Built/propel.php';
require _VENDOR_DIR . 'apigoat/runtime/src/Utility/Legacy/html_helper.php';
require _VENDOR_DIR . 'apigoat/runtime/src//Utility/Legacy/std_function.php';

if (session_status() === PHP_SESSION_NONE) {
    session_name('ApiGoat');
    session_start();
}

if (!isset($_SESSION[_AUTH_VAR]) || !is_object($_SESSION[_AUTH_VAR]) || (get_class($_SESSION[_AUTH_VAR]) != 'ApiGoat\Sessions\AuthySession')) {
    unset($_SESSION[_AUTH_VAR]);
    $_SESSION[_AUTH_VAR] = new AuthySession();
}

if (!empty($_SESSION[_AUTH_VAR]->sessVar['Timezone'])) {
    date_default_timezone_set($_SESSION[_AUTH_VAR]->sessVar['Timezone']);
}

require _BASE_DIR . 'config/Built/config.db.php';

setlocale(LC_NUMERIC, 'en_CA');
setlocale(LC_ALL, "en_US");
putenv('LC_ALL=en_US');
define('_LOCAL_LC', 'en_US');
bindtextdomain("messages", _BASE_DIR . "locale");
textdomain("messages");
