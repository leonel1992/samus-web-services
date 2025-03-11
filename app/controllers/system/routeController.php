<?php
class RouteController {
    public function url(){
        $lang = VarsData::string('lang');
        $module = VarsData::string('module');
        if ($lang && $module) {
            $url = $GLOBALS['url-path'] .'/';
            if (array_key_exists($module, $GLOBALS['routes'])) {
                if (array_key_exists($lang, $GLOBALS['routes'][$module])) {
                    $url .= $lang . $GLOBALS['routes'][$module][$lang];
                } else {
                    $url .= $GLOBALS['routes'][$module]['es'];
                }
            } else {
                $url .= 'error';
            }
            
            header("Location: $url");
            exit;
        } else {
            header("Location: ". generateRouteLink('public-home'));
            exit;
        }
    }
}