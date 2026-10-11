<?php

declare(strict_types=1);

require_once __DIR__ . '/config/includes/auth.php';
require_once __DIR__ . '/config/includes/mail.php';

if (is_logged_in()) {
    redirect(home_link_for_role());
}

if (!is_post()) {
    unset($_SESSION['reset_user_id'], $_SESSION['reset_email']);
}

$base  = base_path();
$error = '';
$email = '';

if (is_post()) {
    require_csrf();

    $step = post('step');

    if ($step === 'send') {
        unset($_SESSION['reset_user_id'], $_SESSION['reset_email']);

        $email = post('email');

        if (!is_valid_email($email)) {
            $error = 'सही इमेल ठेगाना लेख्नुहोस्।';
        } else {
            $row = fetch_one('SELECT id FROM users WHERE email = :e LIMIT 1', [':e' => $email]);

            if ($row === null) {
                $error = 'यो इमेलमा दर्ता भएको खाता भेटिएन।';
            } else {
                $userId = (int) $row['id'];
                $otp    = (string) random_int(100000, 999999);

                execute(
                    'UPDATE users SET otp_hash = :h, otp_expires_at = DATE_ADD(NOW(), INTERVAL 10 MINUTE) WHERE id = :id',
                    [':h' => password_hash($otp, PASSWORD_DEFAULT), ':id' => $userId]
                );

                if (send_otp_email($email, $otp)) {
                    $_SESSION['reset_user_id'] = $userId;
                    $_SESSION['reset_email']   = $email;
                } else {
                    $error = 'इमेल पठाउन सकिएन। केही समयपछि पुनः प्रयास गर्नुहोस्।';
                }
            }
        }
    }

    if ($step === 'reset') {
        $userId  = $_SESSION['reset_user_id'] ?? null;
        $otp     = post('otp');
        $new     = post('password');
        $confirm = post('password_confirm');

        if ($userId === null) {
            $error = 'पहिले इमेलमा आएको OTP मागिएको छ।';
        } elseif (!preg_match('/^\d{6}$/', $otp)) {
            $error = 'OTP ६ अंकको हुनुपर्छ।';
        } elseif (mb_strlen($new) < PASSWORD_MIN_LEN) {
            $error = 'पासवर्ड कम्तीमा ' . PASSWORD_MIN_LEN . ' अक्षरको हुनुपर्छ।';
        } elseif (!preg_match('/[A-Za-z]/', $new) || !preg_match('/\d/', $new)) {
            $error = 'पासवर्डमा अक्षर र अंक दुवै हुनुपर्छ।';
        } elseif ($new !== $confirm) {
            $error = 'पासवर्ड दुवै मिल्दैनन्।';
        } else {
            $otpRow = fetch_one(
                'SELECT otp_hash, otp_expires_at FROM users WHERE id = :id',
                [':id' => $userId]
            );

            $otpOk = $otpRow !== null
                && $otpRow['otp_hash'] !== null
                && password_verify($otp, (string) $otpRow['otp_hash'])
                && $otpRow['otp_expires_at'] !== null
                && strtotime((string) $otpRow['otp_expires_at']) >= time();

            if (!$otpOk) {
                $error = 'OTP गलत वा म्याद सकिएको छ। फेरि पठाउनुहोस्।';
            } else {
                execute(
                    'UPDATE users SET password_hash = :h, otp_hash = NULL, otp_expires_at = NULL WHERE id = :id',
                    [':h' => password_hash($new, PASSWORD_DEFAULT), ':id' => $userId]
                );

                log_activity((int) $userId, 'reset_password', 'users', (int) $userId);
                unset($_SESSION['reset_user_id'], $_SESSION['reset_email']);

                flash('success', 'Password changed. Please sign in.');
                redirect('login.php');
            }
        }
    }
}

$showOtp   = isset($_SESSION['reset_user_id']);
$resetMail = (string) ($_SESSION['reset_email'] ?? '');

$pageTitle = 'पासवर्ड रिसेट';
require __DIR__ . '/config/includes/header.php';
?>

<div class="auth-wrap">
  <div class="card auth-card">

    <?php if (!$showOtp): ?>
      <h1>पासवर्ड बिर्सनुभयो?</h1>
      <p class="muted">दर्ता भएको इमेल ठेगाना लेख्नुहोस् — उहाँको इमेलमा ६ अंकको OTP पठाइनेछ।</p>

      <?php if ($error !== ''): ?>
        <div class="alert alert-error"><?= e($error) ?></div>
      <?php endif; ?>

      <form method="post" action="forgot.php" novalidate>
        <?= csrf_field() ?>
        <input type="hidden" name="step" value="send">

        <label for="email">इमेल ठेगाना</label>
        <input type="email" id="email" name="email" value="<?= e($email) ?>" required autocomplete="email">

        <button type="submit" class="btn btn-primary btn-block">OTP पठाउनुहोस्</button>
      </form>

      <p class="auth-alt">पासवर्ड याद छ? <a href="login.php">लगइन गर्नुहोस्</a></p>

    <?php else: ?>
      <h1>OTP प्रमाणित गर्नुहोस्</h1>
      <p class="muted"><?= e($resetMail) ?> मा ६ अंकको OTP पठाइएको छ। १० मिनेटभित्र प्रयोग गर्नुहोस्।</p>

      <?php if ($error !== ''): ?>
        <div class="alert alert-error"><?= e($error) ?></div>
      <?php endif; ?>

      <form method="post" action="forgot.php" novalidate>
        <?= csrf_field() ?>
        <input type="hidden" name="step" value="reset">

        <label for="otp">OTP</label>
        <input type="text" id="otp" name="otp" inputmode="numeric" pattern="[0-9]{6}" maxlength="6"
               required autocomplete="one-time-code" placeholder="123456">

        <label for="password">नयाँ पासवर्ड</label>
        <input type="password" id="password" name="password" required minlength="8" autocomplete="new-password">
        <small class="muted">कम्तीमा ८ अक्षर, अक्षर र अंक दुवै चाहिन्छ।</small>

        <label for="password_confirm">नयाँ पासवर्ड पुनः टाइप गर्नुहोस्</label>
        <input type="password" id="password_confirm" name="password_confirm" required minlength="8" autocomplete="new-password">

        <button type="submit" class="btn btn-primary btn-block">पासवर्ड राख्नुहोस्</button>
      </form>

      <form method="post" action="forgot.php" novalidate>
        <?= csrf_field() ?>
        <input type="hidden" name="step" value="send">
        <input type="hidden" name="email" value="<?= e($resetMail) ?>">
        <button type="submit" class="btn btn-ghost btn-block">OTP फेरि पठाउनुहोस्</button>
      </form>

      <p class="auth-alt"><a href="forgot.php">अर्को इमेल प्रयोग गर्नुहोस्</a></p>
    <?php endif; ?>

  </div>
</div>

<?php require __DIR__ . '/config/includes/footer.php'; ?>
