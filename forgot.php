<?php

declare(strict_types=1);

require_once __DIR__ . '/config/includes/auth.php';

if (is_logged_in()) {
    redirect(home_link_for_role());
}

// GET मा फेरि सुरु गर्ने
if (!is_post()) {
    unset($_SESSION['reset_user_id']);
}

$base  = base_path();
$error = '';
$email = '';
$phone = '';

if (is_post()) {
    require_csrf();

    $step = post('step');

    // चरण १ : इमेल + फोन मिलाउने
    if ($step === 'verify') {
        unset($_SESSION['reset_user_id']);

        $email = post('email');
        $phone = post('phone_np');

        if ($email === '' || $phone === '') {
            $error = 'इमेल र फोन नम्बर दुवै आवश्यक छ।';
        } else {
            $row = fetch_one(
                'SELECT id FROM users WHERE email = :e AND phone_np = :p LIMIT 1',
                [':e' => $email, ':p' => $phone]
            );

            if ($row === null) {
                $error = 'इमेल र फोन नम्बर मिलेन। पुनः जाँच गर्नुहोस्।';
            } else {
                // मिल्यो — अब नयाँ पासवर्ड राख्न दिने
                $_SESSION['reset_user_id'] = (int) $row['id'];
            }
        }
    }

    // चरण २ : नयाँ पासवर्ड राख्ने
    if ($step === 'reset') {
        $userId  = $_SESSION['reset_user_id'] ?? null;
        $new     = post('password');
        $confirm = post('password_confirm');

        if ($userId === null) {
            $error = 'पहिले इमेल र फोन नम्बर प्रमाणित गर्नुहोस्।';
        } elseif (mb_strlen($new) < PASSWORD_MIN_LEN) {
            $error = 'पासवर्ड कम्तीमा ' . PASSWORD_MIN_LEN . ' अक्षरको हुनुपर्छ।';
        } elseif (!preg_match('/[A-Za-z]/', $new) || !preg_match('/\d/', $new)) {
            $error = 'पासवर्डमा अक्षर र अंक दुवै हुनुपर्छ।';
        } elseif ($new !== $confirm) {
            $error = 'पासवर्ड दुवै मिल्दैनन्।';
        } else {
            execute(
                'UPDATE users SET password_hash = :h WHERE id = :id',
                [':h' => password_hash($new, PASSWORD_DEFAULT), ':id' => $userId]
            );

            log_activity((int) $userId, 'reset_password', 'users', (int) $userId);
            unset($_SESSION['reset_user_id']);

            flash('success', 'Password changed. Please sign in.');
            redirect('login.php');
        }
    }
}

$showReset = isset($_SESSION['reset_user_id']);

$pageTitle = 'पासवर्ड रिसेट';
require __DIR__ . '/config/includes/header.php';
?>

<div class="auth-wrap">
  <div class="card auth-card">

    <?php if (!$showReset): ?>
      <h1>पासवर्ड बिर्सनुभयो?</h1>
      <p class="muted">दर्ता भएको इमेल र फोन नम्बर मिलाउनुहोस्।</p>

      <?php if ($error !== ''): ?>
        <div class="alert alert-error"><?= e($error) ?></div>
      <?php endif; ?>

      <form method="post" action="forgot.php" novalidate>
        <?= csrf_field() ?>
        <input type="hidden" name="step" value="verify">

        <label for="email">इमेल ठेगाना</label>
        <input type="email" id="email" name="email" value="<?= e($email) ?>" required autocomplete="email">

        <label for="phone_np">मोबाइल नम्बर</label>
        <input type="tel" id="phone_np" name="phone_np" value="<?= e($phone) ?>" required placeholder="98XXXXXXXX">

        <button type="submit" class="btn btn-primary btn-block">जाँच गर्नुहोस्</button>
      </form>

      <p class="auth-alt">पासवर्ड याद छ? <a href="login.php">लगइन गर्नुहोस्</a></p>

    <?php else: ?>
      <h1>नयाँ पासवर्ड</h1>
      <p class="muted">इमेल र फोन नम्बर मिल्यो। अब नयाँ पासवर्ड राख्नुहोस्।</p>

      <?php if ($error !== ''): ?>
        <div class="alert alert-error"><?= e($error) ?></div>
      <?php endif; ?>

      <form method="post" action="forgot.php" novalidate>
        <?= csrf_field() ?>
        <input type="hidden" name="step" value="reset">

        <label for="password">नयाँ पासवर्ड</label>
        <input type="password" id="password" name="password" required minlength="8" autocomplete="new-password">
        <small class="muted">कम्तीमा ८ अक्षर, अक्षर र अंक दुवै चाहिन्छ।</small>

        <label for="password_confirm">नयाँ पासवर्ड पुनः टाइप गर्नुहोस्</label>
        <input type="password" id="password_confirm" name="password_confirm" required minlength="8" autocomplete="new-password">

        <button type="submit" class="btn btn-primary btn-block">पासवर्ड राख्नुहोस्</button>
      </form>

      <p class="auth-alt"><a href="forgot.php">अर्को इमेल / फोन प्रयोग गर्ने</a></p>
    <?php endif; ?>

  </div>
</div>

<?php require __DIR__ . '/config/includes/footer.php'; ?>
