<section class="manage-view">

    <?php 
        $BUTTONS = ['table', 'insert', 'delete'];
        include __DIR__ . '/../../menus/navbarManageMenu.php';
    ?>

    <div class="tab-content scrollable">

        <div id="manage-option-na" data-text="<?= $GLOBALS['lang-view']['view-na'] ?>"></div>

        <div id="manage-view-table" class="tab-pane fade show active" role="tabpanel">
            <?php include __DIR__ . '/../../layouts/manageResponseLayout.php'; ?>
            <div class="custom-table-container">
                <div class="table-responsive table-head-sticky">
                    <table id="manage-table" class="table table-filter custom-table no-select align-middle m-0" text-filter="<?= $GLOBALS['lang-view']['table-filter'] ?>">
                        <thead class="align-middle">
                            <tr>
                                <th scope="col" class="px50 text-center">#</th>
                                <th scope="col"><?= $GLOBALS['lang-view']['table-module'] ?></th>
                                <th scope="col"><?= $GLOBALS['lang-view']['table-submodule'] ?></th>
                                <th scope="col"><?= $GLOBALS['lang-view']['table-action'] ?></th>
                                <th></th>
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
                        <div id="input-group-action" class="mb-3 input-group-label">
                            <label for="action" class="input-label fixed"><?= $GLOBALS['lang-view']['form-action-label'] ?></label>
                            <select id="action" class="custom-select form-control" data-placeholder="<?= $GLOBALS['lang-view']['form-action-placeholder'] ?>" validate-value="true" required></select>
                            <div class="invalid-feedback"><?= $GLOBALS['lang-view']['form-action-invalid-feedback'] ?></div>
                        </div>
                        <div id="input-group-module" class="mb-3 input-group-label">
                            <label for="module" class="input-label fixed"><?= $GLOBALS['lang-view']['form-module-label'] ?></label>
                            <select id="module" class="custom-select form-control" data-placeholder="<?= $GLOBALS['lang-view']['form-module-placeholder'] ?>" validate-value="true" required></select>
                            <div class="invalid-feedback"><?= $GLOBALS['lang-view']['form-module-invalid-feedback'] ?></div>
                        </div>
                        <div id="input-group-submodule" class="mb-3 input-group-label">
                            <label for="submodule" class="input-label fixed"><?= $GLOBALS['lang-view']['form-submodule-label'] ?></label>
                            <select id="submodule" class="custom-select form-control" data-placeholder="<?= $GLOBALS['lang-view']['form-submodule-placeholder'] ?>" validate-value="true" disabled></select>
                            <div class="invalid-feedback"><?= $GLOBALS['lang-view']['form-submodule-invalid-feedback'] ?></div>
                        </div>
                    </div>
                    <?php include __DIR__ . '/../../layouts/manageFormButtonsLayout.php'; ?>
                </form>
            </div> 
        </div>

    </div>
</section>

<?php
echo getScript('new SettingsPermissions()');