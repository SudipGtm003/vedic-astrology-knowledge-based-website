<?php

declare(strict_types=1);

require_once __DIR__ . '/config/includes/auth.php';

$errors = [];
$email  = '';
$name   = '';

if (is_post()) {
    require_csrf();

    $name    = post('name');
    $email   = post('email');
    $phone   = post('phone_np');
    $pass    = post('password');
    $confirm = post('password_confirm');

    $result = attempt_register($name, $email, $phone, $pass, $confirm);

    if ($result['ok']) {
        flash('success', 'Registration successful. Please sign in.');
        redirect('login.php');
    }

    $errors = $result['errors'];
}

$pageTitle = 'Register';
require __DIR__ . '/config/includes/header.php';
?>

<div class="auth-wrap">
  <div class="card auth-card">
    <h1>Create Account</h1>
    <p class="muted">Create a new account and start learning.</p>

    <?php if ($errors !== []): ?>
      <div class="alert alert-error">
        <ul>
          <?php foreach ($errors as $err): ?>
            <li><?= e($err) ?></li>
          <?php endforeach; ?>
        </ul>
      </div>
    <?php endif; ?>

    <form method="post" action="register.php" novalidate>
      <?= csrf_field() ?>

      <label for="name">Full name</label>
      <input type="text" id="name" name="name" value="<?= e($name) ?>" required minlength="3">

      <label for="email">Email address</label>
      <input type="email" id="email" name="email" value="<?= e($email) ?>" required>

      <label for="phone_np">Mobile number <span class="muted">(optional)</span></label>
      <input type="tel" id="phone_np" name="phone_np" placeholder="98XXXXXXXX" pattern="9[6-9][0-9]{8}">

      <label for="password">Password</label>
      <input type="password" id="password" name="password" required minlength="8">
      <small class="muted">At least 8 characters, with letters and numbers.</small>

      <label for="password_confirm">Confirm password</label>
      <input type="password" id="password_confirm" name="password_confirm" required minlength="8">

      <button type="submit" class="btn btn-primary btn-block">Register</button>
    </form>

    <p class="auth-alt">Already have an account? <a href="login.php">Sign in</a></p>
  </div>
</div>

<?php require __DIR__ . '/config/includes/footer.php'; ?>
