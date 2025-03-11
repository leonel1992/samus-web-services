<div class="dropdown navbar-toggler-dropdown">
    <button id="navbar-dropdown-LANGUAGE" class="navbar-toggler toggler-lang dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
        <span class="toggler-label"><?= strtoupper($GLOBALS['lang']) ?></span>
        <svg><use xlink:href="<?= $GLOBALS['url-path'] ?>/assets/icons/languages.svg#svg-lang-<?= $GLOBALS['lang'] ?>"/></svg>
    </button>
    <ul class="dropdown-menu dropdown-menu-end">
        <?php foreach ($GLOBALS['languages'] as $item) {
            $disabled = !$item['active'] ? 'disabled' : '';
            echo '<li class="d-inline">
                <a class="dropdown-item load-lang '. $disabled .'" lang="'. $item['lang'] .'" href="#" >
                    <svg><use xlink:href="'. $GLOBALS['url-path'] .'/assets/icons/languages.svg#svg-lang-'. $item['lang'] .'"/></svg>
                    <span>'. $item['name'] .'</span>
                </a>
            </li>';
        } ?>
    </ul>
</div>