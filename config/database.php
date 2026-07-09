<?php
/**
 * إعدادات الاتصال بقاعدة البيانات
 * يقرأ القيم من ملف .env
 */

function env($key, $default = null) {
    static $vars = null;
    if ($vars === null) {
        $vars = [];
        $path = __DIR__ . '/../.env';
        if (file_exists($path)) {
            foreach (file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) as $line) {
                if (strpos(trim($line), '#') === 0) continue;
                if (strpos($line, '=') === false) continue;
                [$k, $v] = explode('=', $line, 2);
                $vars[trim($k)] = trim($v);
            }
        }
    }
    return $vars[$key] ?? $default;
}

function db(): PDO {
    static $pdo = null;
    if ($pdo === null) {
        $host = env('DB_HOST', '127.0.0.1');
        $name = env('DB_NAME', 'twitter_iraqi');
        $user = env('DB_USER', 'root');
        $pass = env('DB_PASS', '');
        $dsn = "mysql:host={$host};dbname={$name};charset=utf8mb4";
        try {
            $pdo = new PDO($dsn, $user, $pass, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            ]);
        } catch (PDOException $e) {
            die('خطأ بالاتصال مع قاعدة البيانات: ' . $e->getMessage());
        }
    }
    return $pdo;
}
