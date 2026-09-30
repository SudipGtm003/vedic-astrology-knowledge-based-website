<?php

declare(strict_types=1);

require_once __DIR__ . '/security.php';
require_once __DIR__ . '/../db.php';

function rebuild_search_index(): int
{
    execute('TRUNCATE TABLE search_index');

    $count = 0;

    foreach (fetch_all('SELECT id, slug, name_np, name_en, sanskrit_name FROM topics WHERE is_published = 1') as $t) {
        $content = fetch_one(
            'SELECT summary_np, summary_en, characteristics, effects, sanskrit_term, classical_reference
             FROM topic_content WHERE topic_id = :id',
            [':id' => (int) $t['id']]
        ) ?: [];

        $bodyNp = implode(' | ', array_filter([
            $t['name_np'],
            $t['sanskrit_name'],
            $content['summary_np'] ?? '',
            $content['characteristics'] ?? '',
            $content['effects'] ?? '',
            $content['sanskrit_term'] ?? '',
            $content['classical_reference'] ?? '',
        ]));

        $bodyEn = implode(' | ', array_filter([
            $t['name_en'],
            $content['summary_en'] ?? '',
        ]));

        $categoryCode = (string) fetch_column(
            'SELECT c.code FROM topics t JOIN categories c ON c.id = t.category_id WHERE t.id = :id',
            [':id' => (int) $t['id']]
        );

        execute(
            'INSERT INTO search_index (entity_type, entity_id, title, body_np, body_en, url)
             VALUES ("topic", :id, :title, :np, :en, :url)',
            [
                ':id'    => (int) $t['id'],
                ':title' => $t['name_np'] . ' ' . (string) $t['name_en'],
                ':np'    => mb_substr($bodyNp, 0, 60000),
                ':en'    => mb_substr($bodyEn, 0, 60000),
                ':url'   => 'views/topic.php?slug=' . $t['slug'],
            ]
        );

        $count++;
    }

    foreach (fetch_all(
        'SELECT id, slug, title_np, title_en, description FROM courses WHERE is_published = 1'
    ) as $c) {
        execute(
            'INSERT INTO search_index (entity_type, entity_id, title, body_np, body_en, url)
             VALUES ("course", :id, :title, :np, :en, :url)',
            [
                ':id'    => (int) $c['id'],
                ':title' => $c['title_np'] . ' ' . (string) $c['title_en'],
                ':np'    => mb_substr($c['title_np'] . ' | ' . (string) $c['description'], 0, 60000),
                ':en'    => mb_substr((string) $c['title_en'], 0, 60000),
                ':url'   => 'views/learn.php?course=' . $c['slug'],
            ]
        );
        $count++;
    }

    foreach (fetch_all(
        'SELECT l.id, l.slug, l.title_np, l.title_en, l.content_np, l.content_en, c.slug AS course_slug
         FROM lessons l JOIN courses c ON c.id = l.course_id
         WHERE l.is_published = 1'
    ) as $l) {
        execute(
            'INSERT INTO search_index (entity_type, entity_id, title, body_np, body_en, url)
             VALUES ("lesson", :id, :title, :np, :en, :url)',
            [
                ':id'    => (int) $l['id'],
                ':title' => $l['title_np'] . ' ' . (string) $l['title_en'],
                ':np'    => mb_substr($l['title_np'] . ' | ' . $l['content_np'], 0, 60000),
                ':en'    => mb_substr((string) $l['title_en'] . ' | ' . (string) $l['content_en'], 0, 60000),
                ':url'   => 'views/learn.php?course=' . $l['course_slug'] . '&lesson=' . $l['slug'],
            ]
        );
        $count++;
    }

    foreach (fetch_all(
        'SELECT gb.graha_id, gb.bhava_id, g.name_np AS gnp, g.name_en AS gen, g.sanskrit_name AS gs,
                b.name_np AS bnp, b.name_en AS ben, b.sanskrit_name AS bs, gb.interpretation_np
         FROM graha_bhava gb
         JOIN grahas g ON g.id = gb.graha_id
         JOIN bhavas b ON b.id = gb.bhava_id'
    ) as $row) {
        execute(
            'INSERT INTO search_index (entity_type, entity_id, title, body_np, body_en, url)
             VALUES ("combo", :id, :title, :np, :en, :url)',
            [
                ':id'    => $row['graha_id'] * 1000 + $row['bhava_id'],
                ':title' => $row['gnp'] . ' ' . $row['gen'] . ' + ' . $row['bnp'] . ' ' . $row['ben'],
                ':np'    => $row['gnp'] . ' | ' . $row['gs'] . ' | ' . $row['bnp'] . ' | '
                           . $row['bs'] . ' | ' . $row['interpretation_np'],
                ':en'    => $row['gen'] . ' | ' . $row['gs'] . ' | ' . $row['ben'] . ' | ' . $row['bs'],
                ':url'   => 'views/combo.php?g=' . $row['graha_id'] . '&b=' . $row['bhava_id'],
            ]
        );
        $count++;
    }

    foreach (fetch_all(
        'SELECT gr.graha_id, gr.rashi_id, g.name_np AS gnp, g.name_en AS gen, g.sanskrit_name AS gs,
                r.name_np AS rnp, r.name_en AS ren, r.sanskrit_name AS rs, gr.interpretation_np
         FROM graha_rashi gr
         JOIN grahas g ON g.id = gr.graha_id
         JOIN rashis r ON r.id = gr.rashi_id'
    ) as $row) {
        execute(
            'INSERT INTO search_index (entity_type, entity_id, title, body_np, body_en, url)
             VALUES ("combo", :id, :title, :np, :en, :url)',
            [
                ':id'    => $row['graha_id'] * 1000 + 500 + $row['rashi_id'],
                ':title' => $row['gnp'] . ' ' . $row['gen'] . ' + ' . $row['rnp'] . ' ' . $row['ren'],
                ':np'    => $row['gnp'] . ' | ' . $row['gs'] . ' | ' . $row['rnp'] . ' | '
                           . $row['rs'] . ' | ' . $row['interpretation_np'],
                ':en'    => $row['gen'] . ' | ' . $row['gs'] . ' | ' . $row['ren'] . ' | ' . $row['rs'],
                ':url'   => 'views/combo.php?g=' . $row['graha_id'] . '&r=' . $row['rashi_id'],
            ]
        );
        $count++;
    }

    foreach (fetch_all(
        'SELECT id, slug, title_np, grp, intro_np, paras, cat_code FROM mantras'
    ) as $m) {
        $paras  = json_decode((string) $m['paras'], true);
        $lines  = [];
        if (is_array($paras)) {
            foreach ($paras as $block) {
                foreach ((array) ($block['lines'] ?? []) as $line) {
                    $lines[] = (string) $line;
                }
            }
        }
        $bodyNp = implode(' | ', array_filter([
            $m['title_np'],
            $m['grp'],
            $m['intro_np'],
            implode(' ', $lines),
        ]));

        execute(
            'INSERT INTO search_index (entity_type, entity_id, title, body_np, body_en, url)
             VALUES ("mantra", :id, :title, :np, :en, :url)',
            [
                ':id'    => (int) $m['id'],
                ':title' => (string) $m['title_np'] . ' ' . (string) $m['grp'],
                ':np'    => mb_substr($bodyNp, 0, 60000),
                ':en'    => (string) $m['title_np'],
                ':url'   => 'views/mantras.php?m=' . $m['slug'],
            ]
        );
        $count++;
    }

    if (current_user_id() !== null) {
        log_activity((int) current_user_id(), 'rebuild_search_index', 'search_index', $count);
    }

    return $count;
}

