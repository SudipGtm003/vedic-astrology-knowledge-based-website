<?php

declare(strict_types=1);

require_once __DIR__ . '/../config/includes/auth.php';
require_once __DIR__ . '/../config/includes/lang.php';
require_once __DIR__ . '/../config/includes/course.php';

// पाठको पाठ्य-सामग्री: तालिका, सूची, शीर्षक र साधारण प्याराग्राफ छुट्याएर देखाउँछ।
function lesson_links(string $escaped): string
{
    return preg_replace('/\[([^\]]+)\]\(([^()\s]+)\)/', '<a href="$2">$1</a>', $escaped) ?? $escaped;
}

function lesson_table(array $rows): string
{
    $head = '';
    $body = '';

    foreach (array_values($rows) as $i => $row) {
        $cells = array_map('trim', explode('|', $row));

        if ($i === 0) {
            foreach ($cells as $cell) {
                $head .= '<th>' . lesson_links(e($cell)) . '</th>';
            }
            continue;
        }

        $body .= '<tr>';
        foreach ($cells as $cell) {
            $body .= '<td>' . lesson_links(e($cell)) . '</td>';
        }
        $body .= '</tr>';
    }

    return '<div class="table-wrap"><table><thead><tr>' . $head . '</tr></thead><tbody>'
        . $body . '</tbody></table></div>';
}

function lesson_body(string $text): string
{
    $lines = array_filter(array_map('trim', preg_split('/\r\n|\r|\n+/', $text) ?: []));

    if ($lines === []) {
        return '<p class="muted">उपलब्ध छैन।</p>';
    }

    $groups = [];
    foreach ($lines as $line) {
        $type = str_contains($line, ' | ')
            ? 'table'
            : (str_starts_with($line, '• ') ? 'bullet' : 'text');

        if ($groups === [] || $groups[count($groups) - 1]['type'] !== $type) {
            $groups[] = ['type' => $type, 'lines' => []];
        }
        $groups[count($groups) - 1]['lines'][] = $type === 'bullet' ? substr($line, strlen('• ')) : $line;
    }

    $html = '';
    foreach ($groups as $group) {
        if ($group['type'] === 'table') {
            $html .= lesson_table($group['lines']);
            continue;
        }

        if ($group['type'] === 'bullet') {
            $html .= '<ul class="plain"><li>';
            $html .= implode('</li><li>', array_map(
                fn (string $li): string => lesson_links(e($li)),
                $group['lines']
            ));
            $html .= '</li></ul>';
            continue;
        }

        foreach ($group['lines'] as $line) {
            $numbered = preg_match('/^[0-9०-९]+\.\s/u', $line) === 1;
            $isHeading = mb_strlen($line) <= 60
                && !str_contains($line, '।')
                && !str_starts_with($line, '→')
                && ($numbered || (!str_contains($line, ':') && !str_contains($line, ' — ')));

            $html .= $isHeading
                ? '<h4>' . lesson_links(e($line)) . '</h4>'
                : '<p>' . lesson_links(e($line)) . '</p>';
        }
    }

    return $html;
}

$base = base_path();

$courseSlug = get('course');
$lessonSlug = get('lesson');
$mode       = $lessonSlug !== '' ? 'lesson' : ($courseSlug !== '' ? 'course' : 'catalog');

if (is_post()) {
    require_csrf();

    $action = post('action');

    if ($action === 'complete') {
        require_login();

        $course = course_by_slug(post('course'));
        $lesson = post_int('lesson_id');

        if ($course === null || $lesson <= 0) {
            redirect($base . 'views/learn.php');
        }

        execute(
            'INSERT INTO lesson_progress (user_id, lesson_id, is_completed, completed_at)
             VALUES (:u, :l, 1, NOW())
             ON DUPLICATE KEY UPDATE is_completed = 1, completed_at = NOW()',
            [':u' => (int) current_user_id(), ':l' => $lesson]
        );

        log_activity((int) current_user_id(), 'lesson_complete', 'lessons', $lesson);

        flash('success', 'पाठ पूरा भयो।');

        $lessonRow = fetch_one('SELECT slug FROM lessons WHERE id = :id', [':id' => $lesson]);

        redirect(
            $base . 'views/learn.php?course=' . $course['slug']
            . ($lessonRow !== null ? '&lesson=' . $lessonRow['slug'] : '')
        );
    }
}

