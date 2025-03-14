<?php include __DIR__ ."/../../modals/codeModal.php" ?>

<section class="session d-flex align-items-center justify-content-center py-0 py-sm-5">
    <form id="recover-form" action="<?= generateRouteLink('session-recover') ?>?form=true" method="POST" class="validate-form d-flex flex-column align-items-center">
        
        <div class="mt-1 mb-2 d-flex justify-content-center align-items-center">
            <img class="logo" src="<?= $GLOBALS['url-path'] ?>/assets/img/logo.png" alt="<?= $GLOBALS['title'] ?>">
        </div>

        <div class="mb-2 text-center">
            <h1 class="h2 fw-expanded"><?= $GLOBALS['lang-view']['title'] ?></h1>
        </div>

        <div class="input-group mb-3">
            <input id="recover-email" type="email" class="form-control text-center" maxlength="50" placeholder="<?= $GLOBALS['lang-view']['email'] ?>" validate-email="true" required />
        </div>

        <button id="recover-submit" type="submit" class="btn custom-btn w-100"><?= $GLOBALS['lang-view']['button'] ?></button>
        <input id="recover-toast-error" type="hidden" value="<?= $GLOBALS['lang-view']['toast-error'] ?>">
        
        <div class="mt-1 mb-2">
            <p class="m-0 text-center"><small><?= $GLOBALS['lang-view']['message'] ?></small></p>
        </div>

        <div class="mt-4">
            <p class="m-0 text-center"><?= $GLOBALS['lang-view']['question'] ?></p>
        </div>
        
        <div class="mt-2 d-flex mb-2 w-100 justify-content-center">
            <a style="width:calc(100% - 32px); max-width:<?= $GLOBALS['lang-view']['text-btn-width'] ?>;" class="me-2" href="<?= generateRouteLink('public-home') ?>">
                <button class="w-100 h-100 btn custom-secondary-btn" type="button"><?= $GLOBALS['lang-view']['text-home'] ?></button>
            </a>
            <a style="width:calc(100% - 32px); max-width:<?= $GLOBALS['lang-view']['text-btn-width'] ?>;" class="ms-2" href="<?= generateRouteLink('session-login') ?>">
                <button class="w-100 h-100 btn custom-secondary-btn" type="button"><?= $GLOBALS['lang-view']['text-login'] ?></button>
            </a>
        </div>

    </form>
</section>

<?php
echo getScript('new SessionRecover()');