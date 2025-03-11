<main class="manage-view">
    <div class="container">

        <!-- data -->
        <div id="manage-option-na" data-text="<?= $GLOBALS['lang-view']['view-na'] ?>"></div>
        <div id="manage-delete-question" data-text="<?= $GLOBALS['lang-view']['button-delete-question'] ?>"></div>

        <!-- title -->
         <?php include __DIR__ .'/../../layouts/settingsTitleLayout.php'; ?>
        
        <!-- filter -->
         <?php include __DIR__ .'/../../layouts/settingsFilterLayout.php'; ?>

        <!-- table -->
        <div id="manage-view-table">
            <?php //include __DIR__ . '/../../layouts/manageResponseLayout.php'; ?>
            <div class="table-responsive">
                <table id="manage-table" class="table table-hover align-middle m-0">
                    <thead class="align-middle">
                        <tr>
                            <th scope="col" class="text-center">#</th>
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

        <!-- modal form -->
        <div class="modal fade" id="manage-modal-form" tabindex="-1" aria-labelledby="manage-view-form-label" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-fullscreen-sm-down modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title" id="manage-view-form-label"><?= $GLOBALS['lang-view']['view-title'] ?></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                    </div>
                    <div class="modal-body">
                        <form id="manage-form" class="validate-form">
                            
                            <div class="mb-3 input-group-label">
                                <label for="action" class="form-label"><?= $GLOBALS['lang-view']['form-action-label'] ?></label>
                                <select id="action" class="custom-select form-control" data-placeholder="<?= $GLOBALS['lang-view']['form-action-placeholder'] ?>" validate-value="true" required></select>
                                <div class="invalid-feedback"><?= $GLOBALS['lang-view']['form-action-invalid-feedback'] ?></div>
                            </div>
                            <div class="mb-3 input-group-label">
                                <label for="module" class="form-label"><?= $GLOBALS['lang-view']['form-module-label'] ?></label>
                                <select id="module" class="custom-select form-control" data-placeholder="<?= $GLOBALS['lang-view']['form-module-placeholder'] ?>" validate-value="true" required></select>
                                <div class="invalid-feedback"><?= $GLOBALS['lang-view']['form-module-invalid-feedback'] ?></div>
                            </div>
                            <div class="mb-3 input-group-label">
                                <label for="submodule" class="form-label"><?= $GLOBALS['lang-view']['form-submodule-label'] ?></label>
                                <select id="submodule" class="custom-select form-control" data-placeholder="<?= $GLOBALS['lang-view']['form-submodule-placeholder'] ?>" validate-value="true" disabled></select>
                                <div class="invalid-feedback"><?= $GLOBALS['lang-view']['form-submodule-invalid-feedback'] ?></div>
                            </div>

                            <?php include __DIR__ .'/../../layouts/settingsButtonsLayout.php'; ?>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>
</main>

<?php
echo getScript('new SettingsPermissions()');