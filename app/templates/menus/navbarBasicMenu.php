<header class="d-block">
    <nav class="navbar">
        <div class="container-fluid">
            <a class="navbar-brand ms-2" href="<?= generateRouteLink('public-home') ?>">
                <img src="<?= $GLOBALS['url-path'] ?>/assets/img/logo-back-white.png" class="d-inline-block align-top" alt="">
                <span class="label text-uppercase"><?= $GLOBALS['title'] ?></span>
            </a>

            <div class="ms-auto">
                <?php include __DIR__ . '/togglerLanguageMenu.php'; ?>
            </div>
        </div>
    </nav>
</header>