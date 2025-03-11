<?php

function generateToken(int $bytes = 32): string {
    return bin2hex(random_bytes($bytes));
}

function generateRouteLink(string $module): string {
    return isset($GLOBALS['url-lang'], $GLOBALS['routes'][$module][$GLOBALS['lang']]) 
        ? $GLOBALS['url-lang'] . $GLOBALS['routes'][$module][$GLOBALS['lang']]
        : '';
}

function generateRouteIconSymbolBootstrap(string $icon): string {
    return isset($GLOBALS['url-path']) 
        ? $GLOBALS['url-path'] . "/assets/icons/bootstrap.svg#$icon"
        : '';
}

// --------------------------------------------

function bigintval(mixed $value, $null=false): int|null {
    if ($null && $value === null) {
        return null;
    } 

    $value = trim((string) $value);
    if (ctype_digit($value)) {
        return (int) $value;
    }
    $value = preg_replace("/[^0-9](.*)$/", '', $value);
    return ctype_digit($value) ? (int) $value : 0;
}

function dateval(mixed $value, $null=false): string|null {
    if ($null && !$value) {
        return null;
    } 

    try {
        $date = new Date(trimstrval($value));
        return $date->formatCompleteMySQL();
    } catch (Exception $e) {
        return '0000-00-00 00:00:00';
    }
}

function strboolval(mixed $value): bool {
    if (is_bool($value)) {
        return $value;
    } elseif (is_numeric($value)) {
        return (bool) $value;
    } else {
        return strtolower(trim((string) $value)) === 'true';
    }
}

function trimstrval(mixed $value, $null=false): string|null {
    if ($null && !$value) {
        return null;
    } return trim(strval($value));
}

function idxval(mixed $value, $null=false): string|null {
    if ($null && !$value) {
        return null;
    } return mb_strtolower(trim($value), 'UTF-8');
}

// --------------------------------------------

function normalizetext(string|null $text): string {
    setlocale(LC_ALL, $GLOBALS['lang-2'] ?? 'en_US.UTF-8');
    $text = iconv('UTF-8', 'ASCII//TRANSLIT', $text);
    return preg_replace('/[^a-zA-Z0-9]/', '', $text);
}