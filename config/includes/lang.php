<?php

declare(strict_types=1);

function allowed_langs(): array
{
    return ['np', 'en'];
}

function current_lang(): string
{
    $lang = $_GET['lang'] ?? $_COOKIE['lang'] ?? DEFAULT_LANG;
    $lang = is_string($lang) ? strtolower($lang) : DEFAULT_LANG;

    if (!in_array($lang, allowed_langs(), true)) {
        $lang = DEFAULT_LANG;
    }

    if (($_GET['lang'] ?? null) !== null && $_GET['lang'] !== $lang) {
        setcookie('lang', $lang, [
            'expires'  => time() + 60 * 60 * 24 * 365,
            'path'     => '/',
            'httponly' => false,
            'samesite' => 'Lax',
        ]);
    }

    return $lang;
}

function lang_toggle_url(): string
{
    $flip = current_lang() === 'np' ? 'en' : 'np';
    $query = $_GET;
    $query['lang'] = $flip;

    return strtok((string) ($_SERVER['REQUEST_URI'] ?? ''), '?') . '?' . http_build_query($query);
}

function lang_toggle_label(): string
{
    return current_lang() === 'np' ? 'English' : 'नेपाली';
}

function bilingual(?string $np, ?string $en, bool $block = true): string
{
    $lang = current_lang();
    $np   = trim((string) $np);
    $en   = trim((string) $en);

    if ($lang === 'en') {
        $content = $en !== '' ? $en : $np;
        $class   = $en !== '' ? 'lang-en' : 'lang-np';
    } else {
        $content = $np;
        $class   = 'lang-np';
    }

    if ($content === '') {
        return '';
    }

    $escaped = nl2br(e($content));

    return $block
        ? '<div class="' . $class . '">' . $escaped . '</div>'
        : '<span class="' . $class . '">' . $escaped . '</span>';
}

function bilingual_value(?string $np, ?string $en): string
{
    return current_lang() === 'en' && trim((string) $en) !== ''
        ? trim($en)
        : trim((string) $np);
}

function bi_paragraphs(string $text, bool $indent = true): string
{
    $items = array_filter(array_map('trim', preg_split('/\r\n|\r|\n+/', $text) ?: []));

    if ($items === []) {
        return '<p class="muted">उपलब्ध छैन।</p>';
    }

    $html = '';

    foreach ($items as $item) {
        $html .= $indent
            ? '<li>' . e($item) . '</li>'
            : '<p>' . e($item) . '</p>';
    }

    return $indent
        ? '<ul class="plain">' . $html . '</ul>'
        : $html;
}

function bilingual_paragraphs(?string $np, ?string $en): string
{
    return bi_paragraphs(bilingual_value($np, $en), false);
}
