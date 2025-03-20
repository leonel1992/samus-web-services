<?php include __DIR__ ."/../../modals/codeModal.php" ?>
<section class="session d-flex align-items-center justify-content-center py-0 py-sm-5">
    <form id="login-form" action="" method="POST" class="validate-form d-flex flex-column align-items-center">
        
        <div class="mt-1 mb-2 d-flex justify-content-center align-items-center">
            <img class="logo" src="<?= $GLOBALS['url-path'] ?>/assets/img/logo.png" alt="<?= $GLOBALS['title'] ?>">
        </div>

        <div class="mb-2 text-center">
            <h1 class="h2 fw-expanded"><?= $GLOBALS['lang-view']['title'] ?></h1>
        </div>

        <div class="input-group mb-3">
            <span class="input-group-text">
                <svg class="bi" width="26" height="26" fill="currentColor">
                    <use xlink:href="<?= $GLOBALS['url-path'] ?>/assets/icons/bootstrap.svg#person"/>
                </svg>
            </span>
            <input id="login-email" type="email" class="form-control" maxlength="50" placeholder="<?= $GLOBALS['lang-view']['email'] ?>" value="<?= $_SESSION['data-giros']['user'] ?? null ?>" validate-email="true" required />
        </div>

        <div class="input-group mb-3">
            <span class="input-group-text">
                <svg class="bi" width="26" height="26" fill="currentColor">
                    <use xlink:href="<?= $GLOBALS['url-path'] ?>/assets/icons/bootstrap.svg#lock"/>
                </svg>
            </span>
            <input id="login-password" type="password" class="form-control password custom-password" maxlength="50" placeholder="<?= $GLOBALS['lang-view']['password'] ?>" value="" required />
        </div>

        <div class="form-check custom-form-check w-100 mb-4 ms-1">
            <input class="form-check-input" type="checkbox" value="" id="login-remember" >
            <label class="form-check-label" for="login-remember"><?= $GLOBALS['lang-view']['remember'] ?></label>
        </div>
 
        <button id="login-submit" type="submit" class="btn custom-btn w-100"><?= $GLOBALS['lang-view']['button'] ?></button>
        
        <div class="mt-4 mb-2">
            <p class="m-0 text-center">
                <span><?= $GLOBALS['lang-view']['question'] ?></span> 
                <a href="<?= generateRouteLink('session-register') ?>"><?= $GLOBALS['lang-view']['register'] ?></a> 
            </p>
            <p class="m-0 text-center mt-2">
                <a href="<?= generateRouteLink('session-recover') ?>"><?= $GLOBALS['lang-view']['recover'] ?></a>
            </p>
        </div>
        
    </form>
</section>

<?php 
$redirect = $GLOBALS['web-redirect'];
echo getScript("new SessionLogin('$redirect')"); 