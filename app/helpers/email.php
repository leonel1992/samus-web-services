<?php

function templateEmail(string $file): string {
    $layout = templateEmailLayout();
    $header = templateEmailHeader();
    $footer = templateEmailFooter();
    $content = templateEmailLang($file);
    
    $template = str_replace('[[template-header]]', $header, $layout);
    $template = str_replace('[[template-footer]]', $footer, $template);
    $template = str_replace('[[template-content]]', $content, $template);

    return $template;
}

function templateEmailLayout(): string {
    $filePath = __DIR__ . '/../templates/emails/layoutEmail.html';
    if (file_exists($filePath)) {
        $template = $template = file_get_contents($filePath);
        if ($template) return $template;
    } return '';
}

function templateEmailHeader(): string {
    return templateEmailLang('header');
}

function templateEmailFooter(): string {
    return templateEmailLang('footer');
}

function templateEmailLang(string $file): string {
    require_once __DIR__ . "/../lang/{$GLOBALS['lang']}/emails/{$file}Lang.php";

    $filePath = __DIR__ . "/../templates/emails/{$file}Email.html";
    if (file_exists($filePath)) {
        $template = file_get_contents($filePath);
        if ($template) {
            foreach ($GLOBALS['lang-email'][$file] as $key => $item) {
                $template = str_replace("[[$key]]", $item, $template);
            } return $template;
        }
    } 
    
    return '';
}