<?php

$settings = require __DIR__ . '/settings.defaults.php';

$dotenv = Dotenv\Dotenv::createImmutable(_BASE_DIR);
$dotenv->load();

return $settings;
