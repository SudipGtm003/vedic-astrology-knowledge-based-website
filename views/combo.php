<?php

declare(strict_types=1);

require_once __DIR__ . '/../config/includes/auth.php';

$base = base_path();

$grahas = fetch_all('SELECT id, name_np, name_en FROM grahas ORDER BY sort_order');
$bhavas = fetch_all('SELECT id, house_number, name_np FROM bhavas ORDER BY house_number');
$rashis = fetch_all('SELECT id, name_np FROM rashis ORDER BY sort_order');

$pageTitle = 'संयोजन विश्लेषण';
require __DIR__ . '/../config/includes/header.php';
?>

<div class="page-head">
  <h1>संयोजन विश्लेषण</h1>
  <p class="muted">भाव, राशि र ग्रह छानेर शास्त्रीय श्लोक, भावेश फल र विस्तृत फलादेश हेर्नुहोस् — एकैपटक धेरै ग्रह छान्न पनि मिल्छ।</p>
</div>

<div class="card">
  <form id="combo-form" class="combo-controls" data-endpoint="<?= e($base) ?>public/api/combo.php">
    <div class="field">
      <label for="bhava_id">भाव</label>
      <select id="bhava_id" name="bhava_id">
        <?php foreach ($bhavas as $b): ?>
          <option value="<?= e((string) $b['id']) ?>"<?= (int) $b['id'] === 1 ? ' selected' : '' ?>>
            <?= e((string) $b['house_number']) ?>. <?= e($b['name_np']) ?>
          </option>
        <?php endforeach; ?>
      </select>
    </div>

    <div class="field">
      <label for="rashi_id">राशि</label>
      <select id="rashi_id" name="rashi_id">
        <?php foreach ($rashis as $i => $r): ?>
          <option value="<?= e((string) $r['id']) ?>"<?= (int) $r['id'] === 1 ? ' selected' : '' ?>>
            <?= e((string) ($i + 1)) ?>. <?= e($r['name_np']) ?>
          </option>
        <?php endforeach; ?>
      </select>
    </div>

    <div class="field multi-field">
      <div class="multi-head">
        <label for="graha-multi-btn">ग्रह</label>
        <span class="multi-count" id="graha-count" hidden></span>
      </div>
      <div class="multi-wrap" id="graha-dropdown">
        <button type="button" id="graha-multi-btn" class="multi-btn">
          <span class="multi-btn-text" id="graha-btn-label">—</span>
          <span class="multi-caret" aria-hidden="true">▾</span>
        </button>
        <div class="multi-panel" id="graha-panel" hidden>
          <div class="multi-panel-head">
            <span>ग्रह बहु-चयन (Multiple Select)</span>
            <button type="button" class="multi-clear" id="graha-clear">खाली गर्नुहोस्</button>
          </div>
          <div class="multi-list" id="graha-list">
            <?php foreach ($grahas as $g): ?>
              <div class="multi-row" data-id="<?= e((string) $g['id']) ?>" data-name="<?= e($g['name_np']) ?>">
                <span class="multi-left">
                  <span class="multi-check" aria-hidden="true"></span>
                  <span class="multi-name"><?= e($g['name_np']) ?> (<?= e($g['name_en']) ?>)</span>
                </span>
                <button type="button" class="multi-retro" hidden></button>
              </div>
            <?php endforeach; ?>
          </div>
          <div class="multi-panel-foot">
            <button type="button" class="multi-done" id="graha-done">सम्पन्न (Done)</button>
          </div>
        </div>
      </div>
    </div>

    <div class="field">
      <button type="submit" class="btn btn-primary btn-block">हेर्नुहोस्</button>
    </div>
  </form>

  <div class="chips-row" id="chips-row">
    <div class="chips-selected">
      <span class="chips-label">चयन गरिएका ग्रहहरू:</span>
      <span class="chips-list" id="chips-list"></span>
    </div>
    <div class="chips-add">
      <span class="chips-label">थप्नुहोस्:</span>
      <span class="chips-list" id="chips-quick"></span>
    </div>
  </div>
</div>

<div id="combo-result" class="combo-result" aria-live="polite">
  <p class="combo-empty">भाव, राशि र ग्रह छानेर हेर्नुहोस्।</p>
</div>

<?php require __DIR__ . '/../config/includes/footer.php'; ?>