$course     = course_by_slug($courseSlug);
$userId     = current_user_id();
$enrolled   = false;
$stats      = ['total' => 0, 'done' => 0, 'percent' => 0];
$lessons    = [];
$lesson     = null;

if ($course !== null) {
    // लगइन भएकालाई कोर्स खोल्दै नै स्वतः भर्ना — प्रगति ट्र्याक गर्न
    if ($userId !== null && !is_enrolled($userId, (int) $course['id'])) {
        enroll_user($userId, (int) $course['id']);
        log_activity($userId, 'enroll', 'courses', (int) $course['id']);
    }

    $enrolled = $userId !== null && is_enrolled($userId, (int) $course['id']);
    $lessons  = course_lessons((int) $course['id'], $userId);

    if ($enrolled) {
        $stats = course_stats((int) $course['id'], $userId);
    }

    if ($mode === 'lesson') {
        $lesson = lesson_by_slug((int) $course['id'], $lessonSlug);
    }
}

if ($mode !== 'catalog' && $course === null) {
    http_response_code(404);
    $pageTitle = 'पाठ्यक्रम फेला परेन';
    require __DIR__ . '/../config/includes/header.php';
    echo '<div class="page-head"><h1>४०४ — पाठ्यक्रम फेला परेन</h1>
          <p class="muted">तपाईंले खोजेको पाठ्यक्रम हाम्रो डाटाबेसमा छैन।</p>
          <p><a class="btn btn-primary" href="' . e($base) . 'views/learn.php">सबै पाठ्यक्रम हेर्नुहोस्</a></p></div>';
    require __DIR__ . '/../config/includes/footer.php';
    exit;
}

if ($mode === 'lesson' && $lesson === null) {
    http_response_code(404);
    $pageTitle = 'पाठ फेला परेन';
    require __DIR__ . '/../config/includes/header.php';
    echo '<div class="page-head"><h1>४०४ — पाठ फेला परेन</h1>
          <p class="muted">तपाईंले खोजेको पाठ उपलब्ध छैन।</p>
          <p><a class="btn btn-primary" href="' . e($base) . 'views/learn.php?course=' . e($courseSlug) . '">पाठ्यक्रममा फर्कनुहोस्</a></p></div>';
    require __DIR__ . '/../config/includes/footer.php';
    exit;
}

if ($mode === 'lesson') {
    $pageTitle = bilingual_value($lesson['title_np'], $lesson['title_en']);
} elseif ($mode === 'course') {
    $pageTitle = bilingual_value($course['title_np'], $course['title_en']);
} else {
    $pageTitle = 'ज्योतिष सिक्नुहोस्';
}

$allCourses = fetch_all(
    'SELECT id, slug, title_np, title_en, description
     FROM courses WHERE is_published = 1 AND slug <> \'jyotish-siknuhos\' ORDER BY id'
);

$learnCards = [
    ['📖', 'कुण्डली कसरी पढ्ने', 'सुरुदेखि — आधारभूत प्रक्रिया र क्रम।', 'kundali-kasari-padhne'],
    ['♈', '१२ राशि', 'प्रत्येकको स्वभाव, स्वामी, र विशेषताहरू।', 'rashi-parichay'],
    ['⭐', '२७ नक्षत्र', 'चन्द्रको आकाशीय गृह — नाम, स्वामी, विषयवस्तु।', 'nakshatra-parichay'],
    ['🪐', '९ ग्रह', 'सूर्यदेखि केतुसम्म — मनोविज्ञान र महत्त्व।', 'graha-parichay'],
    ['🏠', '१२ भाव', 'जीवनका १२ क्षेत्र — कसरी पढ्ने।', 'bhava-parichay'],
    ['🕉️', 'पञ्चाङ्ग', 'तिथि, नक्षत्र, योग, करण, वार।', 'panchanga-parichay'],
    ['⏳', 'विंशोत्तरी दशा', '९ ग्रहीय अवधिको १२० वर्षे चक्र।', 'vimshottari-dasha'],
    ['✨', 'मुख्य योगहरू', 'गजकेसरी, राज, धन, र अरू महत्त्वपूर्ण योग।', 'mukhya-yogaharu'],
    ['👁️', 'दृष्टि', 'ग्रहहरू अरू भावलाई कसरी हेर्छन्।', 'drishti'],
    ['🔑', 'विशेष अवधारणा', 'उच्च, नीच, अस्त, वक्री, स्व-राशि — सबै।', 'vishesh-avdharana'],
];

