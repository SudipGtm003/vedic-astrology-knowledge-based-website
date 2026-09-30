<?php

declare(strict_types=1);

require_once __DIR__ . '/../config/includes/auth.php';
require_once __DIR__ . '/../config/includes/lang.php';

$base = base_path();

$catMeta = [
    'mantra'  => ['np' => 'मन्त्र',  'en' => 'Mantras'],
    'aarati'  => ['np' => 'आरती',    'en' => 'Aarti'],
    'chalisa' => ['np' => 'चालीसा',  'en' => 'Chalisa'],
    'naya'    => ['np' => 'नयाँ मन्त्र', 'en' => 'New Mantras'],
];

function mantra_artwork(string $slug, string $base): string
{
    static $map = [
        
        'saraya-manatara'        => 'public/img/graha/surya.png',
        'canatharama-manatara'   => 'public/img/graha/chandra.png',
        'magal-manatara'         => 'public/img/graha/mangala.png',
        'bthha-manatara'         => 'public/img/graha/budha.png',
        'bhasapata-manatara'     => 'public/img/graha/guru.png',
        'shakara-manatara'       => 'public/img/graha/shukra.png',
        'shana-manatara'         => 'public/img/graha/shani.png',
        'raha-manatara'          => 'public/img/graha/rahu.png',
        'kata-manatara'          => 'public/img/graha/ketu.png',
        
        'mashha-rashaka-manatara'       => 'public/img/rashi/mesha.png',
        'vashha-rashaka-manatara'       => 'public/img/rashi/vrishabha.png',
        'mathana-rashaka-manatara'      => 'public/img/rashi/mithuna.png',
        'karakata-rashaka-manatara'     => 'public/img/rashi/karka.png',
        'saha-rashaka-manatara'         => 'public/img/rashi/simha.png',
        'kanaya-rashaka-manatara'       => 'public/img/rashi/kanya.png',
        'tal-rashaka-manatara'          => 'public/img/rashi/tula.png',
        'vashacaka-rashaka-manatara'    => 'public/img/rashi/vrishchika.png',
        'thhana-rashaka-manatara'       => 'public/img/rashi/dhanu.png',
        'makara-rashaka-manatara'       => 'public/img/rashi/makara.png',
        'kamabha-rashaka-manatara'      => 'public/img/rashi/kumbha.png',
        'mana-rashaka-manatara'         => 'public/img/rashi/meena.png',
    ];

    return $base . ($map[$slug] ?? 'public/img/om.png');
}

$cat = (string) ($_GET['cat'] ?? '');
if (!isset($catMeta[$cat])) {
    $cat = '';
}
$slug = trim((string) ($_GET['m'] ?? ''));

$detail      = null;
$detailParas = [];
$groups      = [];
$naya        = [];
$counts      = [];

if ($slug !== '') {
    $detail = fetch_one('SELECT * FROM mantras WHERE slug = :s', [':s' => $slug]);

    if ($detail === null) {
        http_response_code(404);
    } else {
        $detailParas = json_decode((string) $detail['paras'], true);
        if (!is_array($detailParas)) {
            $detailParas = [];
        }
        $pageTitle = (string) $detail['title_np'];
    }
} else {
    foreach (fetch_all('SELECT cat_code, COUNT(*) AS n FROM mantras GROUP BY cat_code') as $row) {
        $counts[(string) $row['cat_code']] = (int) $row['n'];
    }

    if ($cat === '') {
        
        $naya = fetch_all('SELECT * FROM mantras WHERE is_new = 1 ORDER BY sort_order');
    } else {
        $current = [];
        foreach (fetch_all(
            'SELECT * FROM mantras WHERE cat_code = :c ORDER BY sort_order, id',
            [':c' => $cat]
        ) as $row) {
            $current[] = $row;
        }

        foreach ($current as $row) {
            $g = (string) $row['grp'];
            if (!isset($groups[$g])) {
                $groups[$g] = [];
            }
            $groups[$g][] = $row;
        }
    }
}

if (!isset($pageTitle)) {
    $pageTitle = bilingual_value('मन्त्र', 'Mantras');
}
require __DIR__ . '/../config/includes/header.php';
?>

