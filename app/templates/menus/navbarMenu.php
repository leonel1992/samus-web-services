<?php
    require_once __DIR__ . "/../../lang/{$GLOBALS['lang']}/menus/navbarLang.php";

    $explode = explode('?', $_SERVER['REQUEST_URI']);
    $urlServer = $explode[0];

    $dropDownItems = [
        'public-home' => [
            "module" => 'public-home',
            "title" => $GLOBALS['lang-menu']['navbar']['public-home'],
            "icon" => null,
            "link" => $GLOBALS['routes']['public-home'][$GLOBALS['lang']],
            "access" => true,
            "view" => true,
            "local" => true,
            "items" => null
        ],
        // 'panel-home' => [
        //     "module" => 'panel-home',
        //     "title" => $GLOBALS['lang-menu']['navbar']['panel-home'],
        //     "icon" => null,
        //     "link" => $GLOBALS['routes']['panel-home'][$GLOBALS['lang']],
        //     "access" => Permissions::login(),
        //     "view" => false,
        //     "local" => true,
        //     "items" => null
        // ],
        'public-about' => [
            "module" => 'public-about',
            "title" => $GLOBALS['lang-menu']['navbar']['public-about'],
            "icon" => null,
            "link" => $GLOBALS['routes']['public-about'][$GLOBALS['lang']],
            "access" => true,
            "local" => true,
            "view" => true,
            "items" => null
        ],
        'public-contact' => [
            "module" => 'public-contact',
            "title" => $GLOBALS['lang-menu']['navbar']['public-contact'],
            "icon" => null,
            "link" => $GLOBALS['routes']['public-contact'][$GLOBALS['lang']],
            "access" => true,
            "local" => true,
            "view" => true,
            "items" => null
        ],
        // 'LANGUAGE' => [
        //     "module" => 'LANGUAGE',
        //     "title" => strtoupper($GLOBALS['lang']),
        //     "icon" => null,
        //     "link" => "#",
        //     "access" => true,
        //     "items" => $GLOBALS['languages']
        // ]
    ];
    
    $buttonItems = [
        // 'button-login' => [
        //     "text" => $GLOBALS['lang-menu']['navbar']['button-login'],
        //     "link" => $GLOBALS['routes']['session-login'][$GLOBALS['lang']]
        // ],
        // 'button-register' => [
        //     "text" => $GLOBALS['lang-menu']['navbar']['button-register'],
        //     "link" => $GLOBALS['routes']['session-register'][$GLOBALS['lang']]
        // ]
    ];
?>

