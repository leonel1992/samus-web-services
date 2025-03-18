<section class="manage-view">

    <?php 
        $BUTTONS = ['table', 'insert', 'update', 'delete'];
        include __DIR__ . '/../../menus/navbarManageMenu.php';
    ?>

    <div class="tab-content scrollable">

        <div id="manage-code-details" 
            data-placeholder-crypto="<?= $GLOBALS['lang-view']['form-code-placeholder-crypto'] ?>"
            data-placeholder-default="<?= $GLOBALS['lang-view']['form-code-placeholder-default'] ?>"
            data-invalid-feedback-crypto="<?= $GLOBALS['lang-view']['form-code-invalid-feedback-crypto'] ?>"
            data-invalid-feedback-currency="<?= $GLOBALS['lang-view']['form-code-invalid-feedback-currency'] ?>"
            data-invalid-feedback-default="<?= $GLOBALS['lang-view']['form-code-invalid-feedback-default'] ?>"
        ></div>

        <div id="manage-symbol-details" 
            data-placeholder-crypto="<?= $GLOBALS['lang-view']['form-symbol-placeholder-crypto'] ?>"
            data-placeholder-default="<?= $GLOBALS['lang-view']['form-symbol-placeholder-default'] ?>"
            data-invalid-feedback-crypto="<?= $GLOBALS['lang-view']['form-symbol-invalid-feedback-crypto'] ?>"
            data-invalid-feedback-default="<?= $GLOBALS['lang-view']['form-symbol-invalid-feedback-default'] ?>"
        ></div>

        <div id="manage-name-details" 
            data-placeholder-crypto="<?= $GLOBALS['lang-view']['form-name-placeholder-crypto'] ?>"
            data-placeholder-default="<?= $GLOBALS['lang-view']['form-name-placeholder-default'] ?>"
            data-invalid-feedback-crypto="<?= $GLOBALS['lang-view']['form-name-invalid-feedback-crypto'] ?>"
            data-invalid-feedback-default="<?= $GLOBALS['lang-view']['form-name-invalid-feedback-default'] ?>"
        ></div>

        <div id="manage-view-table" class="tab-pane fade show active" role="tabpanel">
            <?php include __DIR__ . '/../../layouts/manageResponseLayout.php'; ?>
            <div class="custom-table-container">
                <div class="table-responsive table-head-sticky">
                    <table id="manage-table" class="table table-filter table-update custom-table no-select align-middle m-0" text-filter="<?= $GLOBALS['lang-view']['table-filter'] ?>">
                        <thead class="align-middle">
                            <tr>
                                <th scope="col" class="px50 text-center">#</th>
                                <th scope="col" class="px100 text-center"><?= $GLOBALS['lang-view']['table-type'] ?></th>
                                <th scope="col" class="px80 text-center"><?= $GLOBALS['lang-view']['table-code'] ?></th>
                                <th scope="col" class="px80 text-center"><?= $GLOBALS['lang-view']['table-symbol'] ?></th>
                                <th scope="col" class="px80 text-center"><?= $GLOBALS['lang-view']['table-digits'] ?></th>
                                <th scope="col" class="min150"><?= $GLOBALS['lang-view']['table-name'] ?></th>
                                <th colspan="2"></th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>

        <div id="manage-view-form" class="tab-pane fade" role="tabpanel">
            <div class="container py-3">
                <h3 class="mb-3 mt-1"><?= $GLOBALS['lang-view']['view-title'] ?></h3>
                <form id="manage-form" class="validate-form mt-3">
                    <?php include __DIR__ . '/../../layouts/manageFormSelectIdLayout.php'; ?>
                    <div id="form-group-manage-data" class="form-group">
                        <div id="input-group-type" class="input-group-label">
                            <label class="input-label fixed" for="type"><?= $GLOBALS['lang-view']['form-type-label'] ?></label>
                            <select id="type" class="custom-select form-control" data-placeholder="<?= $GLOBALS['lang-view']['form-type-placeholder'] ?>" validate-value="true" required></select>
                            <div class="invalid-feedback"><?= $GLOBALS['lang-view']['form-type-invalid-feedback'] ?></div>
                        </div>
                        <div id="input-group-name" class="input-group-label">
                            <label class="input-label fixed" for="name"><?= $GLOBALS['lang-view']['form-name-label'] ?></label>
                            <input id="name" name="name" type="text" class="form-control" placeholder="<?= $GLOBALS['lang-view']['form-name-placeholder-default'] ?>" maxlength="100" validate-length="3" required>
                            <div class="invalid-feedback"><?= $GLOBALS['lang-view']['form-name-invalid-feedback-default'] ?></div>
                        </div>
                        <div class="row">
                            <div class="col-12 col-md-4 pe-sm-2">
                                <div id="input-group-code" class="input-group-label">
                                    <label class="input-label fixed" for="code"><?= $GLOBALS['lang-view']['form-code-label'] ?></label>
                                    <input id="code" name="code" type="text" class="form-control" placeholder="<?= $GLOBALS['lang-view']['form-code-placeholder-default'] ?>" maxlength="20" validate-length="1" input-case="upper" required>
                                    <div class="invalid-feedback"><?= $GLOBALS['lang-view']['form-code-invalid-feedback-default'] ?></div>
                                </div>
                            </div>
                            <div class="col-12 col-md-4 px-sm-2">
                                <div id="input-group-symbol" class="input-group-label">
                                    <label class="input-label fixed" for="symbol"><?= $GLOBALS['lang-view']['form-symbol-label'] ?></label>
                                    <input id="symbol" name="symbol" type="text" class="form-control" placeholder="<?= $GLOBALS['lang-view']['form-symbol-placeholder-default'] ?>" maxlength="20" validate-value="false">
                                    <div class="invalid-feedback"><?= $GLOBALS['lang-view']['form-symbol-invalid-feedback-default'] ?></div>
                                </div>
                            </div>
                            
                            <div class="col-12 col-md-4 ps-sm-2">
                                <div id="input-group-digits" class="input-group-label">
                                    <label class="input-label fixed" for="digits"><?= $GLOBALS['lang-view']['form-digits-label'] ?></label>
                                    <input id="digits" name="digits" type="number" class="form-control" placeholder="<?= $GLOBALS['lang-view']['form-digits-placeholder'] ?>" min="0" max="20" validate-value="true" required>
                                    <div class="invalid-feedback"><?= $GLOBALS['lang-view']['form-digits-invalid-feedback'] ?></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php include __DIR__ . '/../../layouts/manageFormButtonsLayout.php'; ?>
                </form>
            </div> 
        </div>

    </div>
</section>

<?php
echo getScript('new SettingsCurrencies()');