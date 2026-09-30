<?php

declare(strict_types=1);

require_once __DIR__ . '/../config/includes/auth.php';
require_once __DIR__ . '/../config/includes/lang.php';

$base = base_path();

$sanskritSamples = fetch_all(
    'SELECT t.name_np AS topic_np, t.name_en AS topic_en,
            c.sanskrit_term, c.sanskrit_meaning
       FROM topic_content c
       JOIN topics t ON t.id = c.topic_id
      WHERE c.sanskrit_term IS NOT NULL AND c.sanskrit_term <> ""
      ORDER BY t.sort_order
      LIMIT 8'
);

$remedySamples = fetch_all(
    'SELECT t.name_np AS topic_np, t.name_en AS topic_en,
            r.remedy_np, r.remedy_en
       FROM topic_remedies r
       JOIN topics t ON t.id = r.topic_id
      ORDER BY r.id
      LIMIT 6'
);

$sections = [
    ['classical', 'शास्त्रीय सिद्धान्त', 'Classical Principles'],
    ['sanskrit', 'संस्कृत सन्दर्भ', 'Sanskrit References'],
    ['nepali', 'नेपाली अनुवाद', 'Nepali Translation'],
    ['remedies', 'वैदिक उपाय', 'Vedic Remedies'],
];

$pageTitle = bilingual_value('सन्दर्भ', 'References');
require __DIR__ . '/../config/includes/header.php';
?>

<div class="page-head">
  <h1><?= e(bilingual_value('सन्दर्भ', 'References')) ?></h1>
  <p class="muted"><?= e(bilingual_value(
      'शास्त्र, संस्कृत पद, अनुवाद र उपायसम्बन्धी संकलित जानकारी।',
      'A compiled reference of classical texts, Sanskrit terms, translations and remedies.'
  )) ?></p>
</div>

<div class="layout">
  <aside class="sidebar">
    <h4><?= e(bilingual_value('यस पृष्ठमा', 'On this page')) ?></h4>
    <input id="sidebar-filter" type="search" placeholder="<?= e(bilingual_value('खोज्नुहोस्…', 'Filter…')) ?>"
           aria-label="<?= e(bilingual_value('खोज्नुहोस्', 'Filter')) ?>" style="margin-bottom:.6rem">
    <ul>
      <?php foreach ($sections as [$id, $np, $en]): ?>
        <li data-filter-item><a href="#<?= e($id) ?>"><?= e(bilingual_value($np, $en)) ?></a></li>
      <?php endforeach; ?>
    </ul>
  </aside>

  <div>
    <section id="classical" class="card" style="margin-bottom:1.25rem">
      <h2><?= e(bilingual_value('शास्त्रीय सिद्धान्त', 'Classical Principles')) ?></h2>
      <?= bilingual(
          'वैदिक ज्योतिषका प्रमुख ग्रन्थहरूमा बृहत् पाराशर होर शास्त्र, फलदीपिका, जातक पारिजात र वेदाङ्ग ज्योतिष पर्दछन्। यी ग्रन्थहरूमा ग्रह, भाव, योग र दशाका नियमहरू व्यवस्थित रूपमा वर्णन गरिएका छन्।',
          'The principal texts of Vedic astrology include Brihat Parashara Hora Shastra, Phaladeepika, Jataka Parijata and Vedanga Jyotisha. These works set out systematic rules for grahas, bhavas, yogas and dashas.'
      ) ?>
      <?= bilingual(
          'यस परियोजनामा प्रत्येक विषयको पारम्परिक स्रोत उल्लेख गरिएको छ, तर व्याख्याहरू अध्ययनका लागि आफैं लेखिएका हुन्।',
          'Each topic on this project cites its classical source, while the explanations themselves are written for study.'
      ) ?>
    </section>

    <section id="sanskrit" class="card" style="margin-bottom:1.25rem">
      <h2><?= e(bilingual_value('संस्कृत सन्दर्भ', 'Sanskrit References')) ?></h2>
      <p class="muted"><?= e(bilingual_value(
          'संस्कृत पदहरू यहाँ मूल देवनागरीमा राखिएका छन्, तिनको अर्थ सँगै दिइएको छ।',
          'Sanskrit terms are kept in their original Devanagari script with the meaning given alongside.'
      )) ?></p>

      <?php if ($sanskritSamples !== []): ?>
        <div class="table-wrap">
          <table>
            <thead>
              <tr>
                <th><?= e(bilingual_value('विषय', 'Topic')) ?></th>
                <th><?= e(bilingual_value('संस्कृत पद', 'Sanskrit term')) ?></th>
                <th><?= e(bilingual_value('अर्थ', 'Meaning')) ?></th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($sanskritSamples as $s): ?>
                <tr>
                  <td><?= e(bilingual_value($s['topic_np'], $s['topic_en'])) ?></td>
                  <td><strong><?= e($s['sanskrit_term']) ?></strong></td>
                  <td class="muted"><?= e($s['sanskrit_meaning']) ?></td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      <?php endif; ?>
    </section>

    <section id="nepali" class="card" style="margin-bottom:1.25rem">
      <h2><?= e(bilingual_value('नेपाली अनुवाद', 'Nepali Translation')) ?></h2>
      <?= bilingual(
          'यो मञ्चको मूल भाषा नेपाली हो। सबै विषय, पाठ र क्विज नेपालीमा उपलब्ध छन्, जसले नेपाली माध्यमका विद्यार्थीलाई आफ्नै भाषामा अध्ययन गर्न सहज बनाउँछ।',
          'Nepali is the primary language of this platform. Every topic, lesson and quiz is available in Nepali, which makes study easier for students taught in Nepali medium.'
      ) ?>
    </section>

    <section id="remedies" class="card">
      <h2><?= e(bilingual_value('वैदिक उपाय', 'Vedic Remedies')) ?></h2>
      <?= bilingual(
          'परम्परागत ज्योतिषमा प्रत्येक ग्रह र नक्षत्रसँग सम्बन्धित सरल उपायहरू वर्णन गरिएका छन् — दान, मन्त्र, व्रत वा विशेष दिनमा पूजा जस्ता कुरा। यहाँ दिइएका उपायहरू अध्ययनका लागि मात्र हुन्।',
          'Traditional astrology describes simple remedies associated with each graha and nakshatra — charity, mantra, fasting or worship on a particular day. The remedies listed here are for study only.'
      ) ?>

      <?php if ($remedySamples !== []): ?>
        <div class="table-wrap">
          <table>
            <thead>
              <tr>
                <th><?= e(bilingual_value('विषय', 'Topic')) ?></th>
                <th><?= e(bilingual_value('उपाय', 'Remedy')) ?></th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($remedySamples as $r): ?>
                <tr>
                  <td><?= e(bilingual_value($r['topic_np'], $r['topic_en'])) ?></td>
                  <td><?= e(bilingual_value($r['remedy_np'], $r['remedy_en'])) ?></td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
        <p style="margin-top:1rem">
          <a class="btn btn-ghost btn-sm" href="<?= e($base) ?>views/topic.php?category=nakshatra"><?= e(bilingual_value('सबै उपाय हेर्नुहोस्', 'View all remedies')) ?></a>
        </p>
      <?php endif; ?>
    </section>
  </div>
</div>

<?php require __DIR__ . '/../config/includes/footer.php'; ?>
