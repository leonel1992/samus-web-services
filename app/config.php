<?php
    $folderPath = rtrim(dirname($_SERVER['SCRIPT_NAME']),'/');
    $urlPath = $_SERVER['REQUEST_URI'];
    $urlHost = "https://{$_SERVER['HTTP_HOST']}";
    $url = substr($urlPath, strlen($folderPath));
    
    if (strpos($url,'/es/') === 0) {
        $urlCanonical = str_replace('/es', '', "{$urlHost}{$urlPath}");
        header("Location: $urlCanonical");
        exit();
    } else {
        $urlLang = $folderPath;
        $title = 'SITIO WEB';
        $lang2 = 'es_LA';
        $lang = 'es';
    }

    $GLOBALS['lang'] = $lang;
    $GLOBALS['lang-2'] = $lang2;
    $GLOBALS['title'] = $title;
    
    $GLOBALS['url'] = urldecode($url);
    $GLOBALS['url-lang'] = urldecode($urlLang);
    $GLOBALS['url-path'] = $folderPath;
    $GLOBALS['url-host'] = $urlHost;
    
    $GLOBALS['db'] = JSON::open(__DIR__ . '/../.private/db.json');
    $GLOBALS['emails'] = JSON::open(__DIR__ . '/../.private/emails.json');
    
    $GLOBALS['files'] = JSON::open(__DIR__ . '/../data/system/files.json');
    $GLOBALS['routes'] = JSON::open(__DIR__ . '/../data/system/routes.json');
    $GLOBALS['languages'] = JSON::open(__DIR__ . '/../data/system/languages.json');

    global $_INPUT;
    $_INPUT = json_decode(file_get_contents("php://input") , true);