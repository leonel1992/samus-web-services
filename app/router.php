<?php
class Router {
    
    private bool $isJson = false;
    private ?string $controller;
    private ?string $method;
    private ?string $folder;

    public function __construct() { 
        $this->matchRoute();
        $controller = __DIR__ . '/controllers'. $this->folder . $this->controller . 'Controller.php';
        if ($this->method && file_exists($controller)) {
            $this->controller = ucfirst($this->controller) . 'Controller';
            require_once $controller;
        } else {
            $this->method = $this->isJson ? 'renderJson404' : 'render404';
            $this->controller = 'publicController';
            require_once __DIR__ . '/controllers/publicController.php';
        } 
    }

    public function run() {
        $connection = DatabaseService::init();
        $controller = new $this->controller($connection);
        $method = $this->method;

        if (method_exists($controller, $method)) {
            $controller->$method();
        } else {
            require_once __DIR__ . '/controllers/publicController.php';
            $controller = new PublicController($connection);
            $this->isJson ? $controller->renderJson404() : $controller->render404();
        }
    }

    public function matchRoute() {

        if (strpos($GLOBALS['url'], '?') !== false) {
            $expl = explode('?', $GLOBALS['url']);
            $url = mb_strtolower($expl[0]);
        } else {
            $url = mb_strtolower($GLOBALS['url']);
        } 
        
        $lang = $GLOBALS['lang'];
        $expl = explode('/', $url);
        $n = count($expl);

        // PUBLIC 
        if ($url === $GLOBALS['routes']['public-home'][$lang] ||
            $url === $GLOBALS['routes']['public-about'][$lang] ||
            $url === $GLOBALS['routes']['public-contact'][$lang] ) {
            $this->controller = 'public'; 
            $this->folder = '/';
            $this->method = match ($url) {
                $GLOBALS['routes']['public-home'][$lang]  => 'home',
                $GLOBALS['routes']['public-about'][$lang] => 'about',
                $GLOBALS['routes']['public-contact'][$lang] => 'contact'
            };
        }

        // LEGAL
        elseif (strpos($url, $GLOBALS['routes']['legal'][$lang]) === 0) {
            $this->controller = 'public';
            $this->folder = '/';
            $this->method = match ($url) {
                $GLOBALS['routes']['legal-cookies'][$lang] => 'legalCookies',
                $GLOBALS['routes']['legal-privacy'][$lang] => 'legalPrivacy',
                $GLOBALS['routes']['legal-terms'][$lang] => 'legalTerms',
                default => null
            };
        }

        // SESSION 
        elseif ($url === $GLOBALS['routes']['session-login'][$lang] ||
            $url === $GLOBALS['routes']['session-register'][$lang] ||
            $url === $GLOBALS['routes']['session-recover'][$lang] ) {
            $this->controller = 'session'; 
            $this->folder = '/';
            $this->method = match ($url) {
                $GLOBALS['routes']['session-login'][$lang] => 'login',
                $GLOBALS['routes']['session-register'][$lang] => 'register',
                $GLOBALS['routes']['session-recover'][$lang]  => 'recover'
            };
        }
 
        // ACCOUNT 
        elseif ($url === $GLOBALS['routes']['account'][$lang]) {
            $this->controller = 'account'; 
            $this->method = 'home';
            $this->folder = '/';
        }

        // SETTINGS 
        elseif (strpos($url, $GLOBALS['routes']['settings'][$lang]) === 0) {
            $this->controller = 'settings';
            $this->folder = '/';
            $this->method = match ($url) {
                $GLOBALS['routes']['settings-actions'][$lang] => 'actions',
                $GLOBALS['routes']['settings-modules'][$lang] => 'modules',
                $GLOBALS['routes']['settings-permissions'][$lang] => 'permissions',
                $GLOBALS['routes']['settings-roles'][$lang] => 'roles',
                default => null
            };
        }

        // EMAIL-TEMPLATE
        elseif (strpos($url, $GLOBALS['routes']['email-template']) === 0) {
            $this->controller = 'email';
            $this->folder = '/';
            $this->method = match ($url) {
                $GLOBALS['routes']['email-template-login'] => 'login',
                $GLOBALS['routes']['email-template-login-code'] => 'loginCode',
                $GLOBALS['routes']['email-template-register']   => 'register',
                $GLOBALS['routes']['email-template-register-code'] => 'registerCode',
                $GLOBALS['routes']['email-template-recover-code']  => 'recoverCode',
                default => null
            };
        }

        // DEFAULT
        else {
            switch ($n) {
                case 3:
                    if (strpos($url, '/session/') === 0) {
                        $this->controller = "data";
                        $this->method = $this->matchRouteURL($expl[2]);
                        $this->folder = "/session/";
                    } else {
                        $this->matchRouteError();
                    } break;

                case 4:
                    if (strpos($url, '/image/') === 0) {
                        $this->controller = "image";
                        $this->method = $expl[2];
                        $this->folder = "/system/";
                    } elseif (
                        strpos($url, '/system/') === 0 ||
                        strpos($url, '/session/') === 0 ||
                        strpos($url, '/settings/') === 0 ) {
                        $this->controller = $this->matchRouteURL($expl[2]);
                        $this->method = $this->matchRouteURL($expl[3]);
                        $this->folder = "/{$this->matchRouteURL($expl[1])}/";
                        $this->isJson = true;
                    } else {
                        $this->matchRouteError();
                    } break;
                
                default:
                    $this->matchRouteError();
            }
        }
    }
    
    // -----------------------------------------------------------------------

    private function matchRouteError() {
        $this->folder = ''; 
        $this->controller = 'public'; 
        $this->method =  $this->isJson ? 'renderJson404' : 'render404';
    }

    private function matchRouteURL($value){
        $value = ucwords($value,"-");
        $value = lcfirst($value);
        $value = str_replace('-','',$value);
        return $value;
    }
}