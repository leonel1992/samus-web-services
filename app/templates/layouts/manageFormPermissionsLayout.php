<div class="form-group mt-4">
    <button id="manage-insert" type="button" class="btn custom-btn px-4 disabled d-none"><?= $GLOBALS['lang-view']['button-insert-form'] ?></button>
    <button id="manage-update" type="button" class="btn custom-btn px-4 disabled d-none"><?= $GLOBALS['lang-view']['button-update-form'] ?></button>
    <button id="manage-delete" type="button" class="btn btn-danger px-4 disabled d-none"><?= $GLOBALS['lang-view']['button-delete-form'] ?></button>
</div>

<div id="manage-delete-question" data-text="<?= $GLOBALS['lang-view']['button-delete-question'] ?>"></div>
<div id="manage-delete-permission" data-value="<?= Permissions::validate('delete', $GLOBALS['web-info']->module) ? 'true' : 'false' ?>"></div>
<div id="manage-insert-permission" data-value="<?= Permissions::validate('insert', $GLOBALS['web-info']->module) ? 'true' : 'false' ?>"></div>
<div id="manage-update-permission" data-value="<?= Permissions::validate('update', $GLOBALS['web-info']->module) ? 'true' : 'false' ?>"></div>