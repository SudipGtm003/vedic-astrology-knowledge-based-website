<?php

declare(strict_types=1);

require_once __DIR__ . '/../config/includes/auth.php';
require_once __DIR__ . '/../config/includes/lang.php';

$slug = get('slug');
$code = get('category');
$pageCode = $code; 

function topic_artwork(string $catCode, string $slug): ?string
{
    if ($slug === '' || !in_array($catCode, ['rashi', 'nakshatra', 'graha', 'ratna', 'tithi', 'yoga', 'karana'], true)) {
        return null;
    }

    $rel  = 'public/img/' . $catCode . '/' . rawurlencode($slug) . '.png';
    $file = __DIR__ . '/../' . $rel;

    return is_file($file) ? base_path() . $rel : null;
}

function topic_gallery(string $catCode, string $slug): array
{
    if ($slug === '') {
        return [];
    }

    $urls = [];
    for ($i = 1; $i <= 6; $i++) {
        $rel  = 'public/img/' . $catCode . '/' . rawurlencode($slug) . '-' . $i . '.jpg';
        $file = __DIR__ . '/../' . $rel;
        if (is_file($file)) {
            $urls[] = base_path() . $rel;
        }
    }

    return $urls;
}

if ($slug === '' && $code === '') {
    redirect('../index.php');
}

$sidebarRows = fetch_all(
    'SELECT c.id AS cat_id, c.code, c.name_np AS cat_np, c.name_en AS cat_en,
            t.id AS topic_id, t.slug, t.name_np AS topic_np, t.name_en AS topic_en, t.sort_order
     FROM categories c
     LEFT JOIN topics t ON t.category_id = c.id AND t.is_published = 1
     ORDER BY c.sort_order, t.sort_order'
);

$sidebar = [];
foreach ($sidebarRows as $row) {
    $catId = (int) $row['cat_id'];
    $sidebar[$catId] = $sidebar[$catId] ?? [
        'code'   => $row['code'],
        'np'     => $row['cat_np'],
        'en'     => $row['cat_en'],
        'topics' => [],
    ];
    if ($row['topic_id'] !== null) {
        $sidebar[$catId]['topics'][] = [
            'id'   => (int) $row['topic_id'],
            'slug' => $row['slug'],
            'np'   => $row['topic_np'],
            'en'   => $row['topic_en'],
        ];
    }
}

$mode = $slug !== '' ? 'detail' : 'listing';
$category = null;
$topic = null;
$topicContent = null;
$topicArtwork = null;
$topicGallery = [];
$remedies = [];
$related = [];
$listing = [];
$topicQuiz = null;

