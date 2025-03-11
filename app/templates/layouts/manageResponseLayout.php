<?php require_once __DIR__ . "/../../lang/{$GLOBALS['lang']}/layouts/manageLang.php" ?>

<div id="response-loading" class="response">
    <div class="loading">
        <div class="spinner-border" role="status"></div>
        <span class="text"><?= $GLOBALS['lang-layouts']['manage']['loading'] ?></span>
    </div>
</div>

<div id="response-empty" class="response">
    <div class="error empty">
        <div class="icon">
            <svg class="bi" fill="currentColor">
                <use xlink:href="<?= $GLOBALS['url-path'] ?>/assets/icons/bootstrap.svg#database-slash"/>
            </svg>
        </div>
        <span class="text fw-bold"><?= $GLOBALS['lang-layouts']['manage']['no-data'] ?></span>
    </div>
</div>

<div id="response-error-data" class="response">
    <div class="error data">
        <div class="icon">
            <svg class="bi" fill="currentColor">
                <use xlink:href="<?= $GLOBALS['url-path'] ?>/assets/icons/bootstrap.svg#database-x"/>
            </svg>
        </div>
        <div class="text text-center">
            <span class="d-block title fw-bold"><?= $GLOBALS['lang-layouts']['manage']['error-data'] ?></span>
            <small><span class="d-block message"></span></small>
        </div>
        <div class="w-100 buttons text-center mt-3">
            <button type="button" class="btn btn-sm btn-danger px-3 mt-1"><?= $GLOBALS['lang-layouts']['manage']['retry'] ?></button>
        </div>
    </div>
</div>