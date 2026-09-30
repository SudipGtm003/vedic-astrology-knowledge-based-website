<?php

declare(strict_types=1);

require_once __DIR__ . '/config/includes/auth.php';

if (is_logged_in()) {
    redirect(home_link_for_role());
}

$error = '';
$email = '';

if (is_post()) {
    require_csrf();

    $email    = post('email');
    $password = post('password');

    if ($email === '' || $password === '') {
        $error = 'Email and password are both required.';
    } else {
        $result = attempt_login($email, $password);

        if ($result['ok']) {
            flash('success', 'स्वागत छ, ' . $result['user']['name'] . '!');
            redirect(home_link_for_role());
        }

        $error = $result['error'];
    }
}

$pageTitle = 'Login';
require __DIR__ . '/config/includes/header.php';
?>

<div class="auth-wrap">
  <div class="card auth-card">
    <h1>Login</h1>
    <p class="muted">Sign in to your account.</p>

    <?php if ($error !== ''): ?>
      <div class="alert alert-error"><?= e($error) ?></div>
    <?php endif; ?>

    <form method="post" action="login.php" novalidate>
      <?= csrf_field() ?>

      <label for="email">Email address</label>
      <input type="email" id="email" name="email" value="<?= e($email) ?>" required autocomplete="email">

      <label for="password">Password</label>
      <input type="password" id="password" name="password" required autocomplete="current-password">

      <button type="submit" class="btn btn-primary btn-block">Sign In</button>
    </form>

    <p class="auth-alt">Forgot password? <a href="forgot.php">Reset password</a></p>
    <p class="auth-alt">Don't have an account? <a href="register.php">Register</a></p>
  </div>
</div>

<?php require __DIR__ . '/config/includes/footer.php'; ?>