<div class="page-head has-artwork">
  <img class="page-head-artwork" src="<?= e($base) ?>public/img/om.png" alt="ॐ" width="88" height="88">
  <div class="breadcrumb">
    <a href="<?= e($base) ?>index.php"><?= e(bilingual_value('गृह', 'Home')) ?></a> /
    <?= e(bilingual_value('मन्त्र', 'Mantras')) ?>
    <?php if ($slug !== '' && $detail !== null): ?>
      / <a href="<?= e($base) ?>views/mantras.php?cat=<?= e((string) $detail['cat_code']) ?>"><?= e($catMeta[(string) $detail['cat_code']]['np']) ?></a> /
      <?= e($detail['title_np']) ?>
    <?php elseif ($cat !== ''): ?>
      / <?= e($catMeta[$cat]['np']) ?>
    <?php endif; ?>
  </div>

  <?php if ($slug !== '' && $detail !== null): ?>
    <h1><?= e($detail['title_np']) ?></h1>
    <p class="muted">
      <?= e($catMeta[(string) $detail['cat_code']]['np']) ?>
      <?php if ((string) $detail['grp'] !== '' && $detail['grp'] !== $detail['title_np']): ?>
        &middot; <?= e($detail['grp']) ?>
      <?php endif; ?>
      <?php if ((int) $detail['is_new'] === 1): ?>
        &middot; <span class="mantra-badge">नयाँ</span>
      <?php endif; ?>
    </p>
  <?php else: ?>
    <h1><?= e(bilingual_value('मन्त्र संग्रह', 'Mantra Collection')) ?></h1>
    <p class="muted">
      <?= e(bilingual_value(
          'मन्त्र, आरती र चालीसाको संग्रह — मन्त्र मूल पाठको रूपमा राखिएका छन्, व्याख्या आफ्नै शब्दमा लेखिएको छ।',
          'A collection of mantras, aarti and chalisa — mantra text is kept verbatim, explanations are in our own words.'
      )) ?></p>
  <?php endif; ?>
</div>

<?php if ($slug !== '' && $detail === null): ?>
  <div class="card"><p class="muted">यो मन्त्र फेला परेन।</p>
    <p><a class="btn btn-primary" href="<?= e($base) ?>views/mantras.php"><?= e(bilingual_value('मन्त्र संग्रहमा फर्कनुहोस्', 'Back to Mantras')) ?></a></p>
  </div>

<?php elseif ($slug !== ''): ?>

  <?php if ((string) $detail['intro_np'] !== ''): ?>
    <div class="card" style="margin-bottom:1.25rem">
      <p class="muted" style="margin:0"><?= e($detail['intro_np']) ?></p>
    </div>
  <?php endif; ?>

  <div class="card mantra-detail">
    <?php
      $detailArt = mantra_artwork((string) $detail['slug'], '');
      if ($detailArt !== 'public/img/om.png'):
    ?>
      <div class="mantra-detail-art">
        <img src="<?= e($base . $detailArt) ?>" alt="" width="96" height="96" loading="lazy">
      </div>
    <?php endif; ?>

    <?php if ($detailParas === []): ?>
      <p class="muted">यो मन्त्रको पाठ अहिले उपलब्ध छैन।</p>
    <?php endif; ?>

    <?php foreach ($detailParas as $block): ?>
      <?php
        $label = (string) ($block['label'] ?? '');
        $lines = (array) ($block['lines'] ?? []);
      ?>
      <section class="mantra-block">
        <?php if ($label !== ''): ?>
          <h2 class="mantra-label"><?= e($label) ?></h2>
        <?php endif; ?>
        <div class="mantra-lines">
          <?php foreach ($lines as $line): ?>
            <p><?= e((string) $line) ?></p>
          <?php endforeach; ?>
        </div>
      </section>
    <?php endforeach; ?>
  </div>

  <?php if ((int) $detail['is_new'] === 1): ?>
    <p class="muted small" style="margin-top:.9rem">नयाँ मन्त्र — हाम्रो आफ्नै संकलनबाट थपिएको।</p>
  <?php endif; ?>

  <p style="margin-top:1rem">
    <a class="btn btn-ghost" href="<?= e($base) ?>views/mantras.php?cat=<?= e((string) $detail['cat_code']) ?>">◀ <?= e(bilingual_value('श्रेणीमा फर्कनुहोस्', 'Back to category')) ?></a>
    <a class="btn btn-ghost" href="<?= e($base) ?>views/mantras.php"><?= e(bilingual_value('मन्त्र संग्रह', 'Mantra Collection')) ?></a>
  </p>

