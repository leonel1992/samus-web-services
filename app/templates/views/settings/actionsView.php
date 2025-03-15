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
                                <th scope="col" class="px40 text-center">#</th>
                                <th scope="col" class="min100"><?= $GLOBALS['lang-view']['table-id'] ?></th>
                                <th scope="col" class="min100"><?= $GLOBALS['lang-view']['table-name'] ?></th>
                                <th scope="col" class="min350"><?= $GLOBALS['lang-view']['table-description'] ?></th>
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

                    <div id="form-group-manage-id" class="form-group">
                        <div id="input-group-manage-id" class="input-group-label pb-0">
                            <label class="input-label fixed" for="id"><?= $GLOBALS['lang-view']['form-manage-id-label'] ?></label>
                            <select id="manage-id" class="custom-select form-control" data-placeholder="<?= $GLOBALS['lang-view']['form-manage-id-placeholder'] ?>" validate-value="true" required></select>
                            <div class="invalid-feedback"><?= $GLOBALS['lang-view']['form-manage-id-invalid-feedback'] ?></div>
                        </div>
                    </div>

                    <div id="form-group-manage-data" class="form-group">
                        <div id="input-group-id" class="input-group-label">
                            <label class="input-label" for="id"><?= $GLOBALS['lang-view']['form-id-label'] ?></label>
                            <input id="id" type="text" class="form-control" maxlength="50" validate-length="3" input-case="key" required> 
                            <div class="invalid-feedback"><?= $GLOBALS['lang-view']['form-id-invalid-feedback'] ?></div>
                        </div>
                        <div id="input-group-name" class="input-group-label">
                            <label class="input-label" for="name"><?= $GLOBALS['lang-view']['form-name-label'] ?></label>
                            <input id="name" type="text" class="form-control" maxlength="50" validate-length="3" required> 
                            <div class="invalid-feedback"><?= $GLOBALS['lang-view']['form-name-invalid-feedback'] ?></div>
                        </div>
                        <div id="input-group-description" class="input-group-label">
                            <label class="input-label" for="description"><?= $GLOBALS['lang-view']['form-description-label'] ?></label>
                            <textarea id="description" class="form-control" cols="1" rows="2" maxlength="500"></textarea>
                        </div>
                    </div>

                    <?php include __DIR__ . '/../../layouts/manageFormButtonsLayout.php'; ?>
                </form>
            </div> 
        </div>

    </div>
</section>

<?php
echo getScript('new SettingsActions()');