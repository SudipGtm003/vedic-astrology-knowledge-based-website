<?php

declare(strict_types=1);

function current_lang(): string
{
    // साइट अहिले नेपाली मात्र
    return 'np';
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