require __DIR__ . '/../config/includes/header.php';
?>

<?php if ($mode === 'catalog'): ?>

  <div class="page-head">
    <h1>ज्योतिष सिक्नुहोस्</h1>
    <p class="muted">तल दिइएका हरेक खण्डले कुण्डलीको एउटा महत्त्वपूर्ण पाटो छुट्टै सिकाउँछ। क्रमशः पढ्नुहोस् — सजिलैसँग वैदिक ज्योतिषको आधार बुझ्न सकिनेछ।</p>
  </div>

  <div class="grid grid-4">
    <?php foreach ($learnCards as $card): ?>
      <a class="card card-link" href="?course=jyotish-siknuhos&lesson=<?= e($card[3]) ?>">
        <div class="card-emoji"><?= e($card[0]) ?></div>
        <div class="card-title"><?= e($card[1]) ?></div>
        <p class="muted"><?= e($card[2]) ?></p>
      </a>
    <?php endforeach; ?>
  </div>

  <div class="page-head" style="margin-top:2.5rem">
    <h2>पाठ्यक्रमहरू</h2>
    <p class="muted">व्यवस्थित पाठ र क्विजसहितको पाठ्यक्रम।</p>
  </div>

  <?php if ($allCourses === []): ?>
    <div class="card"><p class="muted">अहिले कुनै पाठ्यक्रम उपलब्ध छैन।</p></div>
  <?php endif; ?>

  <div class="grid grid-2">
    <?php foreach ($allCourses as $c): ?>
      <?php
        $cEnrolled = $userId !== null && is_enrolled($userId, (int) $c['id']);
        $cStats    = $cEnrolled ? course_stats((int) $c['id'], (int) $userId) : null;
      ?>
      <a class="card card-link" href="?course=<?= e($c['slug']) ?>">
        <div class="card-title"><?= e(bilingual_value($c['title_np'], $c['title_en'])) ?></div>
        <p class="muted"><?= e(bilingual_value($c['description'], null)) ?></p>
        <?php if ($cStats !== null): ?>
          <div class="muted"><?= (int) $cStats['done'] ?>/<?= (int) $cStats['total'] ?> पाठ पूरा — <?= (int) $cStats['percent'] ?>%</div>
        <?php endif; ?>
      </a>
    <?php endforeach; ?>
  </div>

<?php else: ?>

