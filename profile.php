<?php

declare(strict_types=1);

require_once __DIR__ . '/config/includes/auth.php';
require_once __DIR__ . '/config/includes/lang.php';

require_login();

$base  = base_path();
$userId = current_user_id();

$user = fetch_one(
    'SELECT id, name, email, phone_np, role, created_at FROM users WHERE id = :id',
    [':id' => (int) $userId]
);

if ($user === null) {
    flash('error', 'Account not found.');
    redirect($base . 'logout.php');
}

$enrolments = fetch_all(
    'SELECT c.slug, c.title_np, c.title_en, e.enrolled_at
       FROM enrollments e
       JOIN courses c ON c.id = e.course_id
      WHERE e.user_id = :id
      ORDER BY e.enrolled_at DESC',
    [':id' => (int) $userId]
);

$pageTitle = bilingual_value('प्रोफाइल', 'Profile');
require __DIR__ . '/config/includes/header.php';
?>

<div class="page-head">
  <h1><?= e(bilingual_value('प्रोफाइल', 'Profile')) ?></h1>
  <p class="muted"><?= e(bilingual_value('तपाईंको खाता र सिकाइको सारांश।', 'Your account and a summary of your learning.')) ?></p>
</div>

<div class="grid grid-2">
  <section class="card">
    <h2><?= e(bilingual_value('खाता विवरण', 'Account details')) ?></h2>

    <div class="table-wrap">
      <table>
        <tbody>
          <tr>
            <th><?= e(bilingual_value('नाम', 'Name')) ?></th>
            <td><?= e($user['name']) ?></td>
          </tr>
          <tr>
            <th><?= e(bilingual_value('इमेल', 'Email')) ?></th>
            <td><?= e($user['email']) ?></td>
          </tr>
          <?php if ($user['phone_np'] !== null && $user['phone_np'] !== ''): ?>
            <tr>
              <th><?= e(bilingual_value('फोन', 'Phone')) ?></th>
              <td><?= e($user['phone_np']) ?></td>
            </tr>
          <?php endif; ?>
          <tr>
            <th><?= e(bilingual_value('भूमिका', 'Role')) ?></th>
            <td>
              <span class="badge <?= $user['role'] === 'admin' ? 'badge-admin' : 'badge-student' ?>">
                <?= e($user['role'] === 'admin' ? bilingual_value('प्रशासक', 'Administrator') : bilingual_value('विद्यार्थी', 'Student')) ?>
              </span>
            </td>
          </tr>
          <tr>
            <th><?= e(bilingual_value('दर्ता मिति', 'Member since')) ?></th>
            <td><?= e(date('Y-m-d', strtotime((string) $user['created_at']))) ?></td>
          </tr>
        </tbody>
      </table>
    </div>

    <p style="margin-top:1.25rem">
      <a class="btn btn-primary" href="<?= e($base . home_link_for_role()) ?>"><?= e(bilingual_value('मेरो सिकाइ', 'My Learning')) ?></a>
      <a class="btn btn-ghost" href="<?= e($base) ?>edit-profile.php"><?= e(bilingual_value('प्रोफाइल सम्पादन', 'Edit Profile')) ?></a>
      <a class="btn btn-ghost" href="<?= e($base) ?>logout.php"><?= e(bilingual_value('लगआउट', 'Logout')) ?></a>
    </p>
  </section>

  <section class="card">
    <h2><?= e(bilingual_value('सिकाइ सारांश', 'Learning summary')) ?></h2>

    <div class="stat-row">
      <div class="stat">
        <div class="stat-num"><?= count($enrolments) ?></div>
        <div class="stat-label"><?= e(bilingual_value('भर्ना भएका पाठ्यक्रम', 'Enrolled courses')) ?></div>
      </div>
    </div>

    <h3><?= e(bilingual_value('भर्ना भएका पाठ्यक्रम', 'Enrolled courses')) ?></h3>
    <?php if ($enrolments === []): ?>
      <p class="muted"><?= e(bilingual_value('अहिलेसम्म कुनै पाठ्यक्रम भर्ना भएको छैन।', 'No courses enrolled yet.')) ?></p>
      <a class="btn btn-ghost btn-sm" href="<?= e($base) ?>views/learn.php"><?= e(bilingual_value('पाठ्यक्रम खोज्नुहोस्', 'Find a course')) ?></a>
    <?php else: ?>
      <ul class="plain">
        <?php foreach ($enrolments as $en): ?>
          <li>
            <a href="<?= e($base) ?>views/learn.php?course=<?= e($en['slug']) ?>">
              <?= e(bilingual_value($en['title_np'], $en['title_en'])) ?>
            </a>
            <span class="muted"> · <?= e(date('Y-m-d', strtotime((string) $en['enrolled_at']))) ?></span>
          </li>
        <?php endforeach; ?>
      </ul>
    <?php endif; ?>
  </section>
</div>

<?php require __DIR__ . '/config/includes/footer.php'; ?>
