<?php
// class RouteController {
//     public function url(){
//         $lang = isset($_GET['lang']) ? $_GET['lang'] : null;
//         $module = isset($_GET['module']) ? $_GET['module'] : null;
//         if ($lang && $module) {
//             $url = $GLOBALS['url-path'] .'/';
//             if (array_key_exists($module, $GLOBALS['routes'])) {
//                 if (array_key_exists($lang, $GLOBALS['routes'][$module])) {
//                     $url .= $lang . $GLOBALS['routes'][$module][$lang];
//                 } else {
//                     $url .= $GLOBALS['routes'][$module]['es'];
//                 }
//             } else {
//                 $url .= 'error';
//             }
//             header("Location: $url");
//             exit;
//         } else {
//             header("Location: ". $GLOBALS['url-lang'] . $GLOBALS['routes']['public-home'][$GLOBALS['lang']]);
//             exit;
//         }
//     }
// }