if ($mode === 'listing') {
    $category = fetch_one('SELECT id, code, name_np, name_en FROM categories WHERE code = :c', [':c' => $code]);

    if ($category === null) {
        http_response_code(404);
        $pageTitle = 'श्रेणी फेला परेन';
        require __DIR__ . '/../config/includes/header.php';
        echo '<div class="page-head"><h1>४०४ — श्रेणी फेला परेन</h1>
              <p class="muted">तपाईंले खोजेको श्रेणी हाम्रो डाटाबेसमा छैन।</p>
              <p><a class="btn btn-primary" href="../index.php">गृह पृष्ठमा फर्कनुहोस्</a></p></div>';
        require __DIR__ . '/../config/includes/footer.php';
        exit;
    }

    $listing = fetch_all(
        'SELECT t.id, t.slug, t.name_np, t.name_en, t.sanskrit_name,
                c.name_np AS cat_np, c.name_en AS cat_en
         FROM topics t
         JOIN categories c ON c.id = t.category_id
         WHERE t.category_id = :cid AND t.is_published = 1
         ORDER BY t.sort_order',
        [':cid' => (int) $category['id']]
    );

    $pageTitle = bilingual_value($category['name_np'], $category['name_en']);
} else {
    $row = fetch_one(
        'SELECT t.id, t.slug, t.name_np, t.name_en, t.sanskrit_name, t.category_id,
                c.code AS cat_code, c.name_np AS cat_np, c.name_en AS cat_en
         FROM topics t
         JOIN categories c ON c.id = t.category_id
         WHERE t.slug = :slug AND t.is_published = 1
         LIMIT 1',
        [':slug' => $slug]
    );

    if ($row === null) {
        http_response_code(404);
        $pageTitle = 'विषय फेला परेन';
        require __DIR__ . '/../config/includes/header.php';
        echo '<div class="page-head"><h1>४०४ — विषय फेला परेन</h1>
              <p class="muted">तपाईंले खोजेको विषय हाम्रो डाटाबेसमा छैन।</p>
              <p><a class="btn btn-primary" href="../index.php">गृह पृष्ठमा फर्कनुहोस्</a></p></div>';
        require __DIR__ . '/../config/includes/footer.php';
        exit;
    }

    $topic        = $row;
    $topicContent = fetch_one('SELECT * FROM topic_content WHERE topic_id = :id', [':id' => (int) $row['id']]);
    $topicArtwork = topic_artwork((string) $row['cat_code'], (string) $row['slug']);
    $topicGallery = topic_gallery((string) $row['cat_code'], (string) $row['slug']);
    $remedies     = fetch_all(
        'SELECT remedy_np, remedy_en FROM topic_remedies WHERE topic_id = :id ORDER BY sort_order',
        [':id' => (int) $row['id']]
    );
    $related = fetch_all(
        'SELECT t2.slug, t2.name_np, t2.name_en
         FROM related_topics rt
         JOIN topics t2 ON t2.id = rt.related_topic_id
         WHERE rt.topic_id = :id AND t2.is_published = 1
         LIMIT 8',
        [':id' => (int) $row['id']]
    );
    $topicQuiz = fetch_one(
        'SELECT question_np, question_en, option_a, option_b, option_c, option_d,
                correct_option, explanation_np
         FROM topic_quizzes
         WHERE topic_id = :id
         LIMIT 1',
        [':id' => (int) $row['id']]
    );
    $pageTitle = bilingual_value($row['name_np'], $row['name_en']);
}

$hideFooter = $mode === 'detail' && $topicQuiz !== null;

$activeTopicId = $topic !== null ? (int) $topic['id'] : 0;
$activeCatCode = $mode === 'listing' ? $pageCode : (string) ($topic['cat_code'] ?? '');

require __DIR__ . '/../config/includes/header.php';
?>

