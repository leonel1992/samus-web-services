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
                            <th scope="col"><?= $GLOBALS['lang-view']['table-name'] ?></th>
                            <th scope="col"><?= $GLOBALS['lang-view']['table-description'] ?></th>
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

                            <div class="mb-3 input-group-label">
                                <label for="id" class="form-label"><?= $GLOBALS['lang-view']['form-id-label'] ?></label>
                                <input type="text" class="form-control" id="id" placeholder="<?= $GLOBALS['lang-view']['form-id-placeholder'] ?>" maxlength="50" validate-length="3" input-case="key" required>
                                <div class="invalid-feedback"><?= $GLOBALS['lang-view']['form-id-invalid-feedback'] ?></div>
                            </div>
                            <div class="mb-3 input-group-label">
                                <label for="name" class="form-label"><?= $GLOBALS['lang-view']['form-name-label'] ?></label>
                                <input type="text" class="form-control" id="name" placeholder="<?= $GLOBALS['lang-view']['form-name-placeholder'] ?>" maxlength="50" validate-length="3" required>
                                <div class="invalid-feedback"><?= $GLOBALS['lang-view']['form-name-invalid-feedback'] ?></div>
                            </div>
                            <div class="mb-3 input-group-label">
                                <label for="description" class="form-label"><?= $GLOBALS['lang-view']['form-description-label'] ?></label>
                                <textarea class="form-control" id="description" rows="3" placeholder="<?= $GLOBALS['lang-view']['form-description-placeholder'] ?>" maxlength="200"></textarea>
                                <div class="invalid-feedback"><?= $GLOBALS['lang-view']['form-description-invalid-feedback'] ?></div>
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
echo getScript('new SettingsActions()');