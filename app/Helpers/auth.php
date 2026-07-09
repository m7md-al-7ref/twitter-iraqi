<?php

function currentUser(): ?array
{
    if (!isset($_SESSION['user_id'])) return null;
    static $cached = null;
    if ($cached === null) {
        $cached = User::find($_SESSION['user_id']);
    }
    return $cached;
}

function isLoggedIn(): bool
{
    return isset($_SESSION['user_id']);
}

function requireAuth(): void
{
    if (!isLoggedIn()) {
        redirect('/login');
    }
}

function redirect(string $path): void
{
    header('Location: ' . url($path));
    exit;
}

function url(string $path = ''): string
{
    $base = rtrim(env('APP_URL', ''), '/');
    return $base . '/' . ltrim($path, '/');
}

function csrfToken(): string
{
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

function verifyCsrf(): bool
{
    $token = $_POST['_token'] ?? '';
    return hash_equals($_SESSION['csrf_token'] ?? '', $token);
}

function e(string $str): string
{
    return htmlspecialchars($str, ENT_QUOTES, 'UTF-8');
}

/** وقت نسبي بالعربي زي "قبل 5 دقائق" */
function timeAgo(string $datetime): string
{
    $timestamp = strtotime($datetime);
    $diff = time() - $timestamp;

    if ($diff < 60) return 'هسه';
    if ($diff < 3600) return 'قبل ' . floor($diff / 60) . ' د';
    if ($diff < 86400) return 'قبل ' . floor($diff / 3600) . ' س';
    if ($diff < 2592000) return 'قبل ' . floor($diff / 86400) . ' يوم';
    return date('Y/m/d', $timestamp);
}
