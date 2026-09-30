<?php

declare(strict_types=1);

require_once __DIR__ . '/config/includes/auth.php';

$categories = fetch_all(
    'SELECT id, code, name_np, name_en FROM categories ORDER BY sort_order'
);

$counts = [];
foreach (fetch_all('SELECT category_id, COUNT(*) AS total FROM topics GROUP BY category_id') as $row) {
    $counts[(int) $row['category_id']] = (int) $row['total'];
}

$pageTitle = 'गृह';
require __DIR__ . '/config/includes/header.php';
?>

<div class="page-head">
  <h1>Learn Vedic Astrology</h1>
  <p class="muted">
    विषय छान्नुहोस् र व्यवस्थित रूपमा अध्ययन गर्नुहोस्। संस्कृत शब्दावली मूल रूपमा राखिएको छ।
  </p>
</div>

<div class="grid grid-3">
  <?php foreach ($categories as $cat): ?>
    <a class="card card-link" href="views/topic.php?category=<?= e($cat['code']) ?>">
      <div class="card-sanskrit"><?= e($cat['name_en']) ?></div>
      <div class="card-title"><?= e($cat['name_np']) ?></div>
      <div class="muted"><?= e((string) ($counts[(int) $cat['id']] ?? 0)) ?> विषय</div>
    </a>
  <?php endforeach; ?>
</div>

<div class="grid grid-2" style="margin-top:2rem">
  <a class="card card-link" href="views/combo.php">
    <div class="card-title">संयोजन विश्लेषण</div>
    <p class="muted">ग्रह + भाव अथवा ग्रह + राशि छानेर विस्तृत व्याख्या हेर्नुहोस्।</p>
  </a>
</div>

<?php require __DIR__ . '/config/includes/footer.php'; ?>
