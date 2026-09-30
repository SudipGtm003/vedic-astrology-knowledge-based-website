<?php

declare(strict_types=1);

require_once __DIR__ . '/../config/includes/auth.php';

require_admin();

$base = base_path();

$id      = filter_var(get('id'), FILTER_VALIDATE_INT) ?: 0;
$errors  = [];
$topic   = null;
$content = null;
$remedyLines = '';

function make_slug(string $value): string
{
    $slug = strtolower(trim($value));
    $slug = preg_replace('/[^a-z0-9]+/', '-', $slug) ?: '';
    $slug = trim($slug, '-');

    if ($slug === '') {
        $slug = 'topic-' . time();
    }

    return mb_substr($slug, 0, 110);
}

if ($id > 0) {
    $topic = fetch_one('SELECT * FROM topics WHERE id = :id', [':id' => $id]);

    if ($topic === null) {
        flash('warning', 'विषय फेला परेन।');
        redirect(base_path() . 'admin/topics.php');
    }

    $content = fetch_one('SELECT * FROM topic_content WHERE topic_id = :id', [':id' => $id]);
    $remedyLines = implode("\n", array_column(
        fetch_all('SELECT remedy_np FROM topic_remedies WHERE topic_id = :id ORDER BY sort_order', [':id' => $id]),
        'remedy_np'
    ));
}

$categories = fetch_all('SELECT id, name_np, name_en FROM categories ORDER BY sort_order');

if (is_post()) {
    require_csrf();

    $categoryId   = post_int('category_id');
    $nameNp       = post('name_np');
    $nameEn       = post('name_en');
    $slug         = post('slug');
    $sanskritName = post('sanskrit_name');
    $sortOrder    = post_int('sort_order', 0);
    $published    = isset($_POST['is_published']) ? 1 : 0;

    $summaryNp   = post('summary_np');
    $summaryEn   = post('summary_en');
    $characs     = post('characteristics');
    $effects     = post('effects');
    $classical   = post('classical_reference');
    $sanskritTerm   = post('sanskrit_term');
    $sanskritMeaning = post('sanskrit_meaning');
    $remedies    = post('remedies');

    if ($categoryId < 1) {
        $errors[] = 'श्रेणी छान्नुहोस्।';
    }
    if (mb_strlen($nameNp) < 2) {
        $errors[] = 'नेपाली नाम आवश्यक छ।';
    }
    if (mb_strlen($nameEn) < 2) {
        $errors[] = 'English name is required.';
    }

    if ($slug === '') {
        $slug = make_slug($nameEn !== '' ? $nameEn : $nameNp);
    } else {
        $slug = make_slug($slug);
    }

    $dup = fetch_column(
        'SELECT id FROM topics WHERE slug = :slug AND id <> :id',
        [':slug' => $slug, ':id' => $id]
    );

    if ($dup !== null) {
        $errors[] = 'त्यही स्लग अर्को विषयमा पहिले नै प्रयोग भइसकेको छ।';
    }

    if ($errors === []) {
        if ($id > 0) {
            execute(
                'UPDATE topics SET category_id = :c, slug = :s, sanskrit_name = :sn,
                        name_np = :np, name_en = :en, sort_order = :so, is_published = :p
                 WHERE id = :id',
                [':c' => $categoryId, ':s' => $slug, ':sn' => $sanskritName ?: null,
                 ':np' => $nameNp, ':en' => $nameEn, ':so' => $sortOrder, ':p' => $published, ':id' => $id]
            );
            $savedId = $id;
            $message = 'विषय अद्यावधिक भयो।';
        } else {
            execute(
                'INSERT INTO topics (category_id, slug, sanskrit_name, name_np, name_en, sort_order, is_published)
                 VALUES (:c, :s, :sn, :np, :en, :so, :p)',
                [':c' => $categoryId, ':s' => $slug, ':sn' => $sanskritName ?: null,
                 ':np' => $nameNp, ':en' => $nameEn, ':so' => $sortOrder, ':p' => $published]
            );
            $savedId = insert_id();
            $message = 'नयाँ विषय थपियो।';
        }

        execute(
            'INSERT INTO topic_content (topic_id, summary_np, summary_en, characteristics, effects,
                                        classical_reference, sanskrit_term, sanskrit_meaning)
             VALUES (:id, :snp, :sen, :ch, :ef, :cl, :st, :sm)
             ON DUPLICATE KEY UPDATE
                summary_np = VALUES(summary_np), summary_en = VALUES(summary_en),
                characteristics = VALUES(characteristics), effects = VALUES(effects),
                classical_reference = VALUES(classical_reference),
                sanskrit_term = VALUES(sanskrit_term), sanskrit_meaning = VALUES(sanskrit_meaning)',
            [':id' => $savedId, ':snp' => $summaryNp, ':sen' => $summaryEn, ':ch' => $characs,
             ':ef' => $effects, ':cl' => $classical, ':st' => $sanskritTerm, ':sm' => $sanskritMeaning]
        );

        execute('DELETE FROM topic_remedies WHERE topic_id = :id', [':id' => $savedId]);

        $order = 1;
        foreach (array_filter(array_map('trim', explode("\n", $remedies))) as $line) {
            execute(
                'INSERT INTO topic_remedies (topic_id, remedy_np, remedy_en, sort_order) VALUES (:id, :np, NULL, :so)',
                [':id' => $savedId, ':np' => $line, ':so' => $order]
            );
            $order++;
        }

        log_activity((int) current_user_id(), $id > 0 ? 'update_topic' : 'create_topic', 'topics', $savedId);

        flash('success', $message);
        redirect(base_path() . 'admin/topics.php');
    }

    $topic = [
        'id' => $id, 'category_id' => $categoryId, 'name_np' => $nameNp, 'name_en' => $nameEn,
        'slug' => $slug, 'sanskrit_name' => $sanskritName, 'sort_order' => $sortOrder,
        'is_published' => $published,
    ];
    $content = [
        'summary_np' => $summaryNp, 'summary_en' => $summaryEn, 'characteristics' => $characs,
        'effects' => $effects, 'classical_reference' => $classical,
        'sanskrit_term' => $sanskritTerm, 'sanskrit_meaning' => $sanskritMeaning,
    ];
    $remedyLines = $remedies;
}

