<?php

declare(strict_types=1);

require_once __DIR__ . '/../../config/db.php';
require_once __DIR__ . '/../../config/includes/security.php';

header('Content-Type: application/json; charset=utf-8');

$action = get('action');

if ($action !== 'combination') {
    http_response_code(400);
    echo json_encode(['found' => false, 'error' => 'Unknown action'], JSON_UNESCAPED_UNICODE);
    exit;
}

$types = ['bhava', 'rashi', 'bhava_rashi', 'nakshatra', 'graha_graha', 'dasha'];
$targetType = get('target_type');

if (!in_array($targetType, $types, true)) {
    http_response_code(422);
    echo json_encode(['found' => false, 'error' => 'Invalid parameters'], JSON_UNESCAPED_UNICODE);
    exit;
}

$intParam = static fn (string $key): int => filter_var(get($key), FILTER_VALIDATE_INT) ?: 0;

$grahaId = $intParam('graha_id');
$graha = null;

if ($targetType !== 'dasha') {
    if ($grahaId < 1) {
        http_response_code(422);
        echo json_encode(['found' => false, 'error' => 'Invalid parameters'], JSON_UNESCAPED_UNICODE);
        exit;
    }
    $graha = fetch_one('SELECT id, sanskrit_name, name_np FROM grahas WHERE id = :id', [':id' => $grahaId]);
    if ($graha === null) {
        http_response_code(404);
        echo json_encode(['found' => false, 'error' => 'Not found'], JSON_UNESCAPED_UNICODE);
        exit;
    }
}

$targetNp = '';
$targetSanskrit = '';
$titleNp = '';
$sanskritLine = '';
$sql = '';
$params = [];

