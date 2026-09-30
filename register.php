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
        flash('success', 'दर्ता सफल भयो। अब लगइन गर्नुहोस्।');
        redirect('login.php');
    }

    $errors = $result['errors'];
}

$pageTitle = 'दर्ता';
require __DIR__ . '/config/includes/header.php';
?>

<div class="auth-wrap">
  <div class="card auth-card">
    <h1>दर्ता गर्नुहोस्</h1>
    <p class="muted">नयाँ खाता बनाउनुहोस् र पाठ्यक्रम सिक्न सुरु गर्नुहोस्।</p>

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

      <label for="name">पूरा नाम</label>
      <input type="text" id="name" name="name" value="<?= e($name) ?>" required minlength="3">

      <label for="email">इमेल ठेगाना</label>
      <input type="email" id="email" name="email" value="<?= e($email) ?>" required>

      <label for="phone_np">मोबाइल नम्बर <span class="muted">(ऐच्छिक)</span></label>
      <input type="tel" id="phone_np" name="phone_np" placeholder="98XXXXXXXX" pattern="9[6-9][0-9]{8}">

      <label for="password">पासवर्ड</label>
      <input type="password" id="password" name="password" required minlength="8">
      <small class="muted">कम्तीमा ८ अक्षर, अक्षर र अंक दुवै चाहिन्छ।</small>

      <label for="password_confirm">पासवर्ड पुनः टाइप गर्नुहोस्</label>
      <input type="password" id="password_confirm" name="password_confirm" required minlength="8">

      <button type="submit" class="btn btn-primary btn-block">दर्ता गर्नुहोस्</button>
    </form>

    <p class="auth-alt">पहिले नै खाता छ? <a href="login.php">लगइन गर्नुहोस्</a></p>
  </div>
</div>

<?php require __DIR__ . '/config/includes/footer.php'; ?>
