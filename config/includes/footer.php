<?php

$standalone = !function_exists('base_path');

if ($standalone) {
    require_once __DIR__ . '/auth.php';
    require_once __DIR__ . '/lang.php';
}

$base = $base ?? base_path();

$hideFooter = !empty($hideFooter);

$footerTopics = [
    ['bhava', 'भाव', 'Bhava'],
    ['rashi', 'राशि', 'Rashi'],
    ['graha', 'ग्रह', 'Graha'],
    ['nakshatra', 'नक्षत्र', 'Nakshatra'],
];

$footerLearn = [
    ['views/guide.php', 'सिकाइ मार्ग', 'Learning Guide'],
    ['views/learn.php', 'पाठ्यक्रम', 'Courses'],
    ['views/combo.php', 'संयोजन विश्लेषण', 'Combination Analysis'],
    ['views/references.php', 'सन्दर्भ', 'References'],
    ['views/topic.php?category=panchanga', 'पञ्चाङ्ग परिचय', 'Panchanga Overview'],
];
?>

<?php if ($standalone): ?>
<!DOCTYPE html>
<html lang="<?= current_lang() === 'en' ? 'en' : 'ne' ?>">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?= e(bilingual_value('फुटर पूर्वावलोकन', 'Footer preview')) ?> — <?= e(SITE_NAME) ?></title>
<link rel="stylesheet" href="<?= e($base) ?>public/css/style.css?v=<?= e((string) @filemtime(__DIR__ . '/../public/css/style.css')) ?>">
</head>
<body data-lang="<?= e(current_lang()) ?>">
<main class="container page-body">
  <p class="muted">
    <?= e(bilingual_value(
        'यो फुटरको मात्र पूर्वावलोकन हो — मुख्य साइट index.php बाट खोल्नुहोस्।',
        'This is a footer-only preview — open the main site from index.php.'
    )) ?>
  </p>
</main>
<?php else: ?>
</main>
<?php endif; ?>

<?php if (!$hideFooter): ?>
<footer class="site-footer">
  <img class="footer-watermark" src="<?= e($base) ?>public/img/om.png" alt="" aria-hidden="true">
  <div class="container footer-grid">

    <div class="footer-brand">
      <a class="footer-identity" href="<?= e($base) ?>index.php">
        <img class="footer-logo" src="<?= e($base) ?>public/img/ganesh.png" width="44" height="44" alt="">
        <span class="footer-identity-text">
          <strong><?= e(SITE_NAME) ?></strong>
          <small><?= e(bilingual_value('ज्योतिष सिकाइ मञ्च', 'Jyotish Learning Platform')) ?></small>
        </span>
      </a>

      <p class="footer-tagline">
        <?= e(bilingual_value(
            'नेपालको द्विभाषिक वैदिक ज्योतिष शिक्षा मञ्च — पाठ र अभ्याससहित।',
            'Nepal-focused bilingual Vedic astrology platform — lessons and practice.'
        )) ?>
      </p>

      <div class="footer-actions">
        <a class="footer-btn" href="<?= e(lang_toggle_url()) ?>">
          <svg viewBox="0 0 20 20" width="15" height="15" aria-hidden="true" focusable="false">
            <circle cx="10" cy="10" r="7.2" fill="none" stroke="currentColor" stroke-width="1.5"/>
            <ellipse cx="10" cy="10" rx="3.2" ry="7.2" fill="none" stroke="currentColor" stroke-width="1.5"/>
            <line x1="2.8" y1="10" x2="17.2" y2="10" stroke="currentColor" stroke-width="1.5"/>
          </svg>
          <?= e(lang_toggle_label()) ?>
        </a>

        <a class="footer-btn footer-btn-solid" href="<?= e($base) ?>views/guide.php">
          <?= e(bilingual_value('सिकाइ सुरु गर्नुहोस्', 'Start Learning')) ?>
          <span aria-hidden="true">→</span>
        </a>
      </div>
    </div>

    <nav class="footer-col" aria-labelledby="footer-topics">
      <h4 id="footer-topics"><?= e(bilingual_value('विषयहरू', 'Topics')) ?></h4>
      <ul>
        <?php foreach ($footerTopics as [$footCode, $np, $en]): ?>
          <li>
            <a href="<?= e($base) ?>views/topic.php?category=<?= e($footCode) ?>">
              <?= e(bilingual_value($np, $en)) ?>
            </a>
          </li>
        <?php endforeach; ?>
      </ul>
    </nav>

    <nav class="footer-col" aria-labelledby="footer-learn">
      <h4 id="footer-learn"><?= e(bilingual_value('सिकाइ र स्रोत', 'Learn & Resources')) ?></h4>
      <ul>
        <?php foreach ($footerLearn as [$href, $np, $en]): ?>
          <li>
            <a href="<?= e($base) ?><?= e($href) ?>">
              <?= e(bilingual_value($np, $en)) ?>
            </a>
          </li>
        <?php endforeach; ?>
      </ul>
    </nav>

  </div>

  <div class="footer-bottom">
    <div class="container footer-bottom-inner">
      <span>
        &copy; <?= date('Y') ?> <?= e(SITE_NAME) ?> &middot;
        <?= e(bilingual_value('सबै अधिकार सुरक्षित', 'All rights reserved')) ?>
      </span>
    </div>
  </div>
</footer>
<?php endif; ?>

<button class="back-to-top" type="button"
        aria-label="<?= e(bilingual_value('पृष्ठको माथि जानुहोस्', 'Back to top')) ?>"
        title="<?= e(bilingual_value('माथि जानुहोस्', 'Back to top')) ?>">
  <svg viewBox="0 0 20 20" width="18" height="18" aria-hidden="true" focusable="false">
    <path d="M5 12.5 10 7.5 15 12.5" fill="none" stroke="currentColor"
          stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
  </svg>
</button>

<script src="<?= e($base) ?>public/js/main.js?v=<?= e((string) @filemtime(__DIR__ . '/../public/js/main.js')) ?>"></script>
</body>
</html>
