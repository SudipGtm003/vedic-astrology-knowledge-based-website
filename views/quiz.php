<?php

declare(strict_types=1);

require_once __DIR__ . '/../config/includes/auth.php';
require_once __DIR__ . '/../config/includes/lang.php';
require_once __DIR__ . '/../config/includes/course.php';

$base       = base_path();
$courseSlug = get('course');
$lessonSlug = get('lesson');

$course = course_by_slug($courseSlug);

if ($course === null) {
    http_response_code(404);
    $pageTitle = 'पाठ्यक्रम फेला परेन';
    require __DIR__ . '/../config/includes/header.php';
    echo '<div class="page-head"><h1>४०४ — पाठ्यक्रम फेला परेन</h1>
          <p><a class="btn btn-primary" href="' . e($base) . 'views/learn.php">पाठ्यक्रम सूची</a></p></div>';
    require __DIR__ . '/../config/includes/footer.php';
    exit;
}

require_login();

if (!is_enrolled((int) current_user_id(), (int) $course['id'])) {
    flash('warning', 'क्विज दिन पहिले पाठ्यक्रममा दर्ता हुनुपर्छ।');
    redirect($base . 'views/learn.php?course=' . $course['slug']);
}

$lesson = lesson_by_slug((int) $course['id'], $lessonSlug);
$quiz   = $lesson !== null
    ? fetch_one('SELECT * FROM quizzes WHERE lesson_id = :l', [':l' => (int) $lesson['id']])
    : null;

if ($lesson === null || $quiz === null) {
    http_response_code(404);
    $pageTitle = 'क्विज फेला परेन';
    require __DIR__ . '/../config/includes/header.php';
    echo '<div class="page-head"><h1>४०४ — क्विज फेला परेन</h1>
          <p class="muted">यस पाठका लागि क्विज तयार छैन।</p>
          <p><a class="btn btn-primary" href="' . e($base) . 'views/learn.php?course=' . e($course['slug']) . '">पाठ्यक्रममा फर्कनुहोस्</a></p></div>';
    require __DIR__ . '/../config/includes/footer.php';
    exit;
}

$attempt = null;

if (is_post()) {
    require_csrf();

    $selected = post('option');

    if (in_array($selected, ['a', 'b', 'c', 'd'], true)) {
        $isCorrect = $selected === (string) $quiz['correct_option'];

        execute(
            'INSERT INTO quiz_attempts (user_id, quiz_id, selected_option, is_correct)
             VALUES (:u, :q, :s, :c)',
            [
                ':u' => (int) current_user_id(),
                ':q' => (int) $quiz['id'],
                ':s' => $selected,
                ':c' => $isCorrect ? 1 : 0,
            ]
        );

        log_activity((int) current_user_id(), 'quiz_attempt', 'quizzes', (int) $quiz['id']);

        $attempt = ['selected' => $selected, 'is_correct' => $isCorrect];
    }
}

$lessons = course_lessons((int) $course['id'], (int) current_user_id());
$next    = next_lesson($lessons, (int) $lesson['id']);

$pageTitle = bilingual_value($quiz['question_np'], $quiz['question_en']);
require __DIR__ . '/../config/includes/header.php';
?>

<div class="page-head">
  <div class="breadcrumb">
    <a href="<?= e($base) ?>views/learn.php">पाठ्यक्रम</a> /
    <a href="<?= e($base) ?>views/learn.php?course=<?= e($course['slug']) ?>"><?= e(bilingual_value($course['title_np'], $course['title_en'])) ?></a> /
    <a href="<?= e($base) ?>views/learn.php?course=<?= e($course['slug']) ?>&lesson=<?= e($lesson['slug']) ?>"><?= e(bilingual_value($lesson['title_np'], $lesson['title_en'])) ?></a>
  </div>
  <h1>क्विज</h1>
  <p class="muted">एउटा सही उत्तर छान्नुहोस्।</p>
</div>

<div class="card" style="margin-bottom:1rem">
  <h2><?= e(bilingual_value($quiz['question_np'], $quiz['question_en'])) ?></h2>

  <?php if ($attempt === null): ?>
    <form method="post" action="">
      <?= csrf_field() ?>

      <?php foreach (['a', 'b', 'c', 'd'] as $key): ?>
        <label class="quiz-option" for="opt_<?= $key ?>">
          <input type="radio" id="opt_<?= $key ?>" name="option" value="<?= $key ?>" required>
          <span><?= e((string) $quiz['option_' . $key]) ?></span>
        </label>
      <?php endforeach; ?>

      <button type="submit" class="btn btn-primary" style="margin-top:1.25rem">उत्तर पेश गर्नुहोस्</button>
    </form>

  <?php else: ?>

    <?php
      $correctKey = (string) $quiz['correct_option'];
      $chosenKey  = $attempt['selected'];
    ?>

    <div class="alert <?= $attempt['is_correct'] ? 'alert-success' : 'alert-error' ?>">
      <?= $attempt['is_correct']
          ? 'सही उत्तर! बधाई छ।'
          : 'गलत उत्तर। सही उत्तर: ' . e((string) $quiz['option_' . $correctKey]) ?>
    </div>

    <div class="grid grid-2" style="margin-top:1rem">
      <?php foreach (['a', 'b', 'c', 'd'] as $key): ?>
        <?php
          $state = '';
          if ($key === $correctKey) {
              $state = ' correct';
          } elseif ($key === $chosenKey) {
              $state = ' wrong';
          }
        ?>
        <div class="quiz-option is-answer<?= $state ?>">
          <strong><?= strtoupper($key) ?>.</strong> <?= e((string) $quiz['option_' . $key]) ?>
          <?php if ($key === $correctKey): ?><span class="badge badge-on">सही</span><?php endif; ?>
          <?php if ($key === $chosenKey && $key !== $correctKey): ?><span class="badge badge-off">तपाईंको</span><?php endif; ?>
        </div>
      <?php endforeach; ?>
    </div>

    <?php if (trim((string) $quiz['explanation_np'])): ?>
      <div class="sanskrit-block" style="margin-top:1.25rem">
        <span class="lang-hint">व्याख्या</span>
        <p style="margin:.35rem 0 0"><?= e($quiz['explanation_np']) ?></p>
      </div>
    <?php endif; ?>

    <div style="display:flex;gap:.75rem;flex-wrap:wrap;margin-top:1.5rem">
      <a class="btn btn-ghost" href="<?= e($base) ?>views/learn.php?course=<?= e($course['slug']) ?>&lesson=<?= e($lesson['slug']) ?>">← पाठमा फर्कनुहोस्</a>
      <?php if ($next !== null): ?>
        <a class="btn btn-primary" href="<?= e($base) ?>views/learn.php?course=<?= e($course['slug']) ?>&lesson=<?= e($next['slug']) ?>">अर्को पाठ →</a>
      <?php else: ?>
        <a class="btn btn-primary" href="<?= e($base) ?>views/learn.php?course=<?= e($course['slug']) ?>">पाठ्यक्रम हेर्नुहोस्</a>
      <?php endif; ?>
    </div>

  <?php endif; ?>
</div>

<?php require __DIR__ . '/../config/includes/footer.php'; ?>
