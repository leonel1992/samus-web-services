<?php
class DMController extends ControllerPermissions {
    
    private $folder;

    public function __construct(string $folder) {
        $this->folder = $folder;
    }

    public function loadView(string $view, ?string $module=null, ?string $script=null) {
        $module ??= "{$this->folder}-$view";
        $script ??= $module;

        $webInfo = new WebInfo($this->folder, $view);
        $webInfo->module = $module;
        $webInfo->headers = [];

        $webInfo->scripts = [
            $GLOBALS['files']['local']['script']['inputs'],
            $GLOBALS['files']['local']['script']['forms'],
            $GLOBALS['files']['local']['script']['data'],
            $GLOBALS['files']['local']['script']['manage'],
            $GLOBALS['files']['local']['script']['session'],
            $GLOBALS['files']['local']['script']['session-logout'],
            $GLOBALS['files']['local']['script'][$script] ?? null,
        ];
        
        $this->renderView('panel', $this->folder, $view, $webInfo);
    }
}