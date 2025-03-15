<?php
    require_once __DIR__ . "/../../lang/{$GLOBALS['lang']}/menus/navbarManageLang.php";

    $explode = explode('?', $_SERVER['REQUEST_URI']);
    $urlServer = $explode[0];

    $navbarItems = [
        'table' => [
            "id" => 'tab-table-manage',
            "icon" => 'database',
            "title" => $GLOBALS['lang-menu']['navbar-manage']['table'],
            "access" => Permissions::validate('access'),
            "view" => in_array('table', $BUTTONS),
            "for" => 'manage-view-table'
        ],
        'insert' => [
            "id" => 'tab-insert-manage',
            "icon" => 'database-add',
            "title" => $GLOBALS['lang-menu']['navbar-manage']['insert'],
            "access" => Permissions::validate('insert'),
            "view" => in_array('insert', $BUTTONS),
            "for" => 'manage-view-form'
        ],
        'update' => [
            "id" => 'tab-update-manage',
            "icon" => 'pencil-square',
            "title" => $GLOBALS['lang-menu']['navbar-manage']['update'],
            "access" => Permissions::validate('update'),
            "view" => in_array('update', $BUTTONS),
            "for" => 'manage-view-form'
        ],
        'delete' => [
            "id" => 'tab-delete-manage',
            "icon" => 'trash3',
            "title" => $GLOBALS['lang-menu']['navbar-manage']['delete'],
            "access" => Permissions::validate('delete'),
            "view" => in_array('delete', $BUTTONS),
            "for" => 'manage-view-form'
        ]
    ];

    $countItems = 0;
    foreach ($navbarItems as $item) {
        if ($item['view'] && $item['access']) {
            $countItems++;
        }
    } 
    
    $widthItems = 100;
    if ($countItems > 0) {
        $widthItems /= $countItems;
    }

if ($countItems > 1) {
    echo '<div class="nav-manage">
        <nav id="navbar-manage" class="nav nav-pills nav-fill container p-0" role="tablist">';
            $cont = 0;
            foreach ($navbarItems as $item) {
                $active = ($cont == 0) ? 'active' : '';
                $selected = ($cont == 0) ? 'true' : 'false';
                if ($item['view'] && $item['access']) {
                    $cont++;
                    echo '<a id="'. $item['id'] .'" class="nav-link disabled '. $active .'" data-bs-toggle="tab" data-bs-target="#'. $item['for'] .'" type="button" role="tab" aria-controls="'. $item['for'] .'" aria-selected="'. $selected .'" style="width:'. $widthItems .'%" >
                            <span CLASS="nav-container">
                                <span class="nav-icon"><i class="bi bi-'. $item['icon'] .'"></i></span>
                                <span class="nav-label">'. $item['title'] .'</span>
                            </span>
                        </a>
                    </span>';
                }
            }
        echo '</nav>
    </div>';
}
