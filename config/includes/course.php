<?php

declare(strict_types=1);

require_once __DIR__ . '/auth.php';

function course_by_slug(string $slug): ?array
{
    if ($slug === '') {
        return null;
    }

    return fetch_one(
        'SELECT id, slug, title_np, title_en, description
         FROM courses WHERE slug = :slug AND is_published = 1 LIMIT 1',
        [':slug' => $slug]
    );
}

function is_enrolled(int $userId, int $courseId): bool
{
    return fetch_column(
        'SELECT id FROM enrollments WHERE user_id = :u AND course_id = :c',
        [':u' => $userId, ':c' => $courseId]
    ) !== null;
}

function enroll_user(int $userId, int $courseId): void
{
    execute(
        'INSERT IGNORE INTO enrollments (user_id, course_id) VALUES (:u, :c)',
        [':u' => $userId, ':c' => $courseId]
    );
}

function course_lessons(int $courseId, ?int $userId = null): array
{
    $lessons = fetch_all(
        'SELECT id, slug, title_np, title_en, sort_order
         FROM lessons WHERE course_id = :c AND is_published = 1
         ORDER BY sort_order',
        [':c' => $courseId]
    );

    if ($userId === null) {
        return $lessons;
    }

    $done = [];
    foreach (fetch_all(
        'SELECT lesson_id FROM lesson_progress
         WHERE user_id = :u AND is_completed = 1',
        [':u' => $userId]
    ) as $row) {
        $done[(int) $row['lesson_id']] = true;
    }

    foreach ($lessons as $i => $lesson) {
        $lessons[$i]['is_completed'] = isset($done[(int) $lesson['id']]);
    }

    return $lessons;
}

function course_stats(int $courseId, int $userId): array
{
    $total = (int) fetch_column(
        'SELECT COUNT(*) FROM lessons WHERE course_id = :c AND is_published = 1',
        [':c' => $courseId]
    );

    $done = $total > 0
        ? (int) fetch_column(
            'SELECT COUNT(*) FROM lesson_progress lp
             JOIN lessons l ON l.id = lp.lesson_id
             WHERE lp.user_id = :u AND l.course_id = :c AND lp.is_completed = 1 AND l.is_published = 1',
            [':u' => $userId, ':c' => $courseId]
        )
        : 0;

    return [
        'total'   => $total,
        'done'    => $done,
        'percent' => $total > 0 ? (int) round($done * 100 / $total) : 0,
    ];
}

function lesson_by_slug(int $courseId, string $slug): ?array
{
    if ($slug === '') {
        return null;
    }

    return fetch_one(
        'SELECT id, course_id, slug, title_np, title_en, content_np, content_en, sort_order
         FROM lessons WHERE course_id = :c AND slug = :s AND is_published = 1 LIMIT 1',
        [':c' => $courseId, ':s' => $slug]
    );
}

function next_lesson(array $lessons, int $currentId): ?array
{
    $found = false;

    foreach ($lessons as $lesson) {
        if ($found) {
            return $lesson;
        }
        if ((int) $lesson['id'] === $currentId) {
            $found = true;
        }
    }

    return null;
}

