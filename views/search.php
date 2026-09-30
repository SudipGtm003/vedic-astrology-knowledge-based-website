<?php

declare(strict_types=1);

require_once __DIR__ . '/../config/includes/auth.php';
require_once __DIR__ . '/../config/includes/lang.php';
require_once __DIR__ . '/../config/includes/search.php';

$base   = base_path();
$query  = get('q');
$results = [];

if ($query !== '') {
    $results = run_search($query);
}

$pageTitle = $query !== '' ? 'खोज: ' . $query : 'खोज';
require __DIR__ . '/../config/includes/header.php';
?>

<div class="page-head">
  <h1>खोज</h1>
  <p class="muted">विषय, संयोजन र पाठ्यक्रममा खोज्नुहोस्।</p>
</div>

<form class="search-form" method="get" action="<?= e($base) ?>views/search.php" style="max-width:520px; margin-bottom:1.5rem">
  <input type="search" name="q" value="<?= e($query) ?>" placeholder="खोज शब्द लेख्नुहोस्…" autofocus>
  <button type="submit">खोज्नु</button>
</form>

<?php if ($query === ''): ?>
  <div class="card">
    <p class="muted">खोज्न एउटा शब्द लेख्नुहोस्। उदाहरण: <code>शनि</code>, <code>सप्तम भाव</code>, <code>Saturn</code>, <code>नक्षत्र</code></p>
  </div>

<?php elseif ($results === []): ?>
  <div class="card">
    <p class="muted">"<?php echo e($query); ?>" को लागि कुनै नतिजा भेटिएन।</p>
    <ul class="plain">
      <li>अर्को सानो शब्द प्रयोग गर्नुहोस्</li>
      <li>नेपाली वा अंग्रेजी दुवैमा खोज्न सक्नुहुन्छ</li>
      <li>संस्कृत नामले पनि खोज्न सक्छ (जस्तै: <em>Guru</em>, <em>Karma</em>)</li>
    </ul>
  </div>

<?php else: ?>
  <p class="muted"><?= count($results) ?> नतिजा भेटियो</p>

  <div class="grid grid-2">
    <?php foreach ($results as $r): ?>
      <?php $href = $base . ltrim($r['url'], '/'); ?>
      <a class="card card-link" href="<?= e($href) ?>">
        <span class="tag"><?= e(search_label($r['entity_type'])) ?></span>
        <div class="card-title"><?= e($r['title']) ?></div>
        <div class="muted"><?= e(mb_substr((string) $r['snippet'], 0, 140)) ?>…</div>
      </a>
    <?php endforeach; ?>
  </div>
<?php endif; ?>

<?php require __DIR__ . '/../config/includes/footer.php'; ?>