switch ($targetType) {
    case 'bhava':
        $targetId = $intParam('target_id');
        if ($targetId < 1) {
            http_response_code(422);
            echo json_encode(['found' => false, 'error' => 'Invalid parameters'], JSON_UNESCAPED_UNICODE);
            exit;
        }
        $target = fetch_one('SELECT id, sanskrit_name, name_np FROM bhavas WHERE id = :id', [':id' => $targetId]);
        if ($target === null) {
            http_response_code(404);
            echo json_encode(['found' => false, 'error' => 'Not found'], JSON_UNESCAPED_UNICODE);
            exit;
        }
        $targetNp = $target['name_np'];
        $targetSanskrit = $target['sanskrit_name'];
        $titleNp = $graha['name_np'] . ' + ' . $targetNp;
        $sanskritLine = $graha['sanskrit_name'] . ' in ' . $targetSanskrit;
        $sql = 'SELECT * FROM graha_bhava WHERE graha_id = :g AND bhava_id = :t';
        $params = [':g' => $grahaId, ':t' => $targetId];
        break;

    case 'rashi':
        $targetId = $intParam('target_id');
        if ($targetId < 1) {
            http_response_code(422);
            echo json_encode(['found' => false, 'error' => 'Invalid parameters'], JSON_UNESCAPED_UNICODE);
            exit;
        }
        $target = fetch_one('SELECT id, sanskrit_name, name_np FROM rashis WHERE id = :id', [':id' => $targetId]);
        if ($target === null) {
            http_response_code(404);
            echo json_encode(['found' => false, 'error' => 'Not found'], JSON_UNESCAPED_UNICODE);
            exit;
        }
        $targetNp = $target['name_np'];
        $targetSanskrit = $target['sanskrit_name'];
        $titleNp = $graha['name_np'] . ' + ' . $targetNp;
        $sanskritLine = $graha['sanskrit_name'] . ' in ' . $targetSanskrit;
        $sql = 'SELECT * FROM graha_rashi WHERE graha_id = :g AND rashi_id = :t';
        $params = [':g' => $grahaId, ':t' => $targetId];
        break;

    case 'bhava_rashi':
        $bhavaId = $intParam('bhava_id');
        $rashiId = $intParam('rashi_id');
        if ($bhavaId < 1 || $rashiId < 1) {
            http_response_code(422);
            echo json_encode(['found' => false, 'error' => 'Invalid parameters'], JSON_UNESCAPED_UNICODE);
            exit;
        }
        $bhava = fetch_one('SELECT id, sanskrit_name, name_np FROM bhavas WHERE id = :id', [':id' => $bhavaId]);
        $rashi = fetch_one('SELECT id, sanskrit_name, name_np FROM rashis WHERE id = :id', [':id' => $rashiId]);
        if ($bhava === null || $rashi === null) {
            http_response_code(404);
            echo json_encode(['found' => false, 'error' => 'Not found'], JSON_UNESCAPED_UNICODE);
            exit;
        }
        $targetNp = $bhava['name_np'] . ' + ' . $rashi['name_np'];
        $targetSanskrit = $bhava['sanskrit_name'] . ' + ' . $rashi['sanskrit_name'];
        $titleNp = $graha['name_np'] . ' + ' . $targetNp;
        $sanskritLine = $graha['sanskrit_name'] . ' in ' . $targetSanskrit;
        $sql = 'SELECT * FROM graha_bhava_rashi WHERE graha_id = :g AND bhava_id = :b AND rashi_id = :r';
        $params = [':g' => $grahaId, ':b' => $bhavaId, ':r' => $rashiId];
        break;

    case 'nakshatra':
        $nakshatraId = $intParam('nakshatra_id');
        if ($nakshatraId < 1) {
            http_response_code(422);
            echo json_encode(['found' => false, 'error' => 'Invalid parameters'], JSON_UNESCAPED_UNICODE);
            exit;
        }
        $target = fetch_one('SELECT id, sanskrit_name, name_np FROM topics WHERE id = :id', [':id' => $nakshatraId]);
        if ($target === null) {
            http_response_code(404);
            echo json_encode(['found' => false, 'error' => 'Not found'], JSON_UNESCAPED_UNICODE);
            exit;
        }
        $targetNp = $target['name_np'];
        $targetSanskrit = $target['sanskrit_name'];
        $titleNp = $graha['name_np'] . ' + ' . $targetNp;
        $sanskritLine = $graha['sanskrit_name'] . ' in ' . $targetSanskrit;
        $sql = 'SELECT * FROM graha_nakshatra WHERE graha_id = :g AND nakshatra_id = :t';
        $params = [':g' => $grahaId, ':t' => $nakshatraId];
        break;

    case 'graha_graha':
        $graha2Id = $intParam('graha2_id');
        if ($graha2Id < 1) {
            http_response_code(422);
            echo json_encode(['found' => false, 'error' => 'Invalid parameters'], JSON_UNESCAPED_UNICODE);
            exit;
        }
        $graha2 = fetch_one('SELECT id, sanskrit_name, name_np FROM grahas WHERE id = :id', [':id' => $graha2Id]);
        if ($graha2 === null) {
            http_response_code(404);
            echo json_encode(['found' => false, 'error' => 'Not found'], JSON_UNESCAPED_UNICODE);
            exit;
        }
        $targetNp = $graha2['name_np'];
        $targetSanskrit = $graha2['sanskrit_name'];
        $titleNp = $graha['name_np'] . ' + ' . $targetNp;
        $sanskritLine = $graha['sanskrit_name'] . ' + ' . $targetSanskrit;
        $sql = 'SELECT * FROM graha_graha WHERE graha_id = :g AND graha2_id = :t';
        $params = [':g' => $grahaId, ':t' => $graha2Id];
        break;

    case 'dasha':
        $mahaId = $intParam('maha_id');
        $antarId = $intParam('antar_id');
        $pratyId = $intParam('praty_id');
        if ($mahaId < 1 || $antarId < 1 || $pratyId < 1) {
            http_response_code(422);
            echo json_encode(['found' => false, 'error' => 'Invalid parameters'], JSON_UNESCAPED_UNICODE);
            exit;
        }
        $maha = fetch_one('SELECT id, sanskrit_name, name_np FROM grahas WHERE id = :id', [':id' => $mahaId]);
        $antar = fetch_one('SELECT id, sanskrit_name, name_np FROM grahas WHERE id = :id', [':id' => $antarId]);
        $praty = fetch_one('SELECT id, sanskrit_name, name_np FROM grahas WHERE id = :id', [':id' => $pratyId]);
        if ($maha === null || $antar === null || $praty === null) {
            http_response_code(404);
            echo json_encode(['found' => false, 'error' => 'Not found'], JSON_UNESCAPED_UNICODE);
            exit;
        }
        $targetNp = 'महादशा ' . $maha['name_np'] . ' → अन्तर्दशा ' . $antar['name_np']
            . ' → प्रत्यन्तर्दशा ' . $praty['name_np'];
        $targetSanskrit = $maha['sanskrit_name'] . ' → ' . $antar['sanskrit_name'] . ' → ' . $praty['sanskrit_name'];
        $titleNp = $targetNp;
        $sanskritLine = $targetSanskrit;
        $sql = 'SELECT * FROM dasha_faladesh
                WHERE maha_id = :m AND antar_id = :a AND praty_id = :p';
        $params = [':m' => $mahaId, ':a' => $antarId, ':p' => $pratyId];
        break;
}

try {
    $combo = $sql !== '' ? fetch_one($sql, $params) : null;
} catch (Throwable $e) {
    $combo = null;
}

if ($combo === null) {
    echo json_encode(['found' => false, 'pending' => true], JSON_UNESCAPED_UNICODE);
    exit;
}

echo json_encode([
    'found'                    => true,
    'title_np'                 => $titleNp,
    'sanskrit_line'            => $sanskritLine,
    'graha_np'                 => $graha['name_np'] ?? '',
    'graha_sanskrit'           => $graha['sanskrit_name'] ?? '',
    'target_np'                => $targetNp,
    'target_sanskrit'          => $targetSanskrit,
    'interpretation_np'        => $combo['interpretation_np'],
    'interpretation_en'        => $combo['interpretation_en'],
    'positive_effects'         => $combo['positive_effects'],
    'challenges'               => $combo['challenges'],
    'career_indication'        => $combo['career_indication'],
    'financial_indication'     => $combo['financial_indication'],
    'relationship_indication'  => $combo['relationship_indication'],
    'classical_interpretation' => $combo['classical_interpretation'],
    'sanskrit_reference'       => $combo['sanskrit_reference'],
    'remedies'                 => $combo['remedies'],
], JSON_UNESCAPED_UNICODE | JSON_INVALID_UTF8_SUBSTITUTE);