<header>
    <nav class="navbar navbar-expand-md fixed-top">
        <div class="container-fluid">
            
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#menuDropdown" aria-controls="menuDropdown" aria-expanded="false" aria-label="Menu">
                <i class="bi bi-list"></i>
            </button>
            
            <a class="navbar-brand ms-2" href="<?= $GLOBALS['url-lang'] . $GLOBALS['routes']['public-home'][$GLOBALS['lang']] ?>">
                <img src="<?= $GLOBALS['url-path'] ?>/assets/img/logo-back-white.png" class="d-inline-block align-top" alt="">
                <span class="label text-uppercase"><?= $GLOBALS['title'] ?></span>
            </a>
            
            <div class="d-md-none ms-auto">
                <?php include __DIR__ . '/togglerLanguageMenu.php'; ?>
            </div>

            <div class="d-md-none ms-1">
                <?php if (Permissions::login()) {
                    include __DIR__ . '/togglerAvatarMenu.php'; 
                } ?>
            </div>

            <div class="collapse navbar-collapse" id="menuDropdown">
                <ul class="navbar-nav ms-auto">
                    <?php foreach ($dropDownItems as $key => $menu) {
                        if ($menu['link'] === null || $menu['items'] === null && $menu['access']) {
                            if ($menu['local']) {
                                $target = '';
                                $loadView = $menu['view'] ? 'load-view' : '';
                                $url = $menu['link'] ? $GLOBALS['url-lang'] . $menu['link'] : '#';
                            } else {
                                $loadView = '';
                                $target = 'target="_blank"';
                                $url = $menu['link'] ? $menu['link'] : '#';
                            }

                            $active = $urlServer === $url ? 'active' : '';
                            $disabled = $url === '#' ? 'disabled' : '';
                            echo '<li class="nav-item">
                                <div class="nav-content mx-lg-2">
                                    <a module="'. $menu['module'] .'" href="' . $url . '" '. $target .' class="nav-link '. $loadView .' '. $active .' '. $disabled .'">
                                        <span class="nav-icon"><i class="bi bi-' . $menu['icon'] . '"></i></span>
                                        <span class="nav-label">' . $menu['title'] . '</span>
                                    </a>
                                </div>
                            </li>';
                        } else if($menu['access']) {
                            $url = $GLOBALS['url-lang'] . $menu['link'];
                            $display = $menu['module']==='LANGUAGE' ? 'd-none d-md-block' : '';
                            echo '<li class="nav-item dropdown mx-lg-2 '. $display .'">
                                <a class="nav-link dropdown-toggle" href="#" id="navbar-dropdown-' . $key . '" role="button" data-bs-toggle="dropdown" aria-expanded="false">';
                                    if ($menu['module']==='LANGUAGE') {
                                        echo '
                                        <span class="nav-label">' . $menu['title'] . '</span>
                                        <span class="nav-lang">
                                            <svg><use xlink:href="'. URL_PATH .'/assets/icons/languages.svg#svg-lang-'. $GLOBALS['lang'] .'"/></svg>
                                        </span>';
                                    } else {
                                        echo '<span class="nav-icon"><i class="bi bi-' . $menu['icon'] . '"></i></span>';
                                        echo '<span class="nav-label">' . $menu['title'] . '</span>';
                                    } 
                                echo '</a>
                                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbar-dropdown-' . $key . '">';

                                $auxItems = $menu['items'];
                                if (is_array($auxItems)) {
                                    foreach ($auxItems as $submenu) {
                                        if ($menu['module']==='LANGUAGE') {
                                            $url = '#';
                                            $lang = '';
                                            $active = '';
                                            $loadLang = '';
                                            $disabled = 'disabled';
                                            if ($submenu['active']) {
                                                $disabled = '';
                                                $loadLang = 'load-lang';
                                                $lang = 'lang="'. $submenu['lang'] .'"';
                                            }
                                        } else {
                                            $lang = '';
                                            $loadLang = '';
                                            $url = $GLOBALS['url-lang'] . $submenu['link'];
                                            $active = $urlServer === $url ? 'active' : '';
                                            $disabled = !$submenu['link'] ? 'disabled' : '';
                                        }
                                        echo '<li>
                                            <a href="' . $url . '" '. $lang .' class="dropdown-item nav-link '. $loadLang .' '. $active .' '. $disabled .'">';
                                                if ($menu['module']==='LANGUAGE') {
                                                    echo '<svg><use xlink:href="'. URL_PATH .'/assets/icons/languages.svg#svg-lang-'. $submenu['lang'] .'"/></svg>';
                                                    echo '<span class="nav-label">' . $submenu['name'] . '</span>';
                                                } else {
                                                    echo '<span class="nav-label">' . $submenu['title'] . '</span>';
                                                }
                                            echo '</a>
                                        </li>';
                                    }
                                }
                            echo '</ul>
                            </li>';
                        }
                    } 
                    
                    if (!Permissions::login()) {
                        echo '<li class="nav-divider"></li>';
                        foreach ($buttonItems as $menu) {
                            $url = $menu['link'] ? $GLOBALS['url-lang'] . $menu['link'] : '#';
                            $disabled = $url === '#' ? 'disabled' : '';
                            echo '<li class="nav-item d-md-none">
                                <div class="nav-content mx-lg-2">
                                    <a href="'. $url .'" class="nav-link important '. $disabled .'">
                                        <span class="nav-label">' . $menu['text'] . '</span>
                                    </a>
                                <div>
                            </li>';
                        }
                    } ?>
                </ul>
                <form class="navbar-btn form-inline text-center d-none d-md-inline">
                    <?php if (!Permissions::login()) {
                        foreach ($buttonItems as $key => $button) {
                            $url = $button['link'] ? $GLOBALS['url-lang'] . $button['link'] : "#";
                            $disabled = !$button['link'] ? 'disabled' : '';
                            echo '<a class="btn custom-btn '. $disabled . '" href="' . $url . '" role="button">
                                <span class="btn-label">' . $button['text'] . '</span>
                            </a>';
                        } 
                    }  ?>
                </form>
            </div>

            <div class="d-none d-md-inline mx-2">
                <?php if (Permissions::login()) {
                    include __DIR__ . '/togglerAvatarMenu.php'; 
                } ?>
            </div>

        </div>
    </nav>
    
    <?php if (Permissions::login()) {
        include __DIR__ . '/sidebarUserMenu.php'; 
    } ?>

</header>