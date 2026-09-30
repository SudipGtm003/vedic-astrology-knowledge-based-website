<?php

declare(strict_types=1);

require_once __DIR__ . '/../config/includes/auth.php';

require_admin();

$base = base_path();

$action = get('action', 'list');

if ($action === 'delete' && is_post()) {
    require_csrf();
    $id = post_int('id');

    if ($id > 0) {
        $slug = (string) fetch_column('SELECT slug FROM topics WHERE id = :id', [':id' => $id]);

        if ($slug !== '') {
            execute('DELETE FROM topics WHERE id = :id', [':id' => $id]);
            execute('DELETE FROM search_index WHERE entity_type = "topic" AND entity_id = :id', [':id' => $id]);
            log_activity((int) current_user_id(), 'delete_topic', 'topics', $id);
            flash('success', 'विषय हटाइयो।');
        }
    }

    redirect(base_path() . 'admin/topics.php');
}

$topics = fetch_all(
    'SELECT t.id, t.slug, t.name_np, t.name_en, t.sanskrit_name, t.is_published, t.sort_order,
            c.name_np AS cat_np, c.code
     FROM topics t
     JOIN categories c ON c.id = t.category_id
     ORDER BY c.sort_order, t.sort_order'
);

$stats = [
    'total'     => count($topics),
    'published' => count(array_filter($topics, fn ($t) => (int) $t['is_published'] === 1)),
    'draft'     => count(array_filter($topics, fn ($t) => (int) $t['is_published'] !== 1)),
    'with_content' => (int) fetch_column('SELECT COUNT(*) FROM topic_content'),
];

$pageTitle = 'विषय व्यवस्थापन';
require __DIR__ . '/../config/includes/header.php';
?>

<div class="page-head">
  <div class="breadcrumb"><a href="index.php">एडमिन</a> / विषय</div>
  <h1>विषय व्यवस्थापन</h1>
  <p class="muted">विषय थप्न, सम्पादन गर्न वा हटाउनुहोस्।</p>
</div>

<div class="stat-row">
  <div class="stat"><div class="stat-num"><?= e((string) $stats['total']) ?></div><div class="stat-label">कुल</div></div>
  <div class="stat"><div class="stat-num"><?= e((string) $stats['published']) ?></div><div class="stat-label">प्रकाशित</div></div>
  <div class="stat"><div class="stat-num"><?= e((string) $stats['draft']) ?></div><div class="stat-label">खस्कन</div></div>
  <div class="stat"><div class="stat-num"><?= e((string) $stats['with_content']) ?></div><div class="stat-label">सामग्री भएका</div></div>
</div>

<div class="card" style="margin-bottom:1rem">
  <div class="table-wrap">
    <table>
      <thead>
        <tr>
          <th style="width:60px">#</th>
          <th>नाम</th>
          <th>श्रेणी</th>
          <th>स्लग</th>
          <th>सामग्री</th>
          <th>स्थिति</th>
          <th style="width:170px">कार्य</th>
        </tr>
      </thead>
      <tbody>
        <?php if ($topics === []): ?>
          <tr><td colspan="7" class="muted">कुनै विषय छैन। नयाँ थप्नुहोस्।</td></tr>
        <?php endif; ?>

        <?php foreach ($topics as $t): ?>
          <tr>
            <td><?= e((string) $t['id']) ?></td>
            <td>
              <strong><?= e($t['name_np']) ?></strong><br>
              <span class="muted"><?= e($t['name_en']) ?></span>
            </td>
            <td><span class="tag"><?= e($t['cat_np']) ?></span></td>
            <td><code><?= e($t['slug']) ?></code></td>
            <td>
              <?php if ((int) fetch_column('SELECT COUNT(*) FROM topic_content WHERE topic_id = :id', [':id' => (int) $t['id']]) > 0): ?>
                <span class="badge badge-on">छ</span>
              <?php else: ?>
                <span class="badge badge-off">छैन</span>
              <?php endif; ?>
            </td>
            <td>
              <?php if ((int) $t['is_published'] === 1): ?>
                <span class="badge badge-on">प्रकाशित</span>
              <?php else: ?>
                <span class="badge badge-off">खस्कन</span>
              <?php endif; ?>
            </td>
            <td>
              <a class="btn btn-sm btn-ghost" href="<?= e($base) ?>admin/topic-edit.php?id=<?= e((string) $t['id']) ?>">सम्पादन</a>
              <a class="btn btn-sm btn-ghost" href="<?= e($base) ?>views/topic.php?slug=<?= e($t['slug']) ?>" target="_blank">हेर्न</a>
              <form method="post" action="<?= e($base) ?>admin/topics.php?action=delete" data-confirm="यो विषय र यसको सामग्री मेटाउने हो?"
                    style="display:inline-block">
                <?= csrf_field() ?>
                <input type="hidden" name="id" value="<?= e((string) $t['id']) ?>">
                <button type="submit" class="btn btn-sm btn-ghost" style="color:var(--err);border-color:var(--err)">मेटाउने</button>
              </form>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</div>

<div class="grid grid-3">
  <a class="btn btn-primary" href="<?= e($base) ?>admin/topic-edit.php">+ नयाँ विषय</a>
  <a class="btn btn-ghost" href="<?= e($base) ?>views/topic.php?category=bhava">भाव हेर्न</a>
  <a class="btn btn-ghost" href="<?= e($base) ?>views/topic.php?category=graha">ग्रह हेर्न</a>
</div>

<?php require __DIR__ . '/../config/includes/footer.php'; ?>
