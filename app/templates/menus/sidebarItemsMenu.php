<?php

$sidebarItems = [

    'account' => [
        "module" => 'account',
        "link" => $GLOBALS['routes']['account'][$GLOBALS['lang']],
        "title" => $GLOBALS['lang-menu']['sidebar']['account'],
        "icon" => "house-fill",
        "local" => true,
        "items" => null
    ],

    'calculator' => [
        "module" => 'calculator',
        "link" => null, //$GLOBALS['routes']['calculator'][$GLOBALS['lang']],
        "title" => $GLOBALS['lang-menu']['sidebar']['calculator'],
        "icon" => "calculator-fill",
        "local" => true,
        "items" => null /*[
            'calculator-public' => [
                "module" => 'calculator-public',
                "link" => $GLOBALS['routes']['calculator-public'][$GLOBALS['lang']],
                "title" => $GLOBALS['lang-menu']['sidebar']['calculator-public'],
                "local" => true
            ],
            'calculator-office' => [
                "module" => 'calculator-office',
                "link" => $GLOBALS['routes']['calculator-office'][$GLOBALS['lang']],
                "title" => $GLOBALS['lang-menu']['sidebar']['calculator-office'],
                "local" => true
            ],
            'calculator-preference' => [
                "module" => 'calculator-preference',
                "link" => $GLOBALS['routes']['calculator-preference'][$GLOBALS['lang']],
                "title" => $GLOBALS['lang-menu']['sidebar']['calculator-preference'],
                "local" => true
            ],
            'calculator-recharges' => [
                "module" => 'calculator-recharges',
                "link" => $GLOBALS['routes']['calculator-recharges'][$GLOBALS['lang']],
                "title" => $GLOBALS['lang-menu']['sidebar']['calculator-recharges'],
                "local" => true
            ]
        ]*/
    ],

    'flayers' => [
        "module" => 'flayers',
        "link" => null, //$GLOBALS['routes']['flayers'][$GLOBALS['lang']],
        "title" => $GLOBALS['lang-menu']['sidebar']['flayers'],
        "icon" => "file-richtext-fill",
        "local" => true,
        "items" => null /*[
            'flayers-general-rates' => [
                "module" => 'flayers-general-rates',
                "link" => $GLOBALS['routes']['flayers-general-rates'][$GLOBALS['lang']],
                "title" => $GLOBALS['lang-menu']['sidebar']['flayers-general-rates'],
                "local" => true
            ],
            'flayers-country-rates' => [
                "module" => 'flayers-country-rates',
                "link" => $GLOBALS['routes']['flayers-country-rates'][$GLOBALS['lang']],
                "title" => $GLOBALS['lang-menu']['sidebar']['flayers-country-rates'],
                "local" => true
            ],
            'flayers-social-media' => [
                "module" => 'flayers-social-media',
                "link" => $GLOBALS['routes']['flayers-social-media'][$GLOBALS['lang']],
                "title" => $GLOBALS['lang-menu']['sidebar']['flayers-social-media'],
                "local" => true
            ]
        ]*/
    ],

    "divider-1" => ["title" => "divider"],

    'accounts' => [
        "module" => 'accounts',
        "link" => null, //$GLOBALS['routes']['accounts'][$GLOBALS['lang']],
        "title" => $GLOBALS['lang-menu']['sidebar']['accounts'],
        "icon" => "bank2",
        "local" => true,
        "items" => null
    ],
    'customers' => [
        "module" => 'customers',
        "link" => null, //$GLOBALS['routes']['customers'][$GLOBALS['lang']],
        "title" => $GLOBALS['lang-menu']['sidebar']['customers'],
        "icon" => "people-fill",
        "local" => true,
        "items" => null
    ],
    'users' => [
        "module" => 'users',
        "link" => null, //$GLOBALS['routes']['users'][$GLOBALS['lang']],
        "title" => $GLOBALS['lang-menu']['sidebar']['users'],
        "icon" => "person-workspace",
        "local" => true,
        "items" => null
    ],
    'records' => [
        "module" => 'records',
        "link" => null, //$GLOBALS['routes']['records'][$GLOBALS['lang']],
        "title" => $GLOBALS['lang-menu']['sidebar']['records'],
        "icon" => "database-fill",
        "local" => true,
        "items" => null
    ],

    "divider-2" => ["title" => "divider"],

    'security' => [
        "module" => 'security',
        "link" => null, //$GLOBALS['routes']['security'][$GLOBALS['lang']],
        "title" => $GLOBALS['lang-menu']['sidebar']['security'],
        "icon" => "shield-fill-check",
        "local" => true,
        "items" => null
    ],

    'manage' => [
        "module" => 'manage',
        "link" => null, //$GLOBALS['routes']['manage'][$GLOBALS['lang']],
        "title" => $GLOBALS['lang-menu']['sidebar']['manage'],
        "icon" => "sliders",
        "local" => true,
        "items" => null /*[
            'manage-binance' => [
                "module" => 'manage-binance',
                "link" => $GLOBALS['routes']['manage-binance'][$GLOBALS['lang']],
                "title" => $GLOBALS['lang-menu']['sidebar']['manage-binance'],
                "local" => true
            ],
            'manage-rates' => [
                "module" => 'manage-rates',
                "link" => $GLOBALS['routes']['manage-rates'][$GLOBALS['lang']],
                "title" => $GLOBALS['lang-menu']['sidebar']['manage-rates'],
                "local" => true
            ],
        ]*/
    ],

    'settings' => [
        "module" => 'settings',
        "link" => $GLOBALS['routes']['settings'][$GLOBALS['lang']],
        "title" => $GLOBALS['lang-menu']['sidebar']['settings'],
        "icon" => "gear-fill",
        "local" => true,
        "items" => [
            'settings-currencies' => [
                "module" => 'settings-currencies',
                "link" => $GLOBALS['routes']['settings-currencies'][$GLOBALS['lang']],
                "title" => $GLOBALS['lang-menu']['sidebar']['settings-currencies'],
                "local" => true
            ],
            'settings-countries' => [
                "module" => 'settings-countries',
                "link" => $GLOBALS['routes']['settings-countries'][$GLOBALS['lang']],
                "title" => $GLOBALS['lang-menu']['sidebar']['settings-countries'],
                "local" => true
            ],
            'settings-processors' => [
                "module" => 'settings-processors',
                "link" => $GLOBALS['routes']['settings-processors'][$GLOBALS['lang']],
                "title" => $GLOBALS['lang-menu']['sidebar']['settings-processors'],
                "local" => true
            ],
            'settings-payment-methods' => [
                "module" => 'settings-payment-methods',
                "link" => $GLOBALS['routes']['settings-payment-methods'][$GLOBALS['lang']],
                "title" => $GLOBALS['lang-menu']['sidebar']['settings-payment-methods'],
                "local" => true
            ],

            "divider-1" => ["title" => "divider"],

            'settings-actions' => [
                "module" => 'settings-actions',
                "link" => $GLOBALS['routes']['settings-actions'][$GLOBALS['lang']],
                "title" => $GLOBALS['lang-menu']['sidebar']['settings-actions'],
                "local" => true
            ],
            'settings-modules' => [
                "module" => 'settings-modules',
                "link" => $GLOBALS['routes']['settings-modules'][$GLOBALS['lang']],
                "title" => $GLOBALS['lang-menu']['sidebar']['settings-modules'],
                "local" => true
            ],
            'settings-permissions' => [
                "module" => 'settings-permissions',
                "link" => $GLOBALS['routes']['settings-permissions'][$GLOBALS['lang']],
                "title" => $GLOBALS['lang-menu']['sidebar']['settings-permissions'],
                "local" => true
            ],
            'settings-roles' => [
                "module" => 'settings-roles',
                "link" => $GLOBALS['routes']['settings-roles'][$GLOBALS['lang']],
                "title" => $GLOBALS['lang-menu']['sidebar']['settings-roles'],
                "local" => true
            ],
        ]
    ]
];

