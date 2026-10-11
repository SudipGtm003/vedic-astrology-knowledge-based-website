<?php

declare(strict_types=1);

/**
 * संयोजन विश्लेषण — config/db.php पछि मात्र include गर्नुहोस्।
 */
function combo_text(string $key): string
{
    static $cache = [];

    if (!array_key_exists($key, $cache)) {
        $cache[$key] = (string) fetch_column(
            'SELECT body FROM combo_texts WHERE text_key = :k',
            [':k' => $key]
        );
    }

    return $cache[$key];
}

/** template मा {$p} जस्ता slots भर्ने (strtr — सुरक्षित, eval हुँदैन)। */
function combo_fill(string $template, array $vars): string
{
    $map = [];
    foreach ($vars as $key => $value) {
        $map['{$' . $key . '}'] = (string) $value;
    }

    return strtr($template, $map);
}

function combo_relationship(int $grahaId, int $rashiId): array
{
    $row = fetch_one(
        'SELECT rel, strength FROM combo_relations
         WHERE graha_id = :g AND rashi_id = :r',
        [':g' => $grahaId, ':r' => $rashiId]
    );

    if ($row !== null) {
        return ['rel' => $row['rel'], 'strength' => $row['strength']];
    }

    return ['rel' => 'समगृही (Neutral Sign)', 'strength' => 'सामान्य (Neutral - 55%)'];
}

function combo_fal(int $grahaId, string $kind): array
{
    $rows = fetch_all(
        'SELECT item FROM combo_graha_fal
         WHERE graha_id = :g AND kind = :k
         ORDER BY sort_order',
        [':g' => $grahaId, ':k' => $kind]
    );

    return array_column($rows, 'item');
}

/**
 * भाव + राशि + ग्रहको संयोजन विश्लेषण।
 */
function combo_analysis(int $bhavaId, int $rashiId, int $grahaId, bool $retrograde): array
{
    $c = fetch_one('SELECT * FROM combo_bhavas WHERE id = :id', [':id' => $bhavaId])
        ?? fetch_one('SELECT * FROM combo_bhavas ORDER BY id LIMIT 1');
    $d = fetch_one('SELECT * FROM combo_rashis WHERE id = :id', [':id' => $rashiId])
        ?? fetch_one('SELECT * FROM combo_rashis ORDER BY id LIMIT 1');
    $h = fetch_one('SELECT * FROM combo_grahas WHERE id = :id', [':id' => $grahaId])
        ?? fetch_one('SELECT * FROM combo_grahas ORDER BY id LIMIT 1');
    $m = combo_relationship($grahaId, $rashiId);

    $p = explode(' ', $h['name'])[0];
    $v = explode(' ', $c['name'])[0];
    $b = explode(' ', $d['name'])[0];

    $x = combo_fill(combo_text('analysis_intro'), [
        'v' => $v,
        "c['signification']" => $c['signification'],
        'b' => $b,
        "h['name']" => $h['name'],
        'p' => $p,
        "h['role']" => $h['role'],
    ]);

    $z = combo_fill(combo_text('analysis_rashi'), [
        'b' => $b,
        "d['lord']" => $d['lord'],
        "m['rel']" => $m['rel'],
        "d['element']" => $d['element'],
        "d['nature']" => $d['nature'],
        'p' => $p,
    ]);

    if (in_array($bhavaId, [1, 4, 7, 10], true)) {
        $group = 'kendra';
    } elseif (in_array($bhavaId, [5, 9], true)) {
        $group = 'trikona';
    } elseif (in_array($bhavaId, [6, 8, 12], true)) {
        $group = 'dusthana';
    } else {
        $group = 'upachaya';
    }

    $C = (string) fetch_column(
        'SELECT body FROM combo_group_texts WHERE group_key = :k',
        [':k' => $group]
    );

    $j = combo_fill(combo_text('analysis_strength'), [
        "m['strength']" => $m['strength'],
        'C' => $C,
        'p' => $p,
        "h['nature']" => $h['nature'],
    ]);

    $retro = combo_text('retro_prefix')
        . ($retrograde ? combo_text('retro_on') : combo_text('retro_off'));

    $analysis = $x . "\n\n" . $z . "\n\n" . $j . "\n\n" . $retro;

    $bhavesh = fetch_one('SELECT * FROM combo_bhavesh_fal WHERE id = :id', [':id' => $bhavaId])
        ?? fetch_one('SELECT * FROM combo_bhavesh_fal ORDER BY id LIMIT 1');

    return [
        'shloka' => $h['shloka'],
        'shloka_translation' => $h['translation'],
        'analysis' => $analysis,
        'positive_effects' => combo_fal($grahaId, 'positive'),
        'negative_effects' => combo_fal($grahaId, 'negative'),
        'remedies' => combo_fal($grahaId, 'remedy'),
        'relationship' => $m['rel'],
        'strength' => $m['strength'],
        'bhavesh' => [
            'label' => $c['bhavesh_label'],
            'title' => $c['name'],
            'shloka' => $bhavesh['shloka'],
            'shlokaNo' => (int) $bhavesh['shloka_no'],
            'meaning' => $bhavesh['meaning'],
            'commentary' => $bhavesh['commentary'],
        ],
        'source' => combo_text('source'),
    ];
}
