<main class="manage-view">
    <div class="container">

        <!-- data -->
        <div id="manage-delete-question" data-text="<?= $GLOBALS['lang-view']['button-delete-question'] ?>"></div>

        <!-- title -->
         <?php include __DIR__ .'/../../layouts/settingsTitleLayout.php'; ?>
        
        <!-- filter -->
         <?php include __DIR__ .'/../../layouts/settingsFilterLayout.php'; ?>
        
        <!-- table -->
        <div id="manage-view-table">
            <?php //include __DIR__ . '/../../layouts/manageResponseLayout.php'; ?>
            <div class="table-responsive">
                <table id="manage-table" class="table table-hover table-edit align-middle m-0">
                    <thead class="align-middle">
                        <tr>
                            <th scope="col" class="text-center">#</th>
                            <th scope="col"><?= $GLOBALS['lang-view']['table-id'] ?></th>
                            <th scope="col"><?= $GLOBALS['lang-view']['table-module'] ?></th>
                            <th scope="col"><?= $GLOBALS['lang-view']['table-submodule'] ?></th>
                            <th scope="col"><?= $GLOBALS['lang-view']['table-link-es'] ?></th>
                            <th colspan="2"></th>
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
                            <datalist id="modules-datalist"></datalist>

                            <div class="mb-3 input-group-label">
                                <label for="id" class="form-label"><?= $GLOBALS['lang-view']['form-id-label'] ?></label>
                                <select id="id" class="custom-select form-control" data-placeholder="<?= $GLOBALS['lang-view']['form-id-placeholder'] ?>" validate-value="true" required></select>
                                <div class="invalid-feedback"><?= $GLOBALS['lang-view']['form-id-invalid-feedback'] ?></div>
                            </div>
                            <div class="mb-3 input-group-label">
                                <label for="module" class="input-label"><?= $GLOBALS['lang-view']['form-module-label'] ?></label>
                                <input id="module" type="text" class="form-control" placeholder="<?= $GLOBALS['lang-view']['form-module-placeholder'] ?>" list="modules-datalist" maxlength="50" validate-length="3" required> 
                                <div class="invalid-feedback"><?= $GLOBALS['lang-view']['form-module-invalid-feedback'] ?></div>
                            </div>
                            <div class="mb-3 input-group-label">
                                <label for="submodule" class="input-label"><?= $GLOBALS['lang-view']['form-submodule-label'] ?></label>
                                <input id="submodule" type="text" class="form-control" placeholder="<?= $GLOBALS['lang-view']['form-submodule-placeholder'] ?>" maxlength="50"> 
                            </div>
                            <div class="mb-3 input-group-label">
                                <label for="link-es" class="input-label"><?= $GLOBALS['lang-view']['form-link-es-label'] ?></label>
                                <input id="link-es" type="text" class="form-control" placeholder="<?= $GLOBALS['lang-view']['form-link-es-placeholder'] ?>" maxlength="50" disabled> 
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
echo getScript('new SettingsModules()');