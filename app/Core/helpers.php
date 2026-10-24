<?php
declare(strict_types=1);

use App\Core\App;
use App\Core\Auth;
use App\Core\Csrf;
use App\Core\Request;

/** Escape for HTML output. Every dynamic value in a view goes through this. */
function e(mixed $value): string
{
    return htmlspecialchars((string)($value ?? ''), ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

function url(string $path = ''): string
{
    return App::url($path);
}

function csrf(): string
{
    return Csrf::field();
}

function old(array $bag, string $key, mixed $default = ''): string
{
    return e($bag[$key] ?? $default);
}

function errorFor(array $errors, string $key): string
{
    if (empty($errors[$key])) {
        return '';
    }
    return '<div class="invalid-feedback d-block">' . e($errors[$key][0]) . '</div>';
}

function invalid(array $errors, string $key): string
{
    return empty($errors[$key]) ? '' : ' is-invalid';
}

function can(string $permission): bool
{
    return Auth::can($permission);
}

function activeIf(string $prefix): string
{
    $path   = Request::path();
    $prefix = '/' . trim($prefix, '/');
    return ($path === $prefix || str_starts_with($path, $prefix . '/')) ? ' active' : '';
}

function dt(?string $value, string $format = 'd M Y, H:i'): string
{
    if ($value === null || $value === '' || str_starts_with($value, '0000')) {
        return '—';
    }
    $ts = strtotime($value);
    return $ts === false ? '—' : date($format, $ts);
}

function d(?string $value): string
{
    return dt($value, 'j F Y');
}

function ago(?string $value): string
{
    if ($value === null) {
        return '—';
    }
    $ts = strtotime($value);
    if ($ts === false) {
        return '—';
    }
    $diff = time() - $ts;
    return match (true) {
        $diff < 60      => 'just now',
        $diff < 3600    => intdiv($diff, 60) . ' min ago',
        $diff < 86400   => intdiv($diff, 3600) . ' h ago',
        $diff < 2592000 => intdiv($diff, 86400) . ' d ago',
        default         => date('d M Y', $ts),
    };
}

function bytes(int $size): string
{
    $units = ['B', 'KB', 'MB', 'GB'];
    $i = 0;
    $value = (float)$size;
    while ($value >= 1024 && $i < count($units) - 1) {
        $value /= 1024;
        $i++;
    }
    return round($value, $i === 0 ? 0 : 1) . ' ' . $units[$i];
}

function slugify(string $text): string
{
    $text = preg_replace('/[^\p{L}\p{Nd}]+/u', '-', $text) ?? '';
    return trim(mb_strtolower($text), '-') ?: 'item';
}

/** Preserve current query string while changing one parameter. */
function queryWith(array $overrides): string
{
    $params = array_merge($_GET, $overrides);
    $params = array_filter($params, static fn($v) => $v !== '' && $v !== null);
    return $params === [] ? '' : '?' . http_build_query($params);
}

/**
 * Render editor-authored text. Plain text becomes paragraphs; otherwise only a
 * small, safe subset of tags survives, every attribute is dropped, and anything
 * else is removed — so stored content can never introduce script into a page.
 */
function richText(?string $text): string
{
    $text = trim((string)$text);
    if ($text === '') {
        return '';
    }
    if (strip_tags($text) === $text) {
        $paragraphs = preg_split('/\R{2,}/', $text) ?: [];
        return implode("\n", array_map(
            static fn(string $p): string => '<p>' . nl2br(e(trim($p)), false) . '</p>',
            $paragraphs
        ));
    }
    $allowed = '<p><br><strong><b><em><i><u><ul><ol><li><h2><h3><h4><blockquote>';
    $clean   = strip_tags($text, $allowed);
    return preg_replace('/<([a-z0-9]+)\s[^>]*>/i', '<$1>', $clean) ?? '';
}

/** Truncate for table cells and cards. */
function excerpt(?string $text, int $length = 90): string
{
    $text = trim(strip_tags((string)$text));
    return mb_strlen($text) <= $length ? $text : mb_substr($text, 0, $length - 1) . '…';
}

/** URL for a stored file path ("assets/…" or "uploads/…"), with each segment encoded. */
function fileUrl(?string $path): string
{
    $segments = array_map('rawurlencode', explode('/', ltrim((string)$path, '/')));
    return url(implode('/', $segments));
}

/** Escape plain text and turn email addresses in it into mailto: links. */
function withEmailLinks(?string $text): string
{
    return preg_replace(
        '/[A-Za-z0-9._%+-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,}/',
        '<a href="mailto:$0">$0</a>',
        e($text)
    ) ?? e($text);
}
