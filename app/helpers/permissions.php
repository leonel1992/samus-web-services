<?php
class Permissions {

    public static function validate(string $action, ?string $module=null): bool { return true;
        $module ??= $GLOBALS['web-info']->module;
        $permissionKey = "$action--$module";
        return !empty($_SESSION['permissions'][$permissionKey]['value']);
    }

    public static function login(): bool {
        return !empty($_SESSION['user']);
    }

    //-----------------------------------------------------------------------------

    public static function data(): void {
        $isValid = self::tokenCSRF() && self::request() && self::server();
        if (!$isValid) {
            http_response_code(403);
            header("Content-Type: application/json; charset=UTF-8");
            $result = new ResultError($GLOBALS['lang-controllers']['general']['error-403']);
            $result->print();
            exit;
        }
    }

    public static function tokenCSRF(): bool {
        $token = VarsData::string('csrf_token');
        return isset($_SESSION['csrf-token']) && $_SESSION['csrf-token'] === $token;
    }

    public static function request(): bool {
        header('Access-Control-Allow-Methods: POST');
        return !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] === 'XMLHttpRequest';
    }

    public static function server(): bool {
        $allowedDomains = [
            'https://localhost',
        ];

        $referer = $_SERVER['HTTP_REFERER'] ?? '';
        $origin  = $_SERVER['HTTP_ORIGIN'] ?? '';

        $validReferer = self::isValidDomain($referer, $allowedDomains);
        $validOrigin  = in_array($origin, $allowedDomains, true);

        if ($validReferer && $validOrigin) {
            header('Access-Control-Allow-Headers: Content-Type, Authorization');
            header("Access-Control-Allow-Origin: $origin");
            return true;
        } return false;
    }

    private static function isValidDomain(string $url, array $allowedDomains): bool {
        foreach ($allowedDomains as $domain) {
            if (strpos($url, $domain) === 0) {
                return true;
            }
        } return false;
    }
}
