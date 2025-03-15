<?php
class DMController extends ControllerPermissions {
    
    private $folder;

    public function __construct(string $folder) {
        $this->folder = $folder;
    }

    public function loadView(string $view, ?string $module=null, ?string $script=null, ?array $addHeaders=[], ?array $addScripts=[]) {
        $module ??= "{$this->folder}-$view";
        $script ??= $module;

        $webInfo = new WebInfo($this->folder, $view);
        $webInfo->module = $module;

        $webInfo->headers = array_merge([
            $GLOBALS['files']['local']['style']['tables'],
            $GLOBALS['files']['local']['style']['forms'],
        ], $addScripts);

        $webInfo->scripts = array_merge([
            $GLOBALS['files']['local']['script']['inputs'],
            $GLOBALS['files']['local']['script']['tables'],
            $GLOBALS['files']['local']['script']['forms'],
            $GLOBALS['files']['local']['script']['data'],
            $GLOBALS['files']['local']['script']['manage'],
            $GLOBALS['files']['local']['script']['session'],
            $GLOBALS['files']['local']['script']['session-logout'],
            $GLOBALS['files']['local']['script'][$script] ?? null,
        ], $addScripts);
        
        $this->renderView('panel', $this->folder, $view, $webInfo);
    }
}