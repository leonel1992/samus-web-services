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
 
        // PUBLIC HOME 
        if ($url === $GLOBALS['routes']['public-home'][$lang]) {
            $this->controller = 'public'; 
            $this->method = 'home';
            $this->folder = '/';
        }

        // PUBLIC ABOUT 
        elseif ($url === $GLOBALS['routes']['public-about'][$lang]) {
            $this->controller = 'public'; 
            $this->method = 'about';
            $this->folder = '/';
        }

        // SESSION LOGIN 
        elseif ($url === $GLOBALS['routes']['session-login'][$lang]) {
            $this->controller = 'session'; 
            $this->method = 'login';
            $this->folder = '/';
        }

        // SESSION REGISTER 
        elseif ($url === $GLOBALS['routes']['session-register'][$lang]) {
            $this->controller = 'session'; 
            $this->method = 'register';
            $this->folder = '/';
        }

        // SESSION RECOVER 
        elseif ($url === $GLOBALS['routes']['session-recover'][$lang]) {
            $this->controller = 'session'; 
            $this->method = 'recover';
            $this->folder = '/';
        }

        // USER HOME 
        elseif ($url === $GLOBALS['routes']['user-home'][$lang]) {
            $this->controller = 'user'; 
            $this->method = 'home';
            $this->folder = '/';
        }

        // SETTINGS 
        elseif (strpos($url, $GLOBALS['routes']['settings'][$lang]) === 0) {
            $this->controller = 'settings';
            $this->folder = '/';
            $this->method = match ($url) {
                $GLOBALS['routes']['settings-actions'][$lang]     => 'actions',
                $GLOBALS['routes']['settings-modules'][$lang]     => 'modules',
                $GLOBALS['routes']['settings-permissions'][$lang] => 'permissions',
                $GLOBALS['routes']['settings-roles'][$lang]       => 'roles',
                default => null
            };
        }

        // EMAIL-TEMPLATE
        elseif (strpos($url, $GLOBALS['routes']['email-template']) === 0) {
            $this->controller = 'email';
            $this->folder = '/';
            $this->method = match ($url) {
                $GLOBALS['routes']['email-template-login']         => 'login',
                $GLOBALS['routes']['email-template-login-code']    => 'loginCode',
                $GLOBALS['routes']['email-template-register']      => 'register',
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
                        strpos($url, '/data/') === 0 ||
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

        // switch ($n) {
        //     case 2:
        //         $this->folder = '/';
        //         switch ($url) {
        //             // PUBLIC -----------------------------------------------------------------------------------------;
        //             case ROUTES['public-home'][LANG]:    $this->controller = 'public'; $this->method = 'home';    break;
        //             case ROUTES['public-about'][LANG]:   $this->controller = 'public'; $this->method = 'about';   break;
        //             case ROUTES['public-contact'][LANG]: $this->controller = 'public'; $this->method = 'contact'; break;
        //             // SESSION --------------------------------------------------------------------------------------------;
        //             case ROUTES['session-login'][LANG]:    $this->controller = 'session'; $this->method = 'login';    break;
        //             case ROUTES['session-register'][LANG]: $this->controller = 'session'; $this->method = 'register'; break;
        //             case ROUTES['session-recover'][LANG]:  $this->controller = 'session'; $this->method = 'recover';  break;
        //             // PANEL ----------------------------------------------------------------------------------;
        //             case ROUTES['panel-home'][LANG]: $this->controller = 'panel'; $this->method = 'home'; break;
        //             // ERROR ------------------------;
        //             default: $this->matchRouteError();
        //         } break;
            
        //     case 3:
        //         // LEGAL ---------------------------------------------------------
        //         if (strpos($url, ROUTES['legal'][LANG]) === 0) {
        //             $this->folder = '/';
        //             $this->controller = 'public'; 
        //             $this->method = match ($url) {
        //                 ROUTES['legal-cookies'][LANG] => 'legalCookies',
        //                 ROUTES['legal-privacy'][LANG] => 'legalPrivacy',
        //                 ROUTES['legal-terms'][LANG]   => 'legalTerms',
        //                 default                       => 'error',
        //             };
        //         }

        //         // MANAGE -------------------------------------------------------------
        //         elseif (strpos($url, ROUTES['manage'][LANG]) === 0) {
        //             $this->folder = '/';
        //             $this->controller = 'manage'; 
        //             $this->method = match ($url) {
        //                 default                                => 'error',
        //             };
        //         }
                
        //         // SETTINGS -------------------------------------------------------------
        //         elseif (strpos($url, ROUTES['settings'][LANG]) === 0) {
        //             $this->folder = '/';
        //             $this->controller = 'settings'; 
        //             $this->method = match ($url) {
        //                 ROUTES['settings-currencies'][LANG]      => 'currencies',
        //                 ROUTES['settings-countries'][LANG]       => 'countries',
        //                 ROUTES['settings-processors'][LANG]      => 'processors',
        //                 ROUTES['settings-payment-methods'][LANG] => 'paymentMethods',
        //                 //----------------------------------------------------------,
        //                 ROUTES['settings-actions'][LANG]     => 'actions',
        //                 ROUTES['settings-modules'][LANG]     => 'modules',
        //                 ROUTES['settings-permissions'][LANG] => 'permissions',
        //                 ROUTES['settings-roles'][LANG]       => 'roles',
        //                 //---------------------------------------------------,
        //                 default => 'error',
        //             };
        //         }

        //         // ERROR -------------------
        //         else {
        //             $this->matchRouteError();
        //         } break;
            
        //     case 4:
        //         if (strpos($url, '/image/') === 0) {
        //             $this->controller = "image";
        //             $this->folder = "/server/";
        //             $this->method = $this->matchRouteURL($expl[2]);
        //         } else {
        //             $this->controller = $this->matchRouteURL($expl[2]);
        //             $this->folder = "/{$this->matchRouteURL($expl[1])}/";
        //             $this->method = $this->matchRouteURL($expl[3]);
        //             $this->isJson =  match ($this->folder) {
        //                 '/manage/'   => true,
        //                 '/settings/' => true,
        //                 default      => false,
        //             };
        //         } break;
            
        //     default:
        //         $this->matchRouteError();
        // }
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