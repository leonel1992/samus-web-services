
<?php 
    require_once __DIR__ . '/../../../models/db/usersAccountsModel.php';
    $conn = DatabaseService::init();

    $accounts = [];
    $model = new UsersAccountsModel($conn);
    $data = $model->getAll(null, 'id');
    $accounts = $data->data ?? [];
?>

<?php include __DIR__ ."/../../modals/codeModal.php" ?>
<section class="session d-flex align-items-center justify-content-center py-0 py-sm-5">
    <form id="register-form" action="<?= generateRouteLink('session-register') ?>?form=true" method="POST" class="validate-form d-flex flex-column align-items-center">
        
        <div class="mt-1 mb-2 d-flex justify-content-center align-items-center">
            <img class="logo" src="<?= $GLOBALS['url-path'] ?>/assets/img/logo.png" alt="<?= $GLOBALS['title'] ?>">
        </div>

        <div class="mb-2 text-center">
            <h1 class="h2 fw-expanded"><?= $GLOBALS['lang-view']['title'] ?></h1>
        </div>

        <div class="mb-3 w-100">
            <p class="mb-2"><?= $GLOBALS['lang-view']['account'] ?></p>
            <div id="register-account" name="register-account" class="btn-group radio-group w-100" role="group" aria-label="account-type-group">
                <?php foreach ($accounts as $key => $item) {
                    $checked = ($key === 'personal') ? 'checked' : '';
                    echo '<input type="radio" class="btn-check" name="register-account" id="register-account-'. $key .'" value="'. $item['id'] .'" autocomplete="off" '. $checked .' >';
                    echo '<label class="btn custom-outline-btn" for="register-account-'. $key .'">'. $GLOBALS['lang-view']['account-'.$key] .'</label>';
                }?>
            </div>
        </div>

        <div class="input-group mb-3">
            <input id="register-email" type="email" class="form-control text-center" maxlength="50" placeholder="<?= $GLOBALS['lang-view']['email'] ?>" validate-email="true" required />
        </div>

        <div class="form-check custom-form-check w-100 mb-4 ms-1">
            <input class="form-check-input custom-control" type="checkbox" id="register-terms" validate-value="false" validate-check="true" required >
            <label class="form-check-label" for="register-terms"><?= $GLOBALS['lang-view']['terms'] ?></label>
        </div>
 
        <button id="register-submit" type="submit" class="btn custom-btn w-100"><?= $GLOBALS['lang-view']['button'] ?></button>
        
        <input id="register-toast-email" type="hidden" value="<?= $GLOBALS['lang-view']['toast-email'] ?>">
        <input id="register-toast-terms" type="hidden" value="<?= $GLOBALS['lang-view']['toast-terms'] ?>">

    </form>
</section>

<?php
echo getScript('new SessionRegister()');