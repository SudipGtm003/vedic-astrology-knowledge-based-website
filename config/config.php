<?php

declare(strict_types=1);

const DB_HOST = 'localhost';
const DB_NAME = 'vedic_astrology_learn';
const DB_USER = 'root';
const DB_PASS = '';

const SITE_NAME    = 'Vedic Astrology Learn';
const SITE_TAGLINE = 'Nepal-focused bilingual Jyotish learning platform';
const DEFAULT_LANG = 'np';

const SESSION_NAME     = 'val_session';
const SESSION_LIFETIME = 7200;
const CSRF_TOKEN_NAME  = '_csrf';
const PASSWORD_MIN_LEN = 8;

date_default_timezone_set('Asia/Kathmandu');

define('ROOT_DIR', dirname(__DIR__));

function base_path(): string
{
    $script = str_replace('\\', '/', dirname((string) ($_SERVER['SCRIPT_FILENAME'] ?? '')));
    $root   = str_replace('\\', '/', ROOT_DIR);
    $rel    = trim(str_replace($root, '', $script), '/');

    if ($rel === '') {
        return '';
    }

    return str_repeat('../', substr_count($rel, '/') + 1);
}

if (session_status() === PHP_SESSION_NONE) {
    session_name(SESSION_NAME);
    session_set_cookie_params([
        'lifetime' => SESSION_LIFETIME,
        'path'     => '/',
        'httponly' => true,
        'samesite' => 'Lax',
        'secure'   => !empty($_SERVER['HTTPS']),
    ]);
    session_start();
}

if (!isset($_SESSION['created_at'])) {
    $_SESSION['created_at'] = time();
} elseif (time() - $_SESSION['created_at'] > SESSION_LIFETIME) {
    session_unset();
    session_destroy();
    session_start();
    $_SESSION['created_at'] = time();
    $_SESSION['flash'] = ['type' => 'warning', 'message' => 'Session expired. Please sign in again.'];
}