echo '<ul id="menu-'. $ref .'" class="menu-items nav nav-pills flex-column align-items-start py-3" >';
    $explode = explode('?', $_SERVER['REQUEST_URI']);
    $urlServer = $explode[0];
    $contDivider = 0;
    foreach ($sidebarItems as $key => $menu) 
    {
        if ($menu['title'] === 'divider') {
            if ($contDivider>0) {
                echo '<li class="nav-divider"></li>';
            } $contDivider = 0;
        }

        elseif ($menu['items'] === null && Permissions::validate('access', $menu['module'])) {
            if ($menu['local']) {
                $target = '';
                $loadView = 'load-view';
                $url = $menu['link'] ? $GLOBALS['url-lang'] . $menu['link'] : '#';
            } else {
                $loadView = '';
                $target = 'target="_blank"';
                $url = $menu['link'] ? $menu['link'] : '#';
            }

            $active = $urlServer === $url ? 'active' : '';
            $disabled = $url === '#' ? 'disabled' : '';
            echo '<li class="nav-item">
                <div class="nav-content">
                    <a module="'. $menu['module'] .'" href="'. $url .'" '. $target .' class="nav-link '. $loadView .' '. $active .' '. $disabled .'">
                        <span class="nav-icon"><i class="bi bi-'. $menu['icon'] .'"></i></span>
                        <span class="nav-label">'. $menu['title'] .'</span>
                    </a>
                <div>
            </li>';
            $contDivider++;
        } 

        elseif (Permissions::validate('access', $menu['module'])) {
            $url = $GLOBALS['url-lang'] . $menu['link'];
            $show = strpos($urlServer, $url) === 0 ? 'show' : '';
            $aria = strpos($urlServer, $url) === 0 ? 'true' : 'false';
            $expanded = strpos($urlServer, $url) === 0 ? 'expanded' : '';
            $collapsed = strpos($urlServer, $url) === 0 ? '' : 'collapsed';
            echo '<li class="nav-item">
                <div class="nav-content">
                    <a href="#submenu-'. $ref .'-'. $key .'" class="nav-link caret '. $collapsed .' '. $expanded .'" data-bs-toggle="collapse" aria-expanded="'. $aria .'">
                        <span class="nav-icon"><i class="bi bi-'. $menu['icon'] .'"></i></span>
                        <span class="nav-label">'. $menu['title'] .'</span>
                        <span class="nav-caret"><i class="bi bi-caret-right-fill"></i></span>
                    </a>
                    <ul class="nav-pills flex-column collapse submenu '. $show .'" id="submenu-'. $ref .'-'. $key .'" data-bs-parent="#menu-'. $ref .'">';
                        $contDividerSubmenu = 0;
                        $auxItems = $menu['items'];
                        if (is_array($auxItems)) {
                            foreach ($auxItems as $submenu) {
                                if ($submenu['title'] === 'divider') {
                                    if ($contDividerSubmenu > 0) {
                                        echo '<li class="nav-divider"></li>';
                                    } $contDividerSubmenu = 0;
                                } elseif (Permissions::validate('access', $submenu['module'])) {
                                    if ($submenu['local']) {
                                        $target = '';
                                        $loadView = 'load-view';
                                        $url = $submenu['link'] ? $GLOBALS['url-lang'] . $submenu['link'] : '#';
                                    } else {
                                        $loadView = '';
                                        $target = 'target="_blank"';
                                        $url = $submenu['link'] ? $submenu['link'] : '#';
                                    }
                                    
                                    $active = $urlServer === $url ? 'active' : '';
                                    $disabled = !$submenu['link'] ? 'disabled' : '';
                                    echo '<li class="nav-item">
                                        <a module="'. $submenu['module'] .'" href="'. $url .'" '. $target .' class="nav-link '. $loadView .' '. $active .' '. $disabled .'">
                                            '. $submenu['title'] .'
                                        </a>
                                    </li>';
                                    $contDividerSubmenu++;
                                }
                            }
                        }
                    echo '</ul>
                <div>
            </li>';
            $contDivider++;
        }
    }
echo '</ul>';