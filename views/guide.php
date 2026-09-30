<?php

declare(strict_types=1);

require_once __DIR__ . '/../config/includes/auth.php';
require_once __DIR__ . '/../config/includes/lang.php';

$base = base_path();

$sections = [
    ['introduction', 'परिचय', 'Introduction'],
    ['basic-concepts', 'आधारभूत अवधारणा', 'Basic Concepts'],
    ['fundamentals', 'ज्योतिषको आधार', 'Astrology Fundamentals'],
    ['learning-path', 'सिकाइ मार्ग', 'Learning Path'],
];

$pageTitle = bilingual_value('सिकाइ', 'Learn');
require __DIR__ . '/../config/includes/header.php';
?>

<div class="page-head">
  <h1><?= e(bilingual_value('सिकाइ', 'Learn')) ?></h1>
  <p class="muted"><?= e(bilingual_value(
      'वैदिक ज्योतिष सिक्ने मानिसका लागि क्रमबद्ध परिचय।',
      'A structured introduction for anyone learning Vedic astrology.'
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
    <section id="introduction" class="card" style="margin-bottom:1.25rem">
      <h2><?= e(bilingual_value('परिचय', 'Introduction')) ?></h2>
      <?= bilingual(
          'वैदिक ज्योतिष (ज्योतिष शास्त्र) प्राचीन भारतीय ज्ञान परम्पराको एक शाखा हो जसले ग्रह, राशि, भाव र नक्षत्रको अध्ययन गर्छ। नेपालमा यो ज्ञान जन्म, विवाह, व्रतबन्ध र शुभ कार्यका समय निर्धारणसँग जोडिएको छ। यहाँ हामी यसलाई एउटा शैक्षिक विषयको रूपमा हेर्छौं — भविष्यवाणीको साधन होइन, अध्ययनको विषय।',
          'Vedic astrology (Jyotish Shastra) is a branch of the ancient Indian knowledge tradition that studies planets, zodiac signs, houses and lunar mansions. In Nepal it is closely tied to birth, marriage, rituals and the timing of auspicious work. Here we approach it as an academic subject — a field to study, not a tool for prediction.'
      ) ?>
      <?= bilingual(
          'यो मञ्च बी.सी.ए. चौथो सेमेस्टरको शैक्षिक परियोजना हो। सबै व्याख्या अध्ययनका लागि लेखिएका हुन् र व्यक्तिगत परामर्शको विकल्प होइनन्।',
          'This platform is a BCA fourth-semester academic project. All explanations are written for study purposes and are not a substitute for personal consultation.'
      ) ?>
    </section>

    <section id="basic-concepts" class="card" style="margin-bottom:1.25rem">
      <h2><?= e(bilingual_value('आधारभूत अवधारणा', 'Basic Concepts')) ?></h2>
      <?= bilingual(
          'ज्योतिषका चारवटा स्तम्भहरू छन्। ग्रह भनेको सूर्य, चन्द्र र पाँच ग्रहहरूसहित नौ कलात्मक बिन्दु हुन्। राशि भनेको आकाशको १२ भाग, जसमा ग्रहहरू स्थान लिन्छन्। भाव भनेको जन्मकुण्डलीका १२ खण्ड जसले जीवनका विभिन्न पक्षलाई देखाउँछ। नक्षत्र भनेको चन्द्रको चालमा आधारित २७ खण्ड हुन्।',
          'Astrology rests on four pillars. A graha is one of the nine celestial points — the Sun, the Moon and five visible planets. A rashi is one of the twelve divisions of the ecliptic where grahas are placed. A bhava is one of the twelve houses of the birth chart, each governing an area of life. A nakshatra is one of the twenty-seven divisions based on the Moon\u2019s motion.'
      ) ?>
      <?= bilingual(
          'यी चारवटै कुरा मिएर एउटा कुण्डली बन्छ। त्यसैले कुण्डली पढ्नु भनेको यी आधारभूत इकाईहरूलाई बुझ्नु हो।',
          'These four elements together form a birth chart. Reading a chart therefore begins with understanding these basic units.'
      ) ?>
      <p style="margin-top:1rem">
        <a class="btn btn-ghost btn-sm" href="<?= e($base) ?>views/topic.php?category=graha"><?= e(bilingual_value('ग्रह हेर्नुहोस्', 'Browse Grahas')) ?></a>
        <a class="btn btn-ghost btn-sm" href="<?= e($base) ?>views/topic.php?category=bhava"><?= e(bilingual_value('भाव हेर्नुहोस्', 'Browse Bhavas')) ?></a>
      </p>
    </section>

    <section id="fundamentals" class="card" style="margin-bottom:1.25rem">
      <h2><?= e(bilingual_value('ज्योतिषको आधार', 'Astrology Fundamentals')) ?></h2>
      <?= bilingual(
          'कुण्डली बनाउन सबैभन्दा पहिले लग्न निर्धारण गरिन्छ — जन्मको समय र स्थानअनुसार पूर्व आकाशमा उठिएको राशि। लग्नदेखि पहिलो भाव सुरु हुन्छ र घडीको दिशामा बाह्र भाव गणना हुन्छन्।',
          'Building a chart starts with the lagna (Ascendant) — the sign rising in the eastern sky at the moment and place of birth. The first bhava begins at the lagna and the twelve houses are counted in the direction of the Earth\u2019s rotation.'
      ) ?>
      <?= bilingual(
          'त्यसपछि ग्रहहरूलाई भाव र राशिमा राखेर तिनका सम्बन्ध, दृष्टि र योगहरू विश्लेषण गरिन्छ। संयोजन विश्लेषण यही क्रमको सरलीकृत रूप हो — ग्रह र भाव वा ग्रह र राशिको सम्बन्ध एकैसाथ हेर्ने सुविधा।',
          'Grahas are then placed into houses and signs, and their relationships, aspects and yogas are analysed. Combination Analysis is a simplified form of the same process — it lets you inspect a graha against a bhava, or a graha against a rashi, in one step.'
      ) ?>
      <p style="margin-top:1rem">
        <a class="btn btn-primary btn-sm" href="<?= e($base) ?>views/combo.php"><?= e(bilingual_value('संयोजन विश्लेषण खोल्नुहोस्', 'Open Combination Analysis')) ?></a>
      </p>
    </section>

    <section id="learning-path" class="card">
      <h2><?= e(bilingual_value('सिकाइ मार्ग', 'Learning Path')) ?></h2>
      <ul class="plain">
        <li><?= e(bilingual_value('१. ग्रह, राशि र भावको परिचय पढ्नुहोस्।', '1. Read the introduction to grahas, rashis and bhavas.')) ?></li>
        <li><?= e(bilingual_value('२. २७ नक्षत्र र पञ्चाङ्गका अंगहरू बुझ्नुहोस्।', '2. Learn the 27 nakshatras and the parts of the panchanga.')) ?></li>
        <li><?= e(bilingual_value('३. संयोजन विश्लेषणबाट ग्रह–भाव सम्बन्ध अभ्यास गर्नुहोस्।', '3. Practise graha–bhava relations with Combination Analysis.')) ?></li>
        <li><?= e(bilingual_value('४. पाठ्यक्रम लिएर पाठ र क्विज पूरा गर्नुहोस्।', '4. Enrol in a course and complete the lessons and quizzes.')) ?></li>
        <li><?= e(bilingual_value('५. सिकेका विषयहरू नियमित रूपमा पुनरावलोकन गर्नुहोस्।', '5. Revisit the topics you have learned regularly.')) ?></li>
      </ul>
      <p style="margin-top:1rem">
        <a class="btn btn-primary" href="<?= e($base) ?>views/learn.php"><?= e(bilingual_value('पाठ्यक्रमहरू हेर्नुहोस्', 'Browse Courses')) ?></a>
      </p>
    </section>
  </div>
</div>

<?php require __DIR__ . '/../config/includes/footer.php'; ?>
