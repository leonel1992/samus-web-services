<?php
require_once __DIR__ ."/../helpers/html.php";
require_once __DIR__ . "/../lang/{$GLOBALS['lang']}/controllers/breadcrumbLang.php";

class SessionController extends Controller {

    public function __construct() {
        if (!isset($_SESSION['csrf-token'])) {
            $_SESSION['csrf-token'] = generateToken();
        }
    }

    private function page($view, $module) {

        $webInfo = new WebInfo('session', $view);
        $webInfo->module = "session-$module";

        $webInfo->headers = [
            $GLOBALS['files']['local']['style']['forms'],
            $GLOBALS['files']['local']['style']['session'],
        ];

        $webInfo->scripts = [
            $GLOBALS['files']['local']['script']['data'],
            $GLOBALS['files']['local']['script']['forms'],
            $GLOBALS['files']['local']['script']['inputs'],
            $GLOBALS['files']['local']['script']['session'],
            $GLOBALS['files']['local']['script']["session-$module"]
        ];

        $webInfo->breadcrumbs = [[
            'text' => $GLOBALS['lang-controllers']['breadcrumb']['public-home'],
            'link' => $GLOBALS['routes']['public-home'][$GLOBALS['lang']],
        ],[
            'text' => $GLOBALS['lang-controllers']['breadcrumb']["session-$module"],
            'link' => null,
        ]];
        
        $this->renderView('basic', 'session', $view, $webInfo);
    }

    public function login() {

        if (isset($_COOKIE['LOGIN_VIEW']) && $_COOKIE['LOGIN_VIEW']) {
            $GLOBALS['web-redirect'] = $_COOKIE['LOGIN_VIEW'];
        } else {
            $default = generateRouteLink('account-home');
            $GLOBALS['web-redirect'] = VarsData::string('redirect') ?? $default;
        }

        $login = new LoginService();
        if($login->isSuccess()) {
            header("Location: {$GLOBALS['web-redirect']}");
            exit;
        } 
        
        $this->page('login', 'login');
    }

    public function recover() {
        $isForm = VarsData::boolean('form');
        $this->page($isForm ? 'recoverPass' : 'recover', 'recover');
    }

    public function register() {
        $isForm = VarsData::boolean('form');
        $this->page($isForm ? 'registerForm' : 'register', 'register');
    }

}