$v = fn (?string $key) => $topic !== null && $key !== null ? (string) ($topic[$key] ?? '') : '';
$c = fn (?string $key) => $content !== null && $key !== null ? (string) ($content[$key] ?? '') : '';

$pageTitle = $id > 0 ? 'विषय सम्पादन' : 'नयाँ विषय';
require __DIR__ . '/../config/includes/header.php';
?>

<div class="page-head">
  <div class="breadcrumb">
    <a href="index.php">एडमिन</a> /
    <a href="<?= e($base) ?>admin/topics.php">विषय</a> /
    <?= $id > 0 ? 'सम्पादन' : 'नयाँ' ?>
  </div>
  <h1><?= $id > 0 ? 'विषय सम्पादन' : 'नयाँ विषय' ?></h1>
</div>

<?php if ($errors !== []): ?>
  <div class="alert alert-error">
    <ul><?php foreach ($errors as $e1): ?><li><?= e($e1) ?></li><?php endforeach; ?></ul>
  </div>
<?php endif; ?>

<form method="post" action="<?= e($base) ?>admin/topic-edit.php<?= $id > 0 ? '?id=' . $id : '' ?>">
  <?= csrf_field() ?>

  <div class="card" style="margin-bottom:1rem">
    <h2>मुख्य जानकारी</h2>

    <div class="combo-controls">
      <div class="field">
        <label for="category_id">श्रेणी *</label>
        <select id="category_id" name="category_id" required>
          <option value="">— छान्नुहोस् —</option>
          <?php foreach ($categories as $cat): ?>
            <option value="<?= e((string) $cat['id']) ?>"
              <?= $topic !== null && (int) $topic['category_id'] === (int) $cat['id'] ? 'selected' : '' ?>>
              <?= e($cat['name_np']) ?> (<?= e($cat['name_en']) ?>)
            </option>
          <?php endforeach; ?>
        </select>
      </div>

      <div class="field">
        <label for="sort_order">क्रम संख्या</label>
        <input type="number" id="sort_order" name="sort_order" value="<?= e($v('sort_order')) ?: '0' ?>">
      </div>

      <div class="field">
        <label for="is_published">प्रकाशन स्थिति</label>
        <label style="display:flex;align-items:center;gap:.45rem;margin-top:.4rem;font-weight:400">
          <input type="checkbox" id="is_published" name="is_published" value="1"
                 <?= (int) ($topic['is_published'] ?? 1) === 1 ? 'checked' : '' ?>>
          प्रकाशित गर्नुहोस् (छानिएको नभए खस्कनमा रहन्छ)
        </label>
      </div>
    </div>

    <label for="name_np">नेपाली नाम *</label>
    <input type="text" id="name_np" name="name_np" value="<?= e($v('name_np')) ?>" required>

    <label for="name_en">English Name *</label>
    <input type="text" id="name_en" name="name_en" value="<?= e($v('name_en')) ?>" required>

    <label for="sanskrit_name">संस्कृत नाम</label>
    <input type="text" id="sanskrit_name" name="sanskrit_name" value="<?= e($v('sanskrit_name')) ?>">

    <label for="slug">स्लग (URL) <span class="muted">खाली छोड्न सकिन्छ — English नामबाट बन्छ</span></label>
    <input type="text" id="slug" name="slug" value="<?= e($v('slug')) ?>" pattern="[a-z0-9\-]+">
  </div>

  <div class="card" style="margin-bottom:1rem">
    <h2>सामग्री</h2>

    <label for="summary_np">परिचय (नेपाली)</label>
    <textarea id="summary_np" name="summary_np" rows="5"><?= e($c('summary_np')) ?></textarea>

    <label for="summary_en">परिचय (English)</label>
    <textarea id="summary_en" name="summary_en" rows="5"><?= e($c('summary_en')) ?></textarea>

    <label for="characteristics">विशेषताहरू <span class="muted">प्रत्येक लाइनमा एक</span></label>
    <textarea id="characteristics" name="characteristics" rows="5"><?= e($c('characteristics')) ?></textarea>

    <label for="effects">प्रभावहरू <span class="muted">प्रत्येक लाइनमा एक</span></label>
    <textarea id="effects" name="effects" rows="5"><?= e($c('effects')) ?></textarea>
  </div>

  <div class="card" style="margin-bottom:1rem">
    <h2>पारम्परिक सन्दर्भ र संस्कृत</h2>

    <label for="classical_reference">पारम्परिक स्रोत <span class="muted">जस्तै: Brihat Parashara Hora Shastra, Adhyaya 4</span></label>
    <input type="text" id="classical_reference" name="classical_reference" value="<?= e($c('classical_reference')) ?>">

    <label for="sanskrit_term">संस्कृत शब्दावली</label>
    <input type="text" id="sanskrit_term" name="sanskrit_term" value="<?= e($c('sanskrit_term')) ?>">

    <label for="sanskrit_meaning">शब्दको अर्थ</label>
    <textarea id="sanskrit_meaning" name="sanskrit_meaning" rows="3"><?= e($c('sanskrit_meaning')) ?></textarea>
  </div>

  <div class="card" style="margin-bottom:1rem">
    <h2>उपायहरू</h2>
    <label for="remedies">प्रत्येक लाइनमा एक उपाय</label>
    <textarea id="remedies" name="remedies" rows="5"><?= e($remedyLines) ?></textarea>
  </div>

  <div class="grid grid-3">
    <button type="submit" class="btn btn-primary btn-block" style="margin-top:0">
      <?= $id > 0 ? 'अद्यावधिक गर्नुहोस्' : 'विषय थप्नुहोस्' ?>
    </button>
    <a class="btn btn-ghost" href="<?= e($base) ?>admin/topics.php">रद्द गर्नुहोस्</a>
    <?php if ($id > 0 && $v('slug') !== ''): ?>
      <a class="btn btn-ghost" href="<?= e($base) ?>views/topic.php?slug=<?= e($v('slug')) ?>" target="_blank">पृष्ठ हेर्नुहोस्</a>
    <?php endif; ?>
  </div>
</form>

<?php require __DIR__ . '/../config/includes/footer.php'; ?>