<div class="layout">
  <aside class="sidebar">
    <h4><?= e(bilingual_value($course['title_np'], $course['title_en'])) ?></h4>

    <?php if ($enrolled): ?>
      <p class="muted" style="margin-bottom:.5rem"><?= (int) $stats['done'] ?>/<?= (int) $stats['total'] ?> पाठ पूरा</p>
      <div class="progress-bar"><span style="width:<?= (int) $stats['percent'] ?>%"></span></div>
    <?php endif; ?>

    <ul>
      <?php foreach ($lessons as $l): ?>
        <li data-filter-item>
          <a href="?course=<?= e($course['slug']) ?>&lesson=<?= e($l['slug']) ?>"
             class="<?= $lesson !== null && (int) $lesson['id'] === (int) $l['id'] ? 'active' : '' ?>">
            <?php if (!empty($l['is_completed'])): ?><span class="badge badge-on">✓</span> <?php endif; ?>
            <?= e(bilingual_value($l['title_np'], $l['title_en'])) ?>
          </a>
        </li>
      <?php endforeach; ?>
    </ul>

    <p style="margin-top:1rem"><a href="<?= e($base) ?>views/learn.php" class="btn btn-ghost btn-sm">← सबै पाठ्यक्रम</a></p>
  </aside>

  <div class="content">

    <?php if ($mode === 'course'): ?>

      <div class="page-head">
        <div class="breadcrumb">
          <a href="<?= e($base) ?>views/learn.php">पाठ्यक्रम</a> /
          <?= e(bilingual_value($course['title_np'], $course['title_en'])) ?>
        </div>
        <h1><?= e(bilingual_value($course['title_np'], $course['title_en'])) ?></h1>
        <p class="muted"><?= count($lessons) ?> पाठ</p>
      </div>

      <?php if (trim((string) $course['description'])): ?>
        <div class="card" style="margin-bottom:1rem">
          <?= bi_paragraphs($course['description'], false) ?>
        </div>
      <?php endif; ?>

      <div class="card">
        <h2>पाठहरू</h2>
        <div class="grid grid-2">
          <?php foreach ($lessons as $i => $l): ?>
            <a class="card card-link" href="?course=<?= e($course['slug']) ?>&lesson=<?= e($l['slug']) ?>">
              <div class="card-index"><?= $i + 1 ?></div>
              <div class="card-title" style="font-size:1rem"><?= e(bilingual_value($l['title_np'], $l['title_en'])) ?></div>
              <?php if (!empty($l['is_completed'])): ?><span class="badge badge-on">पूरा भयो</span><?php endif; ?>
            </a>
          <?php endforeach; ?>
        </div>
      </div>

    <?php else: ?>

      <div class="page-head">
        <div class="breadcrumb">
          <a href="<?= e($base) ?>views/learn.php">पाठ्यक्रम</a> /
          <a href="?course=<?= e($course['slug']) ?>"><?= e(bilingual_value($course['title_np'], $course['title_en'])) ?></a> /
          <?= e(bilingual_value($lesson['title_np'], $lesson['title_en'])) ?>
        </div>
        <h1><?= e(bilingual_value($lesson['title_np'], $lesson['title_en'])) ?></h1>
      </div>

      <div class="card" style="margin-bottom:1rem">
        <?= lesson_body(bilingual_value($lesson['content_np'], $lesson['content_en'])) ?>
      </div>

      <?php
        $progress = fetch_one(
            'SELECT is_completed FROM lesson_progress WHERE user_id = :u AND lesson_id = :l',
            [':u' => (int) $userId, ':l' => (int) $lesson['id']]
        );
        $isDone   = $progress !== null && (int) $progress['is_completed'] === 1;
        $quiz     = fetch_one('SELECT id FROM quizzes WHERE lesson_id = :l', [':l' => (int) $lesson['id']]);
        $next     = next_lesson($lessons, (int) $lesson['id']);
      ?>

      <div class="card" style="margin-bottom:1rem">
        <div style="display:flex;gap:.75rem;flex-wrap:wrap;align-items:center">
          <?php if ($userId !== null && !$isDone): ?>
            <form method="post" action="">
              <?= csrf_field() ?>
              <input type="hidden" name="action" value="complete">
              <input type="hidden" name="course" value="<?= e($course['slug']) ?>">
              <input type="hidden" name="lesson_id" value="<?= (int) $lesson['id'] ?>">
              <button type="submit" class="btn btn-primary">पाठ पूरा भयो भन्नुहोस्</button>
            </form>
          <?php elseif ($isDone): ?>
            <span class="badge badge-on">यो पाठ पूरा भयो</span>
          <?php endif; ?>

          <?php if ($quiz !== null): ?>
            <a class="btn btn-ghost" href="<?= e($base) ?>views/quiz.php?course=<?= e($course['slug']) ?>&lesson=<?= e($lesson['slug']) ?>">क्विज दिनुहोस्</a>
          <?php endif; ?>

          <?php if ($next !== null): ?>
            <a class="btn btn-ghost" href="?course=<?= e($course['slug']) ?>&lesson=<?= e($next['slug']) ?>">अर्को पाठ →</a>
          <?php endif; ?>
        </div>
      </div>

    <?php endif; ?>

  </div>
</div>

<?php endif; ?>

<?php require __DIR__ . '/../config/includes/footer.php'; ?>
