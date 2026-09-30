<?php

declare(strict_types=1);

require_once __DIR__ . '/../config/includes/auth.php';

require_admin();

$stats = [
    'users'       => fetch_column('SELECT COUNT(*) FROM users', [], 0),
    'topics'      => fetch_column('SELECT COUNT(*) FROM topics', [], 0),
    'combos'      => (int) fetch_column('SELECT COUNT(*) FROM graha_bhava', [], 0)
                     + (int) fetch_column('SELECT COUNT(*) FROM graha_rashi', [], 0),
    'courses'     => fetch_column('SELECT COUNT(*) FROM courses', [], 0),
];

$recent = fetch_all(
    'SELECT u.name, u.email, u.role, u.created_at
     FROM users u
     ORDER BY u.created_at DESC
     LIMIT 5'
);

$pageTitle = 'एडमिन ड्यासबोर्ड';
require __DIR__ . '/../config/includes/header.php';
?>

<div class="page-head">
  <div class="breadcrumb">एडमिन / ड्यासबोर्ड</div>
  <h1>ड्यासबोर्ड</h1>
  <p class="muted">साइटको समग्र अवस्था हेर्नुहोस्।</p>
</div>

<div class="stat-row">
  <div class="stat">
    <div class="stat-num"><?= e((string) $stats['users']) ?></div>
    <div class="stat-label">कुल प्रयोगकर्ता</div>
  </div>
  <div class="stat">
    <div class="stat-num"><?= e((string) $stats['topics']) ?></div>
    <div class="stat-label">विषय</div>
  </div>
  <div class="stat">
    <div class="stat-num"><?= e((string) $stats['combos']) ?></div>
    <div class="stat-label">संयोजन</div>
  </div>
  <div class="stat">
    <div class="stat-num"><?= e((string) $stats['courses']) ?></div>
    <div class="stat-label">पाठ्यक्रम</div>
  </div>
</div>

<div class="card">
  <h2>हालैका प्रयोगकर्ता</h2>
  <div class="table-wrap">
    <table>
      <thead>
        <tr>
          <th>नाम</th>
          <th>इमेल</th>
          <th>भूमिका</th>
          <th>दर्ता मिति</th>
        </tr>
      </thead>
      <tbody>
        <?php if ($recent === []): ?>
          <tr><td colspan="4" class="muted">कुनै प्रयोगकर्ता छैनन्।</td></tr>
        <?php endif; ?>
        <?php foreach ($recent as $row): ?>
          <tr>
            <td><?= e($row['name']) ?></td>
            <td><?= e($row['email']) ?></td>
            <td>
              <span class="badge badge-<?= e($row['role']) ?>"><?= e($row['role']) ?></span>
            </td>
            <td><?= e(date('Y-m-d H:i', strtotime($row['created_at']))) ?></td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</div>

<?php require __DIR__ . '/../config/includes/footer.php'; ?>
