<section class="session d-flex align-items-center justify-content-center py-0 py-sm-5">
    <form id="recover-form" action="" method="POST" class="validate-form d-flex flex-column align-items-center">
       
    <div class="mt-1 mb-2 d-flex justify-content-center align-items-center">
            <img class="logo" src="<?= $GLOBALS['url-path'] ?>/assets/img/logo.png" alt="<?= $GLOBALS['title'] ?>">
        </div>
        
        <div class="text-center">
            <h1 class="h2 fw-expanded"><?= $GLOBALS['lang-view']['title'] ?></h1>
        </div>

        <div class="input-group mb-3">
            <input id="recover-password-1" type="password" class="form-control custom-password" maxlength="20" placeholder="<?= $GLOBALS['lang-view']['password-1'] ?>" value="" validate-password="true" required>
        </div>

        <div class="input-group mb-3">
            <input id="recover-password-2" type="password" class="form-control custom-password" maxlength="20" placeholder="<?= $GLOBALS['lang-view']['password-2'] ?>" value="" validate-equal="#recover-password-1" required>
        </div>

        <div class="pb-1">
            <button type="submit" id="recover-submit" class="btn custom-btn w-100"><?= $GLOBALS['lang-view']['button'] ?></button>
        </div>

        <input id="recover-code" type="hidden" value="">
        <input id="recover-code-id" type="hidden" value="">
        <input id="recover-toast-password-1" type="hidden" value="<?= $GLOBALS['lang-view']['toast-password-1'] ?>">
        <input id="recover-toast-password-2" type="hidden" value="<?= $GLOBALS['lang-view']['toast-password-2'] ?>">

    </form>
</section>

<section id="recover-success" class="session-message" style="display:none;">
    <div class="message-view">
        <div class="image-view">
            <img src="<?= $GLOBALS['url-path']  ?>/assets/img/web/completed.png" />
            <div class="position-absolute top-0 bottom-0 left-0 right-0">
                <img src="<?= $GLOBALS['url-path']  ?>/assets/img/web/completed-text-<?= $GLOBALS['lang'] ?>.png" />
            </div>
        </div>
        <div class="mt-2 text-view fw-condensed">
            <p class="mt-2 mb-3 fs-5"><?= $GLOBALS['lang-view']['success-message'] ?></p>
            <div class="d-flex mb-3 w-100 justify-content-center">
                <a style="width:calc(100% - 32px); max-width:<?= $GLOBALS['lang-view']['success-btn-width'] ?>;" class="me-2" href="<?= generateRouteLink('public-home') ?>">
                    <button class="w-100 h-100 btn custom-btn" type="button"><?= $GLOBALS['lang-view']['success-home'] ?></button>
                </a>
                <a style="width:calc(100% - 32px); max-width:<?= $GLOBALS['lang-view']['success-btn-width'] ?>;" class="ms-2" href="<?= generateRouteLink('session-login') ?>">
                    <button class="w-100 h-100 btn custom-btn" type="button"><?= $GLOBALS['lang-view']['success-login'] ?></button>
                </a>
            </div>
        </div>
    </div>
</section>

<script type="text/javascript" src="<?= $GLOBALS['url-path'] . $GLOBALS['files']['local']['script']['messages'] ?>"></script>