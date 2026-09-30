<?php

declare(strict_types=1);

require_once __DIR__ . '/security.php';
require_once __DIR__ . '/../db.php';

function attempt_login(string $email, string $password): array
{
    $user = fetch_one(
        'SELECT id, name, email, password_hash, role, is_active FROM users WHERE email = :email LIMIT 1',
        [':email' => $email]
    );

    if ($user === null || !password_verify($password, $user['password_hash'])) {
        return ['ok' => false, 'error' => 'Email or password is incorrect.'];
    }

    if ((int) $user['is_active'] !== 1) {
        return ['ok' => false, 'error' => 'This account has been deactivated.'];
    }

    if (password_needs_rehash($user['password_hash'], PASSWORD_DEFAULT)) {
        execute('UPDATE users SET password_hash = :hash WHERE id = :id', [
            ':hash' => password_hash($password, PASSWORD_DEFAULT),
            ':id'   => $user['id'],
        ]);
    }

    session_regenerate_id(true);

    $_SESSION['user_id']    = (int) $user['id'];
    $_SESSION['user_name']  = $user['name'];
    $_SESSION['user_email'] = $user['email'];
    $_SESSION['user_role']  = $user['role'];
    $_SESSION['created_at'] = time();

    log_activity((int) $user['id'], 'login');

    return ['ok' => true, 'user' => $user];
}

function attempt_register(string $name, string $email, string $phone, string $password, string $confirm): array
{
    $errors = [];

    if (mb_strlen($name) < 3) {
        $errors[] = 'Name must be at least 3 characters.';
    }

    if (!is_valid_email($email)) {
        $errors[] = 'Enter a valid email address.';
    } elseif (fetch_column('SELECT id FROM users WHERE email = :email', [':email' => $email]) !== null) {
        $errors[] = 'That email is already registered.';
    }

    if ($phone !== '' && !is_valid_phone_np($phone)) {
        $errors[] = 'Nepali mobile number must be 10 digits starting with 98.';
    }

    if (mb_strlen($password) < PASSWORD_MIN_LEN) {
        $errors[] = 'Password must be at least ' . PASSWORD_MIN_LEN . ' characters.';
    } elseif (!preg_match('/[A-Za-z]/', $password) || !preg_match('/\d/', $password)) {
        $errors[] = 'Password must contain both letters and numbers.';
    }

    if ($password !== $confirm) {
        $errors[] = 'Passwords do not match.';
    }

    if ($errors !== []) {
        return ['ok' => false, 'errors' => $errors];
    }

    $hash = password_hash($password, PASSWORD_DEFAULT);

    execute(
        'INSERT INTO users (name, email, phone_np, password_hash, role) VALUES (:n, :e, :p, :h, :r)',
        [':n' => $name, ':e' => $email, ':p' => $phone !== '' ? $phone : null, ':h' => $hash, ':r' => 'student']
    );

    $userId = insert_id();
    log_activity($userId, 'register', 'users', $userId);

    return ['ok' => true, 'user_id' => $userId];
}

function attempt_logout(): void
{
    $userId = current_user_id();

    if ($userId !== null) {
        log_activity($userId, 'logout');
    }

    $_SESSION = [];

    if (ini_get('session.use_cookies')) {
        $params = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000, $params['path'], $params['domain'], $params['secure'], $params['httponly']);
    }

    session_destroy();
}

function current_user_id(): ?int
{
    return isset($_SESSION['user_id']) ? (int) $_SESSION['user_id'] : null;
}

function is_logged_in(): bool
{
    return current_user_id() !== null;
}

function current_user_role(): ?string
{
    return $_SESSION['user_role'] ?? null;
}

function is_admin(): bool
{
    return current_user_role() === 'admin';
}

function require_login(): void
{
    if (!is_logged_in()) {
        flash('warning', 'Please sign in to continue.');
        redirect(base_path() . 'login.php');
    }
}

function require_admin(): void
{
    require_login();

    if (!is_admin()) {
        http_response_code(403);
        exit('Access denied. This area is restricted to administrators.');
    }
}

function home_link_for_role(): string
{
    return is_admin() ? 'admin/index.php' : 'views/learn.php';
}