function run_search(string $query, int $limit = 30): array
{
    $query = trim($query);

    if ($query === '') {
        return [];
    }

    $bool = preg_replace('/[^\p{L}\p{N}\s\-+]/u', '', $query) ?: '';
    $bool = trim(preg_replace('/\s+/', ' ', $bool) ?: '');

    if ($bool !== '') {
        $terms = array_filter(array_map(
            fn (string $w) => strlen($w) >= 2 ? $w . '*' : '',
            explode(' ', $bool)
        ));

        if ($terms !== []) {
            $booleanExpr = implode(' ', $terms);

            $results = fetch_all(
                "SELECT entity_type, entity_id, title, url,
                        MATCH(title, body_np, body_en) AGAINST(:q1 IN BOOLEAN MODE) AS score,
                        SUBSTRING(REPLACE(REPLACE(body_np, CHAR(10), ' '), CHAR(13), ' '), 1, 180) AS snippet
                 FROM search_index
                 WHERE MATCH(title, body_np, body_en) AGAINST(:q2 IN BOOLEAN MODE)
                 ORDER BY score DESC
                 LIMIT $limit",
                [':q1' => $booleanExpr, ':q2' => $booleanExpr]
            );

            if ($results !== []) {
                return $results;
            }
        }
    }

    $like = '%' . str_replace(['%', '_'], ['\\%', '\\_'], $query) . '%';

    return fetch_all(
        "SELECT entity_type, entity_id, title, url, 0 AS score,
                SUBSTRING(REPLACE(REPLACE(body_np, CHAR(10), ' '), CHAR(13), ' '), 1, 180) AS snippet
         FROM search_index
         WHERE title LIKE :a OR body_np LIKE :b OR body_en LIKE :c
         ORDER BY title
         LIMIT $limit",
        [':a' => $like, ':b' => $like, ':c' => $like]
    );
}

function search_label(string $type): string
{
    return match ($type) {
        'topic'   => 'विषय',
        'combo'   => 'संयोजन',
        'course'  => 'पाठ्यक्रम',
        'lesson'  => 'पाठ',
        'mantra'  => 'मन्त्र',
        default   => 'जानकारी',
    };
}
