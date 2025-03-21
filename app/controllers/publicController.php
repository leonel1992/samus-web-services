<?php
require_once __DIR__ . "/../lang/{$GLOBALS['lang']}/controllers/breadcrumbLang.php";

class PublicController extends Controller {

    protected ?PDO $conn;

    public function __construct(?PDO $conn) {
        $this->conn = $conn;
    }

    // GENERAL -----------------------------------------------

    private function page(string $folder, string $view, string $module, ?string $desc=null, ?array $breadcrumb=null, ?array $headers=null, ?array $scripts=null) {

        $webInfo = new WebInfo($folder, $view);
        $webInfo->module = $module;
        $webInfo->description = $desc;
        $webInfo->headers = $headers;
        $webInfo->scripts = $scripts;
        $webInfo->breadcrumbs = $breadcrumb ?? [[
            'text' => $GLOBALS['lang-controllers']['breadcrumb']['public-home'],
            'link' => $GLOBALS['routes']['public-home'][$GLOBALS['lang']],
        ],[
            'text' => $GLOBALS['lang-controllers']['breadcrumb'][$module],
            'link' => null,
        ]];

        $this->renderView('public', $folder, $view, $webInfo);
    }

    // PUBLIC -----------------------------------------------

    public function home() {
        $this->page('public', 'home', 'public-home', null, [[
            'text' => $GLOBALS['lang-controllers']['breadcrumb']['public-home'],
            'link' => null,
        ]]);
    }

    public function about() {
        $this->page('public', 'about', 'public-about');
    }

    public function contact() {
        $this->page('public', 'contact', 'public-contact');
    }

    // LEGAL -----------------------------------------------

    public function legalCookies() {
        $this->page('legal', 'cookies', 'legal-cookies');
    }
    
    public function legalPrivacy() {
        $this->page('legal', 'privacy', 'legal-privacy');
    }
    
    public function legalTerms() {
        $this->page('legal', 'terms', 'legal-terms');
    }
}