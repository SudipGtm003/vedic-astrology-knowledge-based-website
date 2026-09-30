<?php

declare(strict_types=1);

require_once __DIR__ . '/config/includes/auth.php';

require_login();

$base   = base_path();
$userId = current_user_id();

$user = fetch_one(
    'SELECT name, email, phone_np, password_hash FROM users WHERE id = :id',
    [':id' => $userId]
);

if ($user === null) {
    flash('error', 'खाता भेटिएन।');
    redirect($base . 'logout.php');
}

$errors = [];
$name   = (string) $user['name'];
$email  = (string) $user['email'];
$phone  = (string) ($user['phone_np'] ?? '');

if (is_post()) {
    require_csrf();

    $name    = post('name');
    $email   = post('email');
    $phone   = post('phone_np');
    $current = post('current_password');
    $new     = post('password');
    $confirm = post('password_confirm');

    if (mb_strlen($name) < 3) {
        $errors[] = 'नाम कम्तीमा ३ अक्षरको हुनुपर्छ।';
    }

    if (!is_valid_email($email)) {
        $errors[] = 'सही इमेल ठेगाना दिनुहोस्।';
    } elseif (fetch_column('SELECT id FROM users WHERE email = :e AND id <> :id', [':e' => $email, ':id' => $userId]) !== null) {
        $errors[] = 'यो इमेल अर्को खातामा पहिले नै प्रयोग भइसकेको छ।';
    }

    if ($phone !== '' && !is_valid_phone_np($phone)) {
        $errors[] = 'मोबाइल नम्बर १० अंकको र ९८ बाट सुरु हुनुपर्छ।';
    }

    // नयाँ पासवर्ड खाली छ भने पासवर्ड बदल्दिने छैन
    $changePassword = ($new !== '' || $confirm !== '');

    if ($changePassword) {
        if (!password_verify($current, (string) $user['password_hash'])) {
            $errors[] = 'हालको पासवर्ड गलत छ।';
        }

        if (mb_strlen($new) < PASSWORD_MIN_LEN) {
            $errors[] = 'नयाँ पासवर्ड कम्तीमा ' . PASSWORD_MIN_LEN . ' अक्षरको हुनुपर्छ।';
        } elseif (!preg_match('/[A-Za-z]/', $new) || !preg_match('/\d/', $new)) {
            $errors[] = 'पासवर्डमा अक्षर र अंक दुवै हुनुपर्छ।';
        }

        if ($new !== $confirm) {
            $errors[] = 'नयाँ पासवर्ड दुवै मिल्दैनन्।';
        }
    }

    if ($errors === []) {
        $phoneValue = $phone !== '' ? $phone : null;

        if ($changePassword) {
            execute(
                'UPDATE users SET name = :n, email = :e, phone_np = :p, password_hash = :h WHERE id = :id',
                [
                    ':n'  => $name,
                    ':e'  => $email,
                    ':p'  => $phoneValue,
                    ':h'  => password_hash($new, PASSWORD_DEFAULT),
                    ':id' => $userId,
                ]
            );
        } else {
            execute(
                'UPDATE users SET name = :n, email = :e, phone_np = :p WHERE id = :id',
                [':n' => $name, ':e' => $email, ':p' => $phoneValue, ':id' => $userId]
            );
        }

        $_SESSION['user_name']  = $name;
        $_SESSION['user_email'] = $email;

        log_activity($userId, 'update_profile', 'users', $userId);

        flash('success', 'प्रोफाइल अपडेट भयो।');
        redirect($base . 'profile.php');
    }
}

$pageTitle = 'प्रोफाइल सम्पादन';
require __DIR__ . '/config/includes/header.php';
?>

<div class="auth-wrap">
  <div class="card auth-card">
    <h1>प्रोफाइल सम्पादन</h1>
    <p class="muted">आफ्नो विवरण र पासवर्ड अपडेट गर्नुहोस्।</p>

    <?php if ($errors !== []): ?>
      <div class="alert alert-error">
        <ul>
          <?php foreach ($errors as $err): ?>
            <li><?= e($err) ?></li>
          <?php endforeach; ?>
        </ul>
      </div>
    <?php endif; ?>

    <form method="post" action="edit-profile.php" novalidate>
      <?= csrf_field() ?>

      <label for="name">पूरा नाम</label>
      <input type="text" id="name" name="name" value="<?= e($name) ?>" required minlength="3">

      <label for="email">इमेल ठेगाना</label>
      <input type="email" id="email" name="email" value="<?= e($email) ?>" required>

      <label for="phone_np">मोबाइल नम्बर <span class="muted">(ऐच्छिक)</span></label>
      <input type="tel" id="phone_np" name="phone_np" value="<?= e($phone) ?>" placeholder="98XXXXXXXX" pattern="9[6-9][0-9]{8}">

      <h3 style="margin-top:1.25rem">पासवर्ड परिवर्तन <span class="muted">(ऐच्छिक)</span></h3>

      <label for="current_password">हालको पासवर्ड</label>
      <input type="password" id="current_password" name="current_password" autocomplete="current-password">

      <label for="password">नयाँ पासवर्ड</label>
      <input type="password" id="password" name="password" minlength="8" autocomplete="new-password">
      <small class="muted">कम्तीमा ८ अक्षर, अक्षर र अंक दुवै चाहिन्छ।</small>

      <label for="password_confirm">नयाँ पासवर्ड पुनः टाइप गर्नुहोस्</label>
      <input type="password" id="password_confirm" name="password_confirm" minlength="8" autocomplete="new-password">

      <button type="submit" class="btn btn-primary btn-block">सेभ गर्नुहोस्</button>
    </form>

    <p class="auth-alt"><a href="profile.php">प्रोफाइलमा फर्कनुहोस्</a></p>
  </div>
</div>

<?php require __DIR__ . '/config/includes/footer.php'; ?>
