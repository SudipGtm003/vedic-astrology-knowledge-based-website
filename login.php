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
        $error = 'इमेल र पासवर्ड दुवै आवश्यक छ।';
    } else {
        $result = attempt_login($email, $password);

        if ($result['ok']) {
            flash('success', 'स्वागत छ, ' . $result['user']['name'] . '!');
            redirect(home_link_for_role());
        }

        $error = $result['error'];
    }
}

$pageTitle = 'लगइन';
require __DIR__ . '/config/includes/header.php';
?>

<div class="auth-wrap">
  <div class="card auth-card">
    <h1>लगइन</h1>
    <p class="muted">आफ्नो खातामा प्रवेश गर्नुहोस्।</p>

    <?php if ($error !== ''): ?>
      <div class="alert alert-error"><?= e($error) ?></div>
    <?php endif; ?>

    <form method="post" action="login.php" novalidate>
      <?= csrf_field() ?>

      <label for="email">इमेल ठेगाना</label>
      <input type="email" id="email" name="email" value="<?= e($email) ?>" required autocomplete="email">

      <label for="password">पासवर्ड</label>
      <input type="password" id="password" name="password" required autocomplete="current-password">

      <button type="submit" class="btn btn-primary btn-block">लगइन गर्नुहोस्</button>
    </form>

    <p class="auth-alt">खाता छैन? <a href="register.php">दर्ता गर्नुहोस्</a></p>
  </div>
</div>

<?php require __DIR__ . '/config/includes/footer.php'; ?>