<?php elseif ($cat === ''): ?>

  <section style="margin-bottom:1.75rem">
    <h2 class="section-title"><span class="dot"></span><?= e(bilingual_value('नयाँ मन्त्र', 'New Mantras')) ?></h2>
    <p class="muted" style="margin-top:-.4rem">
      <?= e(bilingual_value('संग्रहमा नयाँ थपिएका मन्त्रहरू।', 'Recently added mantras in the collection.')) ?>
    </p>

    <div class="grid grid-3">
      <?php foreach ($naya as $row): ?>
        <a class="card card-link card-artwork" href="?m=<?= e($row['slug']) ?>">
          <span class="card-artwork-img">
            <img src="<?= e($base) ?>public/img/om.png" alt="" width="64" height="64" loading="lazy">
          </span>
          <div class="card-title"><?= e($row['title_np']) ?></div>
          <div class="muted"><?= e($row['grp']) ?></div>
        </a>
      <?php endforeach; ?>

      <?php if ($naya === []): ?>
        <div class="card"><p class="muted">अहिले नयाँ मन्त्र छैन।</p></div>
      <?php endif; ?>
    </div>
  </section>

  <section>
    <h2 class="section-title"><span class="dot"></span><?= e(bilingual_value('श्रेणीहरू', 'Categories')) ?></h2>

    <div class="grid grid-3">
      <?php foreach ($catMeta as $code => $meta): ?>
        <?php if ($code === 'naya') { continue; } ?>
        <a class="card card-link card-artwork" href="?cat=<?= e($code) ?>">
          <span class="card-artwork-img">
            <img src="<?= e($base) ?>public/img/om.png" alt="" width="64" height="64" loading="lazy">
          </span>
          <div class="card-title"><?= e(bilingual_value($meta['np'], $meta['en'])) ?></div>
          <div class="muted"><?= (int) ($counts[$code] ?? 0) ?> <?= e(bilingual_value('मन्त्र', 'items')) ?></div>
        </a>
      <?php endforeach; ?>
    </div>
  </section>

<?php else: ?>

  <div class="mantra-toolbar">
    <input id="mantra-filter" type="search" placeholder="<?= e(bilingual_value('यस श्रेणीमा खोज्नुहोस्…', 'Search in this category…')) ?>"
           aria-label="<?= e(bilingual_value('मन्त्र खोज्नुहोस्', 'Search mantras')) ?>">
    <span class="muted"><?= (int) ($counts[$cat] ?? 0) ?> <?= e(bilingual_value('मन्त्र', 'mantras')) ?></span>
  </div>

  <?php foreach ($groups as $gname => $rows): ?>
    <section class="mantra-group" data-mantra-group>
      <?php if ($gname !== ''): ?>
        <h2 class="section-title"><span class="dot"></span><?= e($gname) ?></h2>
      <?php endif; ?>

      <div class="grid grid-3">
        <?php foreach ($rows as $row): ?>
          <a class="card card-link card-artwork" data-mantra-item href="?m=<?= e($row['slug']) ?>">
            <span class="card-artwork-img">
              <img src="<?= e(mantra_artwork((string) $row['slug'], $base)) ?>"
                   alt="" width="64" height="64" loading="lazy">
            </span>
            <div class="card-title"><?= e($row['title_np']) ?></div>
          </a>
        <?php endforeach; ?>
      </div>
    </section>
  <?php endforeach; ?>

  <?php if ($groups === []): ?>
    <div class="card"><p class="muted">यो श्रेणीमा मन्त्र छैन।</p></div>
  <?php else: ?>
    <div class="card" id="mantra-empty" hidden><p class="muted">मेल खाने मन्त्र भेटिएन।</p></div>
  <?php endif; ?>

<?php endif; ?>

<?php require __DIR__ . '/../config/includes/footer.php'; ?>
