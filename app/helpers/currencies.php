<?php

function calculateDecimals(float $num): int {
    if ($num === 0.0) {
        return 2;
    } 
    
    $decimals = 0;
    $scaledNum = $num;

    if ($num >= 10) { 
        $scale = 100; 
    } elseif ($num >= 1) { 
        $scale = 1000; 
    } else { 
        $scale = 100000; 
    }

    while ($decimals < 18 && $scaledNum < $scale) {
        $scaledNum *= 10;
        $decimals++;
    }

    return ($decimals < 2) ? 2 : $decimals;
}

function stringToCurrency(float $num, ?int $decimals = null): string {
    if ($decimals === null) {
        $decimals = calculateDecimals($num);
    } elseif ($decimals === 0) {
        $decimals = 0;
    }

    switch ($GLOBALS['lang']) {
        case 'es':
            $decimalSeparator = ',';
            $thousandSeparator = '.';
            break;

        default:
            $decimalSeparator = '.';
            $thousandSeparator = ',';
            break;
    }

    return number_format($num, $decimals, $decimalSeparator, $thousandSeparator);
}

function formatNumberCompact(float $num): string {
    if ($num >= 1_000_000) {
        return round($num / 1_000_000, 1) . 'M';
    } elseif ($num >= 1_000) {
        return round($num / 1_000, 1) . 'K';
    } return (string) $num;
}
