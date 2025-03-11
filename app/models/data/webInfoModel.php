<?php
class WebInfo {

    public ?string $module = null;
    public ?string $title = null;
    public ?string $description = null;
    public ?string $canonical = null;
    public ?string $index = null;
    public ?string $type = null;
    public ?string $url = null;
    public ?string $img = null;
    public ?float $imgWidth = null;
    public ?float $imgHeight = null;
    public ?array $headers = null;
    public ?array $scripts = null;
    public ?array $appends = null;
    public mixed $breadcrumbs = null;

    public function __construct(string $folder, string $view) {
        require_once __DIR__ . "/../../lang/{$GLOBALS['lang']}/views/{$folder}/{$view}Lang.php";
    }

    public function init() {
        $this->module ??= '';
        $this->title ??= $GLOBALS['lang-view']['header-title'];
        $this->description ??= $GLOBALS['lang-view']['header-desc'];
        $this->canonical ??=  $this->module ? "{$GLOBALS['url-host']}{$GLOBALS['url-path']}{$GLOBALS['routes'][$this->module]['es']}" : '';
        $this->index ??= 'all';
        $this->type ??= 'website';
        $this->url ??= "{$GLOBALS['url-host']}{$_SERVER['REQUEST_URI']}";
        $this->img ??= "{$GLOBALS['url-host']}{$GLOBALS['url-path']}/assets/img/seo/logo.png";
        $this->imgWidth ??= 1200;
        $this->imgHeight ??= 630;
        $this->headers ??= [];
        $this->scripts ??= [];
        $this->appends ??= $this->getAppends();
        $this->setBreadcrumbs();
        $GLOBALS['web-info'] = $this;
    }

    private function getAppends() {
        $headers = implode("\n\t", [
            "'{$this->title}',",
            "'{$this->description}',",
            "'{$this->canonical}',",
            "'{$this->url}'"
        ]) . "\n";

        $appends = ["appendHeaders($headers);"];
        foreach ($this->headers as $element) {
            if ($element) {
                array_push($appends, 'appendStyle("'. $GLOBALS['url-path'] . $element .'");');
            }
        }
        
        foreach ($this->scripts as $element) {
            if ($element) {
                array_push($appends, 'appendScript("'. $GLOBALS['url-path'] . $element .'");');
            }
        }

        /*if (WEB_BREADCRUMB) {
            foreach (WEB_BREADCRUMB as $element) {
                array_push($appends, 'appendBradCrumbs("'. $GLOBALS['url-path'] . $element .'");');
            }
        } */ 
       
        return $appends;
    }

    private function setBreadcrumbs(): void {
        if ($this->breadcrumbs && is_array($this->breadcrumbs)) {
            $items = [];
            foreach ($this->breadcrumbs as $pos => $values) {
                array_push($items, $this->getBreadcrumbItem($pos, $values));
            } $this->breadcrumbs = [
                "@context" => "https://schema.org",
                "@type" => "BreadcrumbList",
                "itemListElement" => $items,
            ];
        } else {
            $this->breadcrumbs = '';
        }
    }

    private function getBreadcrumbItem(int $pos, array $values): array {
        return $values['link'] ? [
            "@type" => "ListItem",
            "position" => ($pos + 1),
            "name" => $values['text'],
            "item" => $GLOBALS['url-host'] . $GLOBALS['url-lang'] . $values['link']
        ] : [
            "@type" => "ListItem",
            "position" => ($pos + 1),
            "name" => $values['text']
        ];
    }
}
