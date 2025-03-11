<?php require_once __DIR__ . "/../../lang/{$GLOBALS['lang']}/menus/sidebarLang.php"; ?>

<nav class="navbar fixed-top px-2">
    <div class="d-flex flex-row align-items-center bd-highlight w-100">

        <button class="navbar-toggler d-none d-md-inline-block" data-bs-toggle="collapse" data-bs-target="#sidebar" type="button">
            <i class="bi bi-list" data-bs-toggle="collapse" data-bs-target="#sidebar"></i>
        </button>

        <button class="navbar-toggler d-inline-block d-md-none" data-bs-toggle="offcanvas" data-bs-target="#offcanvas" type="button">
            <i class="bi bi-list" data-bs-toggle="offcanvas" data-bs-target="#offcanvas"></i>
        </button>

        <a class="navbar-brand ms-2" href="<?= generateRouteLink('public-home') ?>">
            <img src="<?= $GLOBALS['url-path'] ?>/assets/img/logo-back-white.png" class="d-inline-block align-top" alt="">
            <span class="label text-uppercase"><?= $GLOBALS['title'] ?></span>
        </a>

        <div class="ms-auto">
            <?php include __DIR__ . '/togglerLanguageMenu.php'; ?>
        </div>

        <div class="ms-1 me-2">
            <?php include __DIR__ . '/togglerAvatarMenu.php'; ?>
        </div>
        
    </div>
</nav>

<div class="sidebar">
    <div class="sidebar-container container-fluid">
        <div class="row">

            <div id="offcanvas" class="offcanvas offcanvas-start px-0" tabindex="-1">
                <div class="offcanvas-body p-0 items items-sm">
                    <?php
                        $ref = 'offcanvas';
                        include __DIR__ . '/sidebarItemsMenu.php';
                    ?>
                </div>
            </div>

            <div class="col-auto px-0">
                <div id="sidebar" class="collapse collapse-horizontal show items items-lg">
                    <div class="d-flex flex-column align-items-start p-0">
                        <?php
                            $ref = 'sidebar';
                            include __DIR__ . '/sidebarItemsMenu.php';
                        ?>
                    </div>
                </div>
            </div>

            <div id="content" class="col mw-100 px-0 content-sidebar">
                <?= $GLOBALS['web-content'] ?>
            </div>

        </div>
    </div>
</div>

<?php include __DIR__ . '/sidebarUserMenu.php'; ?>