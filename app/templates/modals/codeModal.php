<?php require_once __DIR__ . "/../../lang/' . LANG . '/modals/codeLang.php"; ?>
<div id="modal-code" class="modal modal-code fade" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-fullscreen-sm-down" role="document">
        <div class="modal-content position-relative">
            <div class="modal-body d-flex flex-column align-items-center justify-content-center p-4">
                <div class="image mt-2 w-100 text-center">
                    <img width="200" src="<?= URL_PATH . '/assets/img/web/pad-lock.png' ?>" alt="pad-lock" >
                </div>
                <div class="text mt-3 mb-2 w-100">
                    <p class="text-center d-block m-0"><?= MODAL_CODE_LANG['text'] ?></p>
                </div>
                <div class="input mt-4">
                    <input name="code" type="text" inputmode="numeric" class="form-control text-center custom-text-number" maxlength="6" input-case="code" placeholder="<?= MODAL_CODE_LANG['input'] ?>" input-case="code" required >
                </div>
                <div class="button mt-3 mb-2">
                    <button name="submit-code" type="button" class="w-100 btn custom-btn" data-bs-dismiss="modal" disabled><?= MODAL_CODE_LANG['button'] ?></button>
                </div>
            </div>
            <div class="position-absolute position-absolute top-0 end-0 m-2">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
        </div>
    </div>
</div>