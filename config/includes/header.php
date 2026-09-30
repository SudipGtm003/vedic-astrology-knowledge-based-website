<?php

declare(strict_types=1);

require_once __DIR__ . '/auth.php';
require_once __DIR__ . '/lang.php';

$pageTitle = $pageTitle ?? SITE_NAME;
$base      = base_path();

$flash = take_flash();

$requestPath = (string) (parse_url((string) ($_SERVER['REQUEST_URI'] ?? '/'), PHP_URL_PATH) ?? '/');
$isHome      = (bool) preg_match('#/(index\.php)?$#', $requestPath);
$isAdminArea = str_contains($requestPath, '/admin/');
$currentFile = basename((string) ($_SERVER['SCRIPT_NAME'] ?? ''));
$currentCat  = (string) ($_GET['category'] ?? '');
$currentSlug = (string) ($_GET['slug'] ?? '');

if ($currentCat === '' && $currentSlug !== '' && !$isAdminArea) {
    $resolved = fetch_column(
        'SELECT c.code FROM topics t JOIN categories c ON c.id = t.category_id WHERE t.slug = :s LIMIT 1',
        [':s' => $currentSlug]
    );
    $currentCat = $resolved !== null ? (string) $resolved : '';
}

$section = '';
if ($isAdminArea) {
    $section = 'admin';
} elseif ($isHome) {
    $section = 'home';
} elseif (in_array($currentFile, ['guide.php', 'learn.php', 'quiz.php'], true)) {
    $section = 'learn';
} elseif ($currentFile === 'combo.php') {
    $section = 'combination';
} elseif ($currentFile === 'mantras.php') {
    $section = 'mantras';
} elseif ($currentFile === 'references.php') {
    $section = 'references';
} elseif ($currentCat !== '') {
    $section = $currentCat === 'panchanga' ? 'panchanga' : 'topics';
}

$topicMenu = [
    ['bhava', 'भाव', 'Bhava'],
    ['rashi', 'राशि', 'Rashi'],
    ['graha', 'ग्रह', 'Graha'],
    ['nakshatra', 'नक्षत्र', 'Nakshatra'],
    ['tithi', 'तिथि', 'Tithi'],
    ['vara', 'वार', 'Vara'],
    ['yoga', 'योग', 'Yoga'],
    ['karana', 'करण', 'Karana'],
    ['ratna', 'रत्न', 'Ratna'],
];

$panchangaMenu = [
    ['tithi', 'तिथि', 'Tithi'],
    ['vara', 'वार', 'Vara'],
    ['nakshatra', 'नक्षत्र', 'Nakshatra'],
    ['yoga', 'योग', 'Yoga'],
    ['karana', 'करण', 'Karana'],
    ['panchanga', 'पञ्चाङ्ग परिचय', 'Panchanga Overview'],
];

$learnMenu = [
    ['guide.php#introduction', 'परिचय', 'Introduction'],
    ['guide.php#basic-concepts', 'आधारभूत अवधारणा', 'Basic Concepts'],
    ['guide.php#fundamentals', 'ज्योतिषको आधार', 'Astrology Fundamentals'],
    ['guide.php#learning-path', 'सिकाइ मार्ग', 'Learning Path'],
];

$referenceMenu = [
    ['references.php#classical', 'शास्त्रीय सिद्धान्त', 'Classical Principles'],
    ['references.php#sanskrit', 'संस्कृत सन्दर्भ', 'Sanskrit References'],
    ['references.php#nepali', 'नेपाली अनुवाद', 'Nepali Translation'],
    ['references.php#english', 'अंग्रेजी व्याख्या', 'English Explanation'],
    ['references.php#remedies', 'वैदिक उपाय', 'Vedic Remedies'],
];

$topicNavCats = fetch_all(
    'SELECT c.code, c.name_np, c.name_en
     FROM categories c
     JOIN topics t ON t.category_id = c.id AND t.is_published = 1
     GROUP BY c.id
     ORDER BY c.sort_order'
);
?>
<!DOCTYPE html>
<html lang="<?= current_lang() === 'en' ? 'en' : 'ne' ?>">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?= e($pageTitle) ?> — <?= e(SITE_NAME) ?></title>
<meta name="description" content="<?= e(SITE_TAGLINE) ?>">
<link rel="icon" type="image/png" href="<?= e($base) ?>public/img/om.png">
<link rel="stylesheet" href="<?= e($base) ?>public/css/style.css?v=<?= e((string) @filemtime(__DIR__ . '/../public/css/style.css')) ?>">
</head>
<body data-lang="<?= e(current_lang()) ?>">

