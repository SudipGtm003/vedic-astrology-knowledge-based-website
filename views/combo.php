<?php

declare(strict_types=1);

require_once __DIR__ . '/../config/includes/auth.php';

$base = base_path();

$grahas = fetch_all('SELECT id, name_np FROM grahas ORDER BY sort_order');
$bhavas = fetch_all('SELECT id, house_number, name_np FROM bhavas ORDER BY house_number');
$rashis = fetch_all('SELECT id, name_np FROM rashis ORDER BY sort_order');
$nakshatras = fetch_all(
    'SELECT t.id, t.name_np
     FROM topics t
     JOIN categories c ON c.id = t.category_id
     WHERE c.code = :code AND t.is_published = 1
     ORDER BY t.sort_order',
    [':code' => 'nakshatra']
);

$pageTitle = 'संयोजन विश्लेषण';
require __DIR__ . '/../config/includes/header.php';
?>

<div class="page-head">
  <h1>संयोजन विश्लेषण</h1>
  <p class="muted">ग्रह र संयोजन प्रकार छान्नुहोस् — भाव, राशि, भाव + राशि, नक्षत्र, ग्रह + ग्रह र दशा (महादशा, अन्तर्दशा, प्रत्यन्तर्दशा) अनुसार विस्तृत फलदेश देखिन्छ।</p>
</div>

<div class="card">
  <form id="combo-form" class="combo-controls" data-endpoint="<?= e($base) ?>public/api/combo.php">
    <div class="field">
      <label for="graha_id">ग्रह</label>
      <select id="graha_id" name="graha_id" required>
        <?php foreach ($grahas as $g): ?>
          <option value="<?= e((string) $g['id']) ?>"><?= e($g['name_np']) ?></option>
        <?php endforeach; ?>
      </select>
    </div>

    <div class="field">
      <label for="target_type">संयोजन प्रकार</label>
      <select id="target_type" name="target_type" required>
        <option value="bhava">भाव (गृह)</option>
        <option value="rashi">राशि</option>
        <option value="bhava_rashi">भाव + राशि</option>
        <option value="nakshatra">नक्षत्र</option>
        <option value="graha_graha">ग्रह + ग्रह</option>
        <option value="dasha">दशा (महादशा + अन्तर्दशा + प्रत्यन्तर्दशा)</option>
      </select>
    </div>

    <div class="field">
      <label for="bhava_id">भाव</label>
      <select id="bhava_id" name="bhava_id">
        <?php foreach ($bhavas as $b): ?>
          <option value="<?= e((string) $b['id']) ?>">
            <?= e((string) $b['house_number']) ?>. <?= e($b['name_np']) ?>
          </option>
        <?php endforeach; ?>
      </select>
    </div>

    <div class="field" hidden>
      <label for="rashi_id">राशि</label>
      <select id="rashi_id" name="rashi_id">
        <?php foreach ($rashis as $r): ?>
          <option value="<?= e((string) $r['id']) ?>"><?= e($r['name_np']) ?></option>
        <?php endforeach; ?>
      </select>
    </div>

    <div class="field" hidden>
      <label for="nakshatra_id">नक्षत्र</label>
      <select id="nakshatra_id" name="nakshatra_id">
        <?php foreach ($nakshatras as $n): ?>
          <option value="<?= e((string) $n['id']) ?>"><?= e($n['name_np']) ?></option>
        <?php endforeach; ?>
      </select>
    </div>

    <div class="field" hidden>
      <label for="graha2_id">दोस्रो ग्रह</label>
      <select id="graha2_id" name="graha2_id">
        <?php foreach ($grahas as $g): ?>
          <option value="<?= e((string) $g['id']) ?>"><?= e($g['name_np']) ?></option>
        <?php endforeach; ?>
      </select>
    </div>

    <div class="field" hidden>
      <label for="dasha_maha">महादशा</label>
      <select id="dasha_maha" name="dasha_maha">
        <?php foreach ($grahas as $g): ?>
          <option value="<?= e((string) $g['id']) ?>"><?= e($g['name_np']) ?></option>
        <?php endforeach; ?>
      </select>
    </div>

    <div class="field" hidden>
      <label for="dasha_antar">अन्तर्दशा</label>
      <select id="dasha_antar" name="dasha_antar">
        <?php foreach ($grahas as $g): ?>
          <option value="<?= e((string) $g['id']) ?>"><?= e($g['name_np']) ?></option>
        <?php endforeach; ?>
      </select>
    </div>

    <div class="field" hidden>
      <label for="dasha_praty">प्रत्यन्तर्दशा</label>
      <select id="dasha_praty" name="dasha_praty">
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
  <p class="combo-empty">माथिका विकल्प छानेर "हेर्नुहोस्" थिच्नुहोस्।</p>
</div>

<?php require __DIR__ . '/../config/includes/footer.php'; ?>
