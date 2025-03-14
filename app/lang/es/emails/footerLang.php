<?php
require_once __DIR__ . "/../layouts/webFooterLang.php";
$GLOBALS['lang-email']['footer'] = [
    "contact-text" => 'Contacto',
    "contact-link" => $GLOBALS['url-host'] . generateRouteLink('public-contact'),

    "privacy-text" => "Política de privacidad",
    "privacy-link" => $GLOBALS['url-host'] . generateRouteLink('legal-privacy'),

    "terms-text" => "Términos y condiciones",
    "terms-link" => $GLOBALS['url-host'] . generateRouteLink('legal-terms'),

    "web-title" => "Servicios Samus",
    "web-link" => $GLOBALS['url-host'] . generateRouteLink('public-home'),
    "web-logo" => $GLOBALS['url-host'] . $GLOBALS['url-path'] . "/assets/img/logo-back-white.png",

    "web-slogan" => $GLOBALS['lang-layouts']['footer']['slogan'],
    "web-company" => $GLOBALS['lang-layouts']['footer']['company'],
    "web-copyright" => $GLOBALS['lang-layouts']['footer']['copyright'],
];