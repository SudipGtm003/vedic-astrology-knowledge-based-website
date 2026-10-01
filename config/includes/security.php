<?php

declare(strict_types=1);

function e(?string $value): string
{
    return htmlspecialchars((string) $value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

function post(string $key, string $default = ''): string
{
    $value = $_POST[$key] ?? $default;

    return is_string($value) ? trim($value) : $default;
}

function get(string $key, string $default = ''): string
{
    $value = $_GET[$key] ?? $default;

    return is_string($value) ? trim($value) : $default;
}

function post_int(string $key, int $default = 0): int
{
    return filter_var($_POST[$key] ?? $default, FILTER_VALIDATE_INT) ?: $default;
}

function csrf_token(): string
{
    if (empty($_SESSION[CSRF_TOKEN_NAME])) {
        $_SESSION[CSRF_TOKEN_NAME] = bin2hex(random_bytes(32));
    }

    return $_SESSION[CSRF_TOKEN_NAME];
}

function csrf_field(): string
{
    return '<input type="hidden" name="' . CSRF_TOKEN_NAME . '" value="' . e(csrf_token()) . '">';
}

function csrf_verify(?string $token): bool
{
    return !empty($_SESSION[CSRF_TOKEN_NAME])
        && is_string($token)
        && hash_equals($_SESSION[CSRF_TOKEN_NAME], $token);
}

function require_csrf(): void
{
    if (!csrf_verify($_POST[CSRF_TOKEN_NAME] ?? null)) {
        http_response_code(419);
        exit('Invalid or expired form token. Go back and try again.');
    }
}

function flash(string $type, string $message): void
{
    $_SESSION['flash'] = ['type' => $type, 'message' => $message];
}

function take_flash(): ?array
{
    $flash = $_SESSION['flash'] ?? null;
    unset($_SESSION['flash']);

    return $flash;
}

function redirect(string $path): never
{
    header('Location: ' . $path);
    exit;
}

function is_post(): bool
{
    return ($_SERVER['REQUEST_METHOD'] ?? 'GET') === 'POST';
}

function is_valid_email(string $email): bool
{
    return (bool) filter_var($email, FILTER_VALIDATE_EMAIL);
}

function is_valid_phone_np(string $phone): bool
{
    return (bool) preg_match('/^9[6-9]\d{8}$/', $phone);
}

function client_ip(): string
{
    return substr((string) ($_SERVER['REMOTE_ADDR'] ?? '0.0.0.0'), 0, 45);
}

function log_activity(int $userId, string $action, ?string $entity = null, ?int $entityId = null): void
{
    execute(
        'INSERT INTO activity_log (user_id, action, entity, entity_id, ip_address)
         VALUES (:uid, :action, :entity, :eid, :ip)',
        [
            ':uid'    => $userId,
            ':action' => $action,
            ':entity' => $entity,
            ':eid'    => $entityId,
            ':ip'     => client_ip(),
        ]
    );
}

function redirect_back(string $fallback = 'views/learn.php'): never
{
    $referer = $_SERVER['HTTP_REFERER'] ?? '';
    $host    = $_SERVER['HTTP_HOST'] ?? '';

    if ($referer !== '' && str_contains($referer, $host)) {
        redirect($referer);
    }

    redirect($fallback);
}
