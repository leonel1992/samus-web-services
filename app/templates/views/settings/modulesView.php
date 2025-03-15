<section class="manage-view psdding-top">

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
                                <th scope="col" class="px40 text-center">#</th>
                                <th scope="col" class="min200"><?= $GLOBALS['lang-view']['table-id'] ?></th>
                                <th scope="col" class="min100"><?= $GLOBALS['lang-view']['table-module'] ?></th>
                                <th scope="col" class="min100"><?= $GLOBALS['lang-view']['table-submodule'] ?></th>
                                <th scope="col" class="min250"><?= $GLOBALS['lang-view']['table-link-es'] ?></th>
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
                        <datalist id="modules-datalist"></datalist>
                        <div id="input-group-id" class="input-group-label">
                        <label class="input-label fixed" for="module"><?= $GLOBALS['lang-view']['form-id-label'] ?></label>
                            <select id="id" class="custom-select form-control" data-placeholder="<?= $GLOBALS['lang-view']['form-id-placeholder'] ?>" validate-value="true" required></select>
                            <div class="invalid-feedback"><?= $GLOBALS['lang-view']['form-id-invalid-feedback'] ?></div>
                        </div>
                        <div id="input-group-module" class="input-group-label">
                            <label class="input-label fixed" for="module"><?= $GLOBALS['lang-view']['form-module-label'] ?></label>
                            <input id="module" type="text" class="form-control" placeholder="<?= $GLOBALS['lang-view']['form-module-placeholder'] ?>" list="modules-datalist" maxlength="50" validate-length="3" required> 
                            <div class="invalid-feedback"><?= $GLOBALS['lang-view']['form-module-invalid-feedback'] ?></div>
                        </div>
                        <div id="input-group-submodule" class="input-group-label">
                            <label class="input-label fixed" for="submodule"><?= $GLOBALS['lang-view']['form-submodule-label'] ?></label>
                            <input id="submodule" type="text" class="form-control" placeholder="<?= $GLOBALS['lang-view']['form-submodule-placeholder'] ?>" maxlength="50"> 
                        </div>
                        <div id="input-group-link-es" class="input-group-label">
                            <label class="input-label fixed" for="link-es"><?= $GLOBALS['lang-view']['form-link-es-label'] ?></label>
                            <input id="link-es" type="text" class="form-control" placeholder="<?= $GLOBALS['lang-view']['form-link-es-placeholder'] ?>" maxlength="50" readonly> 
                        </div>
                    </div>
                    <?php include __DIR__ . '/../../layouts/manageFormButtonsLayout.php'; ?>
                </form>
            </div> 
        </div>

    </div>
</section>

<?php
echo getScript('new SettingsModules()');