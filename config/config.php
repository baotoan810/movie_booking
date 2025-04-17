<?php
define('BASH_PATH', dirname(__DIR__));
define('DATABASE_PATH', BASH_PATH . '/config/');
define('CONTROLLER_PATH', BASH_PATH . '/controllers/');
define('MODEL_PATH', BASH_PATH . '/models/');
define('VIEW_PATH', BASH_PATH . '/views/');
define('PUBLIC_PATH', BASH_PATH . '/public/');

// Tự động lấy BASE_URL
$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? "https://" : "http://";
$host = $_SERVER['HTTP_HOST'];
$scriptName = str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME']));
$baseUrl = rtrim($protocol . $host . $scriptName, '/') . '/';

define('BASE_URL', $baseUrl);
