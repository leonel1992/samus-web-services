<?php
class VarsData {   

    public static function boolean(string $var, bool $default = false): bool {
        return self::getValue($var, $default, fn($v) => filter_var($v, FILTER_VALIDATE_BOOLEAN));
    }

    public static function integer(string $var, ?int $default = null): ?int {
        return self::getValue($var, $default, fn($v) => filter_var($v, FILTER_VALIDATE_INT, FILTER_NULL_ON_FAILURE));
    }

    public static function float(string $var, ?float $default = null): ?float {
        return self::getValue($var, $default, fn($v) => filter_var($v, FILTER_VALIDATE_FLOAT, FILTER_NULL_ON_FAILURE));
    }

    public static function string(string $var, ?string $default = null): ?string {
        return self::getValue($var, $default, fn($v) => is_string($v) ? trim(filter_var($v, FILTER_SANITIZE_STRING)) : null);
    }

    public static function general(string $var, mixed $default = null): mixed {
        return self::getValue($var, $default, fn($v) => $v);
    }

    private static function getValue(string $var, mixed $default, callable $callback): mixed {
        global $_INPUT;
        $sources = [$_INPUT, $_POST, $_GET ?? []];

        foreach ($sources as $source) {
            if (isset($source[$var])) {
                return $callback($source[$var]);
            }
        } return $default;
    }
}
