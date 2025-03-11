<title><?= $GLOBALS['web-info']->title ?></title>
<link rel="icon" href="<?= $GLOBALS['url-path'] ?>/favicon.ico">

<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<meta name="description" content="<?= $GLOBALS['web-info']->description ?>">
<meta name="author" content="<?= $GLOBALS['title'] ?>">
<meta name="copyright" content="<?= $GLOBALS['title'] ?>">
<meta name="theme-color" content="#051a2b">
<meta name="csrf-token" content="<?= $_SESSION['csrf-token'] ?>">
<meta charset="UTF-8">

<link rel="canonical" href="<?= $GLOBALS['web-info']->canonical ?>">
<?php foreach ($GLOBALS['languages'] as $lang) {
    if ($lang['active'] && $lang['lang'] !== 'es') {
        $url = $GLOBALS['url-host'] . $GLOBALS['url-path'] ."/{$lang['lang']}". $GLOBALS['routes'][$GLOBALS['web-info']->module]['es'];
        echo "<link rel='alternate' hreflang='{$lang['lang']}' href='{$url}'>";
        echo "\n";
    }
}?>

<meta name="robots" content="<?= $GLOBALS['web-info']->index ?>">
<meta name="googlebot" content="<?= $GLOBALS['web-info']->index ?>">
<meta name="googlebot-news" content="<?= $GLOBALS['web-info']->index ?>">
<meta name="AdsBot-Google" content="<?= $GLOBALS['web-info']->index ?>">

<meta property="og:locale" content="<?= $GLOBALS['lang-2'] ?>">
<meta property="og:type" content="<?= $GLOBALS['web-info']->type ?>">
<meta property="og:title" content="<?= $GLOBALS['web-info']->title ?>">
<meta property="og:description" content="<?= $GLOBALS['web-info']->description ?>">
<meta property="og:url" content="<?= $GLOBALS['web-info']->url ?>">
<meta property="og:site_name" content="<?= $GLOBALS['title'] ?>">
<meta property="og:image" content="<?= $GLOBALS['web-info']->img ?>">
<meta property="og:image:secure_url" content="<?= $GLOBALS['web-info']->img ?>">
<meta property="og:image:type" content="image/png">
<meta property="og:image:width" content="<?= $GLOBALS['web-info']->imgWidth ?>">
<meta property="og:image:height" content="<?= $GLOBALS['web-info']->imgHeight ?>">

<meta name="twitter:card" content="summary">
<meta name="twitter:description" content="<?= $GLOBALS['web-info']->description ?>">
<meta name="twitter:title" content="<?= $GLOBALS['web-info']->title ?>">
<meta name="twitter:site" content="<?= $GLOBALS['title'] ?>">
<meta name="twitter:image" content="<?= $GLOBALS['web-info']->img ?>">
<meta name="twitter:creator" content=""> 

<link rel="stylesheet" type="text/css" href="<?= $GLOBALS['url-path'] . $GLOBALS['files']['lib']['style']['icons'] ?>">
<link rel="stylesheet" type="text/css" href="<?= $GLOBALS['url-path'] . $GLOBALS['files']['lib']['style']['bootstrap'] ?>">
<link rel="stylesheet" type="text/css" href="<?= $GLOBALS['url-path'] . $GLOBALS['files']['lib']['style']['select2'] ?>">
<link rel="stylesheet" type="text/css" href="<?= $GLOBALS['url-path'] . $GLOBALS['files']['lib']['style']['select2-bs'] ?>">

<link rel="stylesheet" type="text/css" href="<?= $GLOBALS['url-path'] . $GLOBALS['files']['local']['style']['menus'] ?>">
<link rel="stylesheet" type="text/css" href="<?= $GLOBALS['url-path'] . $GLOBALS['files']['local']['style']['general'] ?>">
<?php if (isset($GLOBALS['web-info']) && $GLOBALS['web-info']->headers) {
    foreach ($GLOBALS['web-info']->headers as $header) {
        if ($header) {
            echo '<link rel="stylesheet" type="text/css" href="' . $GLOBALS['url-path'] . $header . '">';
            echo "\n";
        }
    }
} ?>

<?php

    $schemaBreadcrumb = $GLOBALS['web-info']->breadcrumbs;

    $schemaWebsite = [
        "@context" => "https://schema.org",
        "@type" =>"WebSite",
        "name" => $GLOBALS['title'],
        "alternateName" => "EM",
        "url" => $GLOBALS['url-host'] . $GLOBALS['url-path'] .'/'
    ];

    // $sameAs = [];
    // foreach (SOCIAL['social'] as $link) {
    //     if ($link) {
    //         array_push($sameAs, $link);
    //     }
    // }
    // foreach (SOCIAL['app'] as $apps) {
    //     foreach ($apps as $link) {
    //         if ($link) {
    //             array_push($sameAs, $link);
    //         }
    //     }
    // }
    
    $schemaOrganization = [
        "@context" => "https://schema.org",
        "@type" => "Organization",
        "name" => $GLOBALS['title'],
        "alternateName" => "EM",
        "url" => $GLOBALS['url-host'] . $GLOBALS['url-path'] . '/',
        "logo" => $GLOBALS['url-host'] . $GLOBALS['url-path'] . '/assets/img/logo.png',
        // "contactPoint" => [
        //     "@type" => "ContactPoint",
        //     "email" => SOCIAL['email']['gmail'],
        //     "contactType" => "customer service"
        // ],
        // "sameAs" => $sameAs
    ];

    $encodeWebsite = json_encode($schemaWebsite, JSON_PRETTY_PRINT);
    $encodeOrganization = json_encode($schemaOrganization, JSON_PRETTY_PRINT);
    $encodeBreadcrumb = json_encode($schemaBreadcrumb, JSON_PRETTY_PRINT);

    echo <<<HTML
    <script type="application/ld+json">
    $encodeWebsite
    </script>

    <script type="application/ld+json">
    $encodeOrganization
    </script>

    <script type="application/ld+json">
    $encodeBreadcrumb
    </script>
    HTML;
?>