<?php

declare(strict_types=1);

require_once __DIR__ . '/config/includes/auth.php';

if (is_post()) {
    require_csrf();
    attempt_logout();
    flash('success', 'सफलतापूर्वक बाहिर निस्कियो।');
    redirect('login.php');
}

attempt_logout();
redirect('views/learn.php');