<div class="layout">
  <aside class="sidebar sidebar-scroll-wrap">
    <h4>विषय सूची</h4>

    <form class="search-form" style="margin-bottom:.75rem" onsubmit="return false">
      <input type="search" id="sidebar-filter" placeholder="फिल्टर…" aria-label="Filter topics">
    </form>

    <div class="sidebar-scroll">
    <?php foreach ($sidebar as $catId => $cat): ?>
      <?php if ($cat['topics'] === []) continue;
        $groupOpen = $activeCatCode === $cat['code'];
      ?>
      <ul class="side-group<?= $groupOpen ? ' open' : '' ?>">
        <li>
          <button type="button" class="side-group-head<?= $groupOpen ? ' is-active' : '' ?>"
                  aria-expanded="<?= $groupOpen ? 'true' : 'false' ?>">
            <span><?= e($cat['np']) ?></span>
            <span class="muted"><?= count($cat['topics']) ?></span>
            <svg class="side-caret" viewBox="0 0 12 12" width="10" height="10"
                 aria-hidden="true" focusable="false">
              <path d="M2 4.5l4 4 4-4" fill="none" stroke="currentColor" stroke-width="1.8"
                    stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
          </button>
        </li>
        <li class="side-topics">
          <ul>
            <?php foreach ($cat['topics'] as $t): ?>
              <li data-filter-item>
                <a href="?slug=<?= e($t['slug']) ?>" class="<?= $activeTopicId === $t['id'] ? 'active' : '' ?>">
                  <?= e(bilingual_value($t['np'], $t['en'])) ?>
                </a>
              </li>
            <?php endforeach; ?>
          </ul>
        </li>
      </ul>
    <?php endforeach; ?>
    </div>
  </aside>

  <div class="content">

    <?php if ($mode === 'listing'): ?>
      <div class="page-head">
        <div class="breadcrumb">
          <a href="../index.php">गृह</a> / <?= e($category['name_np']) ?>
        </div>
        <h1><?= e($category['name_np']) ?></h1>
        <p class="muted">
          <?= count($listing) ?> विषय उपलब्ध
        </p>
      </div>

      <?php if ($listing === []): ?>
        <div class="card"><p class="muted">यो श्रेणीमा अहिले कुनै विषय छैन।</p></div>
      <?php endif; ?>

      <div class="grid grid-3">
        <?php foreach ($listing as $t): ?>
          <?php $artwork = topic_artwork($pageCode, (string) $t['slug']); ?>
          <a class="card card-link<?= $artwork !== null ? ' card-artwork' : '' ?>"
             href="?slug=<?= e($t['slug']) ?>">
            <?php if ($artwork !== null): ?>
              <span class="card-artwork-img">
                <img src="<?= e($artwork) ?>" alt="" width="64" height="64" loading="lazy">
              </span>
            <?php endif; ?>
            <?php if ($t['sanskrit_name']): ?>
              <div class="card-sanskrit"><?= e($t['sanskrit_name']) ?></div>
            <?php endif; ?>
            <div class="card-title"><?= e(bilingual_value($t['name_np'], $t['name_en'])) ?></div>
          </a>
        <?php endforeach; ?>
      </div>

    <?php else: ?>

      <div class="page-head<?= $topicArtwork !== null ? ' has-artwork' : '' ?>">
        <?php if ($topicArtwork !== null): ?>
          <img class="page-head-artwork" src="<?= e($topicArtwork) ?>"
               alt="" width="72" height="72">
        <?php endif; ?>
        <div class="breadcrumb">
          <a href="../index.php">गृह</a> /
          <a href="?category=<?= e($topic['cat_code']) ?>"><?= e($topic['cat_np']) ?></a> /
          <?= e($topic['name_np']) ?>
        </div>
        <h1><?= e($topic['name_np']) ?></h1>

        <?php if ($topic['sanskrit_name']): ?>
          <div class="sanskrit-block">
            <span class="lang-hint">संस्कृत नाम</span>
            <strong><?= e($topic['sanskrit_name']) ?></strong>
          </div>
        <?php endif; ?>
      </div>

      <?php if ($topicGallery !== []): ?>
        <div class="card" style="margin-bottom:1rem">
          <h2>रत्नका तस्बिरहरू</h2>
          <div class="topic-gallery">
            <?php foreach ($topicGallery as $galleryUrl): ?>
              <a class="topic-gallery-item" href="<?= e($galleryUrl) ?>" target="_blank" rel="noopener">
                <img src="<?= e($galleryUrl) ?>" alt="<?= e($topic['name_np']) ?>" loading="lazy">
              </a>
            <?php endforeach; ?>
          </div>
        </div>
      <?php endif; ?>

      <?php if ($topicContent === null): ?>
        <div class="card">
          <p class="muted">यो विषयको विवरण अहिले तयार हुँदैछ।</p>
        </div>
      <?php else: ?>

        <?php if (trim((string) $topicContent['summary_np'])): ?>
          <div class="card" style="margin-bottom:1rem">
            <h2>परिचय</h2>
            <?= bilingual($topicContent['summary_np'], $topicContent['summary_en']) ?>
          </div>
        <?php endif; ?>

        <?php if (trim((string) $topicContent['characteristics'])): ?>
          <div class="card" style="margin-bottom:1rem">
            <h2>विशेषताहरू</h2>
            <?= bi_paragraphs($topicContent['characteristics']) ?>
          </div>
        <?php endif; ?>

        <?php if (trim((string) $topicContent['effects'])): ?>
          <div class="card" style="margin-bottom:1rem">
            <h2>प्रभाव</h2>
            <?= bi_paragraphs($topicContent['effects']) ?>
          </div>
        <?php endif; ?>

        <?php if (trim((string) $topicContent['sanskrit_term'])): ?>
          <div class="sanskrit-block">
            <span class="lang-hint">संस्कृत शब्दावली</span>
            <strong><?= e($topicContent['sanskrit_term']) ?></strong>
            <?php if (trim((string) $topicContent['sanskrit_meaning'])): ?>
              <p style="margin:.35rem 0 0"><?= e($topicContent['sanskrit_meaning']) ?></p>
            <?php endif; ?>
          </div>
        <?php endif; ?>

        <?php if (trim((string) $topicContent['classical_reference'])): ?>
          <div class="card" style="margin-bottom:1rem">
            <h2>पारम्परिक स्रोत</h2>
            <p><?= e($topicContent['classical_reference']) ?></p>
          </div>
        <?php endif; ?>

        <?php if ($remedies !== []): ?>
          <div class="card" style="margin-bottom:1rem">
            <h2>उपाय</h2>
            <ul class="plain">
              <?php foreach ($remedies as $r): ?>
                <li><?= e(bilingual_value($r['remedy_np'], $r['remedy_en'])) ?></li>
              <?php endforeach; ?>
            </ul>
          </div>
        <?php endif; ?>

      <?php endif; ?>

      <?php if ($related !== []): ?>
        <div class="card">
          <h2>सम्बन्धित विषय</h2>
          <div class="grid grid-4">
            <?php foreach ($related as $r): ?>
              <a class="card card-link" href="?slug=<?= e($r['slug']) ?>">
                <div class="card-title" style="font-size:.95rem"><?= e(bilingual_value($r['name_np'], $r['name_en'])) ?></div>
              </a>
            <?php endforeach; ?>
          </div>
        </div>
      <?php endif; ?>

    <?php endif; ?>

  </div>
