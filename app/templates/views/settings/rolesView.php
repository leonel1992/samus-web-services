<section class="manage-view">

    <?php 
        $BUTTONS = ['table', 'insert', 'update', 'delete'];
        include __DIR__ . '/../../menus/navbarManageMenu.php';
    ?>

    <div class="tab-content scrollable">

        <div id="manage-view-table" class="tab-pane fade show active" role="tabpanel">
            <?php include __DIR__ . '/../../layouts/manageResponseLayout.php'; ?>
            <div class="custom-table-container">
                <div class="table-responsive table-head-sticky">
                    <table id="manage-table" class="table table-filter table-update custom-table no-select align-middle m-0" text-filter="<?= $GLOBALS['lang-view']['table-filter'] ?>">
                        <thead class="align-middle">
                            <tr>
                                <th scope="col" class="text-center">#</th>
                                <th scope="col"><?= $GLOBALS['lang-view']['table-id'] ?></th>
                                <th scope="col"><?= $GLOBALS['lang-view']['table-name'] ?></th>
                                <th scope="col"><?= $GLOBALS['lang-view']['table-description'] ?></th>
                                <th colspan="2"></th>
                            </tr>
                        </thead>
                        <tbody style="display:none;"></tbody>
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
                        <div id="input-group-id" class="mb-3 input-group-label">
                            <label for="id" class="input-label fixed"><?= $GLOBALS['lang-view']['form-id-label'] ?></label>
                            <input type="text" class="form-control" id="id" placeholder="<?= $GLOBALS['lang-view']['form-id-placeholder'] ?>" maxlength="50" validate-length="3" input-case="key" required>
                            <div class="invalid-feedback"><?= $GLOBALS['lang-view']['form-id-invalid-feedback'] ?></div>
                        </div>
                        <div id="input-group-name" class="mb-3 input-group-label">
                            <label for="name" class="input-label fixed"><?= $GLOBALS['lang-view']['form-name-label'] ?></label>
                            <input type="text" class="form-control" id="name" placeholder="<?= $GLOBALS['lang-view']['form-name-placeholder'] ?>" maxlength="50" validate-length="3" required>
                            <div class="invalid-feedback"><?= $GLOBALS['lang-view']['form-name-invalid-feedback'] ?></div>
                        </div>
                        <div id="input-group-description" class="mb-3 input-group-label">
                            <label for="description" class="input-label fixed"><?= $GLOBALS['lang-view']['form-description-label'] ?></label>
                            <textarea class="form-control" id="description" rows="3" placeholder="<?= $GLOBALS['lang-view']['form-description-placeholder'] ?>" maxlength="200"></textarea>
                            <div class="invalid-feedback"><?= $GLOBALS['lang-view']['form-description-invalid-feedback'] ?></div>
                        </div>
                    </div>
                    <div id="form-group-manage-permissions" class="mt-3">
                        <p class="mb-2"><?= $GLOBALS['lang-view']['form-permissions-title'] ?></p>
                        <div class="input-group form-control mb-2">
                            <div class="form-check custom-form-check">
                                <input id="permissions-check-all" type="checkbox" class="form-check-input custom-control pb-1">
                                <label class="form-check-label" for="permissions-check-all"><?= $GLOBALS['lang-view']['form-permissions-check-all'] ?></label>
                            </div>
                        </div>
                        <div id="permissions" class="accordion custom-accordion"></div>
                    </div>
                    <?php include __DIR__ . '/../../layouts/manageFormButtonsLayout.php'; ?>
                </form>
            </div> 
        </div>

    </div>
</section>

<?php
echo getScript('new SettingsRoles()');