<header class="site-header">
  <div class="container header-inner">

    <a class="brand" href="<?= e($base) ?>index.php">
      <span class="brand-logo brand-emblem">
        <img src="<?= e($base) ?>public/img/ganesh.png" width="26" height="26" alt="">
      </span>
      <span class="brand-text">
        <strong>Vedic Astrology Learn</strong>
        <small>Learn • Explore • Understand</small>
      </span>
    </a>

    <form class="header-search" action="<?= e($base) ?>views/search.php" method="get" role="search">
      <label class="sr-only" for="nav-q"><?= e(bilingual_value('खोज', 'Search')) ?></label>
      <input id="nav-q" type="search" name="q" placeholder="<?= e(bilingual_value('विषय खोज्नुहोस्…', 'Search topics…')) ?>">
      <button type="submit" aria-label="<?= e(bilingual_value('खोज', 'Search')) ?>">
        <svg viewBox="0 0 20 20" width="16" height="16" aria-hidden="true" focusable="false">
          <circle cx="8.5" cy="8.5" r="5.5" fill="none" stroke="currentColor" stroke-width="1.8"/>
          <line x1="12.6" y1="12.6" x2="17" y2="17" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>
        </svg>
      </button>
    </form>

    <button class="nav-toggle" type="button" aria-expanded="false" aria-controls="main-nav"
            aria-label="<?= e(bilingual_value('मेनु खोल्नुहोस्', 'Open menu')) ?>">
      <span></span><span></span><span></span>
    </button>

    <nav class="main-nav" id="main-nav" aria-label="<?= e(bilingual_value('मुख्य मेनु', 'Main navigation')) ?>">

      <div class="nav-item">
        <a class="nav-link<?= $section === 'home' ? ' active' : '' ?>"
           href="<?= e($base) ?>index.php"<?= $section === 'home' ? ' aria-current="page"' : '' ?>>
          <?= e(bilingual_value('गृह', 'Home')) ?>
        </a>
      </div>

      <div class="nav-item">
        <a class="nav-link<?= $section === 'learn' ? ' active' : '' ?>"
           href="<?= e($base) ?>views/guide.php"<?= $section === 'learn' ? ' aria-current="page"' : '' ?>>
          <?= e(bilingual_value('सिकाइ', 'Learn')) ?>
        </a>
        <button class="drop-btn" type="button" aria-expanded="false" aria-controls="nav-learn"
                aria-label="<?= e(bilingual_value('सिकाइ मेनु', 'Learn menu')) ?>"></button>
        <ul class="dropdown" id="nav-learn">
          <?php foreach ($learnMenu as [$href, $np, $en]): ?>
            <li><a href="<?= e($base) ?>views/<?= e($href) ?>"><?= e(bilingual_value($np, $en)) ?></a></li>
          <?php endforeach; ?>
        </ul>
      </div>

      <div class="nav-item">
        <button class="nav-link drop-trigger<?= $section === 'topics' ? ' active' : '' ?>"
                type="button" aria-expanded="false" aria-controls="nav-topics">
          <?= e(bilingual_value('विषय', 'Topics')) ?>
        </button>
        <ul class="dropdown" id="nav-topics">
          <?php foreach ($topicMenu as [$navCode, $np, $en]): ?>
            <li><a href="<?= e($base) ?>views/topic.php?category=<?= e($navCode) ?>"><?= e(bilingual_value($np, $en)) ?></a></li>
          <?php endforeach; ?>
        </ul>
      </div>

      <div class="nav-item">
        <a class="nav-link<?= $section === 'panchanga' ? ' active' : '' ?>"
           href="<?= e($base) ?>views/topic.php?category=panchanga"<?= $section === 'panchanga' ? ' aria-current="page"' : '' ?>>
          <?= e(bilingual_value('पञ्चाङ्ग', 'Panchanga')) ?>
        </a>
        <button class="drop-btn" type="button" aria-expanded="false" aria-controls="nav-panchanga"
                aria-label="<?= e(bilingual_value('पञ्चाङ्ग मेनु', 'Panchanga menu')) ?>"></button>
        <ul class="dropdown" id="nav-panchanga">
          <?php foreach ($panchangaMenu as [$navCode, $np, $en]): ?>
            <li><a href="<?= e($base) ?>views/topic.php?category=<?= e($navCode) ?>"><?= e(bilingual_value($np, $en)) ?></a></li>
          <?php endforeach; ?>
        </ul>
      </div>

      <div class="nav-item">
        <a class="nav-link nav-link-key<?= $section === 'mantras' ? ' active' : '' ?>"
           href="<?= e($base) ?>views/mantras.php"<?= $section === 'mantras' ? ' aria-current="page"' : '' ?>>
          <?= e(bilingual_value('मन्त्र', 'Mantras')) ?>
        </a>
      </div>

      <div class="nav-item">
        <a class="nav-link nav-link-key<?= $section === 'combination' ? ' active' : '' ?>"
           href="<?= e($base) ?>views/combo.php"<?= $section === 'combination' ? ' aria-current="page"' : '' ?>>
          <?= e(bilingual_value('संयोजन विश्लेषण', 'Combination Analysis')) ?>
        </a>
      </div>

      <div class="nav-item">
        <a class="nav-link<?= $section === 'references' ? ' active' : '' ?>"
           href="<?= e($base) ?>views/references.php"<?= $section === 'references' ? ' aria-current="page"' : '' ?>>
          <?= e(bilingual_value('सन्दर्भ', 'References')) ?>
        </a>
        <button class="drop-btn" type="button" aria-expanded="false" aria-controls="nav-references"
                aria-label="<?= e(bilingual_value('सन्दर्भ मेनु', 'References menu')) ?>"></button>
        <ul class="dropdown" id="nav-references">
          <?php foreach ($referenceMenu as [$href, $np, $en]): ?>
            <li><a href="<?= e($base) ?>views/<?= e($href) ?>"><?= e(bilingual_value($np, $en)) ?></a></li>
          <?php endforeach; ?>
        </ul>
      </div>

      <img class="nav-om" src="<?= e($base) ?>public/img/om.png" width="20" height="20" alt="" aria-hidden="true">

    </nav>

    <div class="header-actions">
      <a class="nav-promo" href="<?= e($base) ?>views/mantras.php"
         title="<?= e(bilingual_value('मन्त्र सुन्नुहोस्', 'Listen to mantras')) ?>">
        <span class="nav-promo-new">NEW</span>
        <img src="<?= e($base) ?>public/img/om.png" width="24" height="24" alt="">
        <span class="nav-promo-text">
          <strong><?= e(bilingual_value('मन्त्र सुन्नुहोस्', 'Listen to Mantras')) ?></strong>
          <small><?= e(bilingual_value('नयाँ मन्त्रहरू', 'New mantras')) ?></small>
        </span>
      </a>

      <a class="btn btn-ghost lang-toggle" href="<?= e(lang_toggle_url()) ?>" title="Switch language">
        <?= e(lang_toggle_label()) ?>
      </a>

      <?php if (is_logged_in()): ?>
        <?php if (is_admin()): ?>
          <a class="btn btn-ghost" href="<?= e($base) ?>admin/index.php"><?= e(bilingual_value('एडमिन', 'Admin')) ?></a>
        <?php endif; ?>
        <a class="btn btn-ghost" href="<?= e($base . home_link_for_role()) ?>"><?= e(bilingual_value('मेरो सिकाइ', 'My Learning')) ?></a>
        <a class="btn btn-ghost" href="<?= e($base) ?>profile.php"><?= e(bilingual_value('प्रोफाइल', 'Profile')) ?></a>
        <a class="btn btn-primary" href="<?= e($base) ?>logout.php"><?= e(bilingual_value('लगआउट', 'Logout')) ?></a>
      <?php else: ?>
        <a class="btn btn-primary" href="<?= e($base) ?>login.php">Sign In</a>
      <?php endif; ?>
    </div>

  </div>

  <nav class="topic-nav" aria-label="<?= e(bilingual_value('सबै विषय', 'All topics')) ?>">
    <div class="tnav-track" id="tnav-track">
      <?php foreach ($topicNavCats as $navCat): ?>
        <?php $navCode = (string) $navCat['code']; ?>
        <a class="tnav-link<?= $currentCat === $navCode ? ' active' : '' ?>"
           href="<?= e($base) ?>views/topic.php?category=<?= e($navCode) ?>"
           <?= $currentCat === $navCode ? 'aria-current="page"' : '' ?>><?= e(bilingual_value($navCat['name_np'], $navCat['name_en'])) ?></a>
      <?php endforeach; ?>
    </div>
    <button class="tnav-btn tnav-prev" type="button" hidden
            aria-label="<?= e(bilingual_value('बायाँ स्क्रोल', 'Scroll left')) ?>">
      <svg viewBox="0 0 24 24" width="16" height="16" aria-hidden="true" focusable="false">
        <path d="M15 5l-7 7 7 7" fill="none" stroke="currentColor" stroke-width="2"
              stroke-linecap="round" stroke-linejoin="round"/>
      </svg>
    </button>
    <button class="tnav-btn tnav-next" type="button" hidden
            aria-label="<?= e(bilingual_value('दायाँ स्क्रोल', 'Scroll right')) ?>">
      <svg viewBox="0 0 24 24" width="16" height="16" aria-hidden="true" focusable="false">
        <path d="M9 5l7 7-7 7" fill="none" stroke="currentColor" stroke-width="2"
              stroke-linecap="round" stroke-linejoin="round"/>
      </svg>
    </button>
  </nav>
</header>

<?php if ($flash !== null): ?>
  <div class="container">
    <div class="alert alert-<?= e($flash['type']) ?>">
      <?= e($flash['message']) ?>
    </div>
  </div>
<?php endif; ?>

<main class="container page-body">
