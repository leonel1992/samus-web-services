<?php require_once __DIR__ . "/../../lang/{$GLOBALS['lang']}/layouts/webBuildingLang.php"; ?>

<section class="message-view">
    <div class="image-view">
        <img src="<?= $GLOBALS['url-path'] ?>/assets/img/web/building.png" />
    </div>
    <div class="text-view">
        <p class="mb-0 display-4 fw-bold fw-expanded custom-text"><?= $GLOBALS['lang-layouts']['building']['title'] ?></p>
        <p class="mb-3 fs-3 fw-bold fw-expanded custom-text"><?= $GLOBALS['lang-layouts']['building']['subtitle'] ?></p>
        <p class="mb-0 fs-5 fw-bold custom-text-message"><?= $GLOBALS['lang-layouts']['building']['message'] ?></p>
    </div>
</section>

<script type="text/javascript" src="<?= $GLOBALS['url-path'] . $GLOBALS['files']['local']['script']['messages'] ?>"></script>
<script type="text/javascript">
    setDimensContainerMessage();
</script>