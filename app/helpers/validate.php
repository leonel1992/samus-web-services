<?php

function validateAge(string $value, int $minAge): bool {
    try {
        $timezone = new DateTimeZone('UTC');
        $now = new DateTime('now', $timezone);
        $date = new DateTime($value, $timezone);
        
        $age = $now->format("Y") - $date->format("Y");
        $m = $now->format("m") - $date->format("m");
        $d = $now->format("d") - $date->format("d");
        
        if ($m < 0 || ($m === 0 && $d < 0)) {
            $age--;
        }
        
        return $age >= $minAge;
    } catch (Exception $e) {
        return false;
    }
}


function validateNumber(string $text): bool {
    $pattern = "/^[0-9]$/";
    return preg_match($pattern, $text);
}

function validatePhone(string $text): bool {
    $pattern = "/^[0-9]{10,}$/";
    return preg_match($pattern, $text);
}

function validateName(string $text): bool {
    $pattern = "/^[a-zA-Z äëïöüáéíóúâêîôûàèìòùñÄËÏÖÜÁÉÍÓÚÂÊÎÔÛÀÈÌÒÙÑ]{2,50}$/";
    return preg_match($pattern, $text);
}

function validateEmail(string $text): bool {
    $pattern = "/^[a-zA-Z0-9.!#$%&'*+\/=?^_{|}~-]+@[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,253}[a-zA-Z0-9])?(?:\.[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,253}[a-zA-Z0-9])?)*$/";
    return preg_match($pattern, $text);
}

function validatePassword(string $text): bool {
    $pattern = "/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[ °|¡!¿?@#$%&\(\){}\[\]<>\\\\\/\^\*~\-\+_.,:;=\"']).{8,20}$/";
    return preg_match($pattern, $text);
}

function validateLength(string $text, int $length): bool {
    return mb_strlen($text, 'UTF-8') >= $length;
}