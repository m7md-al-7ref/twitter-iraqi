<?php
session_start();
date_default_timezone_set('Asia/Baghdad');

$root = dirname(__DIR__);

require $root . '/config/database.php';
require $root . '/app/Helpers/auth.php';
require $root . '/app/Helpers/Router.php';

// Autoload الموديلات والكونترولرز
spl_autoload_register(function ($class) use ($root) {
    $paths = [
        $root . "/app/Models/{$class}.php",
        $root . "/app/Controllers/{$class}.php",
        $root . "/app/Services/{$class}.php",
    ];
    foreach ($paths as $path) {
        if (file_exists($path)) {
            require $path;
            return;
        }
    }
});

$router = new Router();
require $root . '/routes/web.php';

// نطرح الجزء الخاص بمجلد public من الرابط (يفيد إذا شغّلنا بسيرفر فيه سب فولدر)
$uri = $_SERVER['REQUEST_URI'];
$scriptDir = str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME']));
if ($scriptDir !== '/' && strpos($uri, $scriptDir) === 0) {
    $uri = substr($uri, strlen($scriptDir));
}

$router->dispatch($_SERVER['REQUEST_METHOD'], $uri);
