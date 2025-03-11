<?php
require_once __DIR__ . "/../lang/{$GLOBALS['lang']}/controllers/generalLang.php";

class Controller {

    public function renderJson403(): void {
        http_response_code(403);
        self::renderJson(new ResultError($GLOBALS['lang-controllers']['general']['error-403']));
    }

    public function renderJson404(): void {
        http_response_code(404);
        self::renderJson(new ResultError($GLOBALS['lang-controllers']['general']['error-404']));
    }

    public function renderJson(Result $result): void {
        header("Content-Type: application/json; charset=UTF-8");
        $result->print();
        exit;
    }

    public function renderArray(array $list): void {
        header("Content-Type: application/json; charset=UTF-8");
        JSON::print($list, true);
        exit;
    }

    //------------------------------------------------------------------

    public function render401(): void {
        setcookie("LOGIN_VIEW", $_SERVER['REQUEST_URI'], 0, "/");
        $this->setView();
        if ($GLOBALS['web-view']) {
            http_response_code(401);
            header("Error-Title: {$GLOBALS['lang-controllers']['session']['login-error-title']}");
            header("Error-Message: {$GLOBALS['lang-controllers']['session']['login-error-expire-message']}");
            header("Error-Redirect: ". generateRouteLink('session-login'));
        } else {
            header("location: ". generateRouteLink('session-login'));
        } exit;
    }
    
    public function render403(): void {
        http_response_code(403);
        $webInfo = new WebInfo('error', '403');
        self::renderView('public', 'error', '403', $webInfo);
        exit;
    }

    public function render404(): void {
        http_response_code(404);
        $webInfo = new WebInfo('error', '404');
        self::renderView('public', 'error', '404', $webInfo);
        exit;
    }

    public function renderView(string $site, string $folder, string $view, WebInfo $webInfo): void {
        $urlView = __DIR__ . "/../templates/views/{$folder}/{$view}View.php";
        $urlSite = __DIR__ . "/../templates/sites/{$site}Site.php";
        header('Content-Type: text/html; charset=utf-8');

        $webInfo->init();
        $this->setView();

        if ($GLOBALS['web-view']) {
            $GLOBALS['web-info']->headers = [];
            $GLOBALS['web-info']->scripts = [];
            echo '<script type="text/javascript">';
                foreach ($GLOBALS['web-info']->appends as $append) { 
                    echo "$append\n"; 
                } 
            echo '</script>';
            require_once $urlView;
        } else {
            ob_start();
            require_once $urlView;
            $GLOBALS['web-content'] = ob_get_clean();
            require_once $urlSite;
        }
    }

    public function setView(): void {
        $GLOBALS['web-view'] = VarsData::boolean('view');
    }
}

class ControllerPermissions extends Controller {

    public function renderJson(Result $result, bool $valid=true): void {
        $valid ? parent::renderJson($result) : parent::renderJson403();
    }

    public function renderView(string $site, string $folder, string $view, WebInfo $webInfo): void {
        new LoginService();
        if (!isset($_SESSION['user'])) {
            parent::render401();
        } elseif (!$this->isValid('access', $webInfo->module)) {
            parent::render403();
        } parent::renderView($site, $folder, $view, $webInfo);
    }

    public function isValid(string $action, string $module): bool { return true;
        if (Permissions::login()) {
            return Permissions::validate($action, $module);
        } return false;
    }
}