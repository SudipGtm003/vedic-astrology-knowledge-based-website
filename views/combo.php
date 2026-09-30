<?php

declare(strict_types=1);

require_once __DIR__ . '/../config/includes/auth.php';

$base = base_path();

$grahas = fetch_all('SELECT id, name_np FROM grahas ORDER BY sort_order');
$bhavas = fetch_all('SELECT id, house_number, name_np FROM bhavas ORDER BY house_number');
$rashis = fetch_all('SELECT id, name_np FROM rashis ORDER BY sort_order');

$pageTitle = 'संयोजन विश्लेषण';
require __DIR__ . '/../config/includes/header.php';
?>

<div class="page-head">
  <h1>संयोजन विश्लेषण</h1>
  <p class="muted">भाव छान्नुहोस्, त्यसभित्रको राशि र त्यहाँ रहेको ग्रह छानेर फलदेश हेर्नुहोस् — तीनै विकल्प आवश्यक छन्।</p>
</div>

<div class="card">
  <form id="combo-form" class="combo-controls" data-endpoint="<?= e($base) ?>public/api/combo.php">
    <div class="field">
      <label for="bhava_id">भाव</label>
      <select id="bhava_id" name="bhava_id">
        <option value="" selected>— छान्नुहोस् —</option>
        <?php foreach ($bhavas as $b): ?>
          <option value="<?= e((string) $b['id']) ?>">
            <?= e((string) $b['house_number']) ?>. <?= e($b['name_np']) ?>
          </option>
        <?php endforeach; ?>
      </select>
    </div>

    <div class="field">
      <label for="rashi_id">राशि</label>
      <select id="rashi_id" name="rashi_id">
        <option value="" selected>— छान्नुहोस् —</option>
        <?php foreach ($rashis as $i => $r): ?>
          <option value="<?= e((string) $r['id']) ?>">
            <?= e((string) ($i + 1)) ?>. <?= e($r['name_np']) ?>
          </option>
        <?php endforeach; ?>
      </select>
    </div>

    <div class="field">
      <label for="graha_id">ग्रह</label>
      <select id="graha_id" name="graha_id">
        <option value="" selected>— छान्नुहोस् —</option>
        <?php foreach ($grahas as $g): ?>
          <option value="<?= e((string) $g['id']) ?>"><?= e($g['name_np']) ?></option>
        <?php endforeach; ?>
      </select>
    </div>

    <div class="field">
      <button type="submit" class="btn btn-primary btn-block">हेर्नुहोस्</button>
    </div>
  </form>
</div>

<div id="combo-result" class="combo-result" aria-live="polite">
  <p class="combo-empty">भाव, राशि र ग्रह चयन गर्नुहोस्।</p>
</div>

<?php require __DIR__ . '/../config/includes/footer.php'; ?>