</div>

<?php if ($topicQuiz !== null): ?>
  <section class="topic-quiz" data-topic-quiz
           data-correct="<?= e((string) $topicQuiz['correct_option']) ?>"
           data-explanation="<?= e((string) $topicQuiz['explanation_np']) ?>"
           data-msg-right="<?= e(bilingual_value('सही उत्तर! बधाई छ।', 'Correct answer! Well done.')) ?>"
           data-msg-wrong="<?= e(bilingual_value('गलत उत्तर — सही उत्तर हाइलाइट भयो।', 'Wrong answer — the correct one is highlighted.')) ?>">
    <span class="topic-quiz-badge"><?= e(bilingual_value('विषय क्विज', 'Topic Quiz')) ?></span>
    <h2><?= e(bilingual_value((string) $topicQuiz['question_np'], (string) $topicQuiz['question_en'])) ?></h2>

    <div class="topic-quiz-options">
      <?php foreach (['a', 'b', 'c', 'd'] as $letter): ?>
        <button type="button" data-option="<?= $letter ?>">
          <span class="topic-quiz-letter"><?= strtoupper($letter) ?></span>
          <span class="topic-quiz-text"><?= e((string) $topicQuiz['option_' . $letter]) ?></span>
        </button>
      <?php endforeach; ?>
    </div>

    <div class="topic-quiz-result" hidden>
      <p class="topic-quiz-verdict"></p>
      <p class="topic-quiz-explain"></p>
    </div>
  </section>
<?php endif; ?>

<?php require __DIR__ . '/../config/includes/footer.php'; ?>
