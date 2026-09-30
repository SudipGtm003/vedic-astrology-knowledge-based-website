<?php

declare(strict_types=1);

require_once __DIR__ . '/../config/includes/auth.php';
require_once __DIR__ . '/../config/includes/search.php';

require_admin();

$base = base_path();

$count = null;

if (is_post()) {
    require_csrf();
    $count = rebuild_search_index();
    flash('success', 'खोज इन्डेक्स पुनर्निर्माण भयो — ' . $count . ' प्रविष्टि।');
    redirect(base_path() . 'admin/search-rebuild.php');
}

$total = (int) fetch_column('SELECT COUNT(*) FROM search_index');
$last  = fetch_one('SELECT created_at FROM search_index LIMIT 1');

$breakdown = fetch_all(
    'SELECT entity_type, COUNT(*) AS n FROM search_index GROUP BY entity_type ORDER BY n DESC'
);

$pageTitle = 'खोज इन्डेक्स';
require __DIR__ . '/../config/includes/header.php';
?>

<div class="page-head">
  <div class="breadcrumb"><a href="index.php">एडमिन</a> / इन्डेक्स</div>
  <h1>खोज इन्डेक्स</h1>
  <p class="muted">
    खोज प्रणालीले <code>search_index</code> तालिकाबाट नतिजा दिन्छ।
    विषय वा पाठ्यक्रम थपेपछि / हटेपछि इन्डेक्स अद्यावधिक गर्नुपर्छ।
  </p>
</div>

<div class="stat-row">
  <div class="stat"><div class="stat-num"><?= e((string) $total) ?></div><div class="stat-label">कुल प्रविष्टि</div></div>
  <div class="stat"><div class="stat-num"><?= e((string) (int) fetch_column('SELECT COUNT(*) FROM search_index WHERE entity_type = "topic"')) ?></div><div class="stat-label">विषय</div></div>
  <div class="stat"><div class="stat-num"><?= e((string) (int) fetch_column('SELECT COUNT(*) FROM search_index WHERE entity_type = "combo"')) ?></div><div class="stat-label">संयोजन</div></div>
  <div class="stat"><div class="stat-num"><?= e((string) (int) (fetch_column('SELECT COUNT(*) FROM search_index WHERE entity_type IN ("course","lesson")') ?? 0)) ?></div><div class="stat-label">पाठ/पाठ्यक्रम</div></div>
</div>

<div class="card" style="margin-bottom:1rem">
  <h2>पुनर्निर्माण</h2>
  <p class="muted">
    तालिका खाली पारी विषय, संयोजन, पाठ्यक्रम र पाठबाट पुनः भरिन्छ।
    परिवर्तन गरेपछि यो निश्चयपूर्वक चलाउनुहोस्।
  </p>

    <form method="post" action="<?= e($base) ?>admin/search-rebuild.php" data-confirm="खोज इन्डेक्स पूर्ण रूपमा पुनर्निर्माण गर्ने हो?">
    <?= csrf_field() ?>
    <button type="submit" class="btn btn-primary">इन्डेक्स पुनर्निर्माण गर्नुहोस्</button>
  </form>
</div>

<div class="card">
  <h2>इन्डेक्स विवरण</h2>
  <div class="table-wrap">
    <table>
      <thead>
        <tr><th>प्रकार</th><th>प्रविष्टि संख्या</th></tr>
      </thead>
      <tbody>
        <?php if ($breakdown === []): ?>
          <tr><td colspan="2" class="muted">इन्डेक्स खाली छ। माथि बटन थिच्नुहोस्।</td></tr>
        <?php endif; ?>
        <?php foreach ($breakdown as $b): ?>
          <tr>
            <td><?= e(search_label($b['entity_type'])) ?> <span class="muted">(<?= e($b['entity_type']) ?>)</span></td>
            <td><?= e((string) $b['n']) ?></td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</div>

<?php require __DIR__ . '/../config/includes/footer.php'; ?>
