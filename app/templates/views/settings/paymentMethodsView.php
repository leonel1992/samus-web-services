<?php 
    $extImages = '';
    $extensions = JSON::open(__DIR__ . '/../../../../data/system/extensions.json');
    if (is_array($extensions['image'])) {
        $array = array_map('strtolower', $extensions['image']);
        $extImages = '.' . implode(',.', $array);
    }
?>

<section class="manage-view">

    <?php 
        $BUTTONS = ['table', 'insert', 'update', 'delete'];
        include __DIR__ . '/../../menus/navbarManageMenu.php';
    ?>

    <div class="tab-content scrollable">

        <div id="manage-details-status"
            data-true="<?= $GLOBALS['lang-view']['view-status-true'] ?>"
            data-false="<?= $GLOBALS['lang-view']['view-status-false'] ?>"></div>

        <div id="manage-details-country"
            data-yes="<?= $GLOBALS['lang-view']['view-yes'] ?>"
            data-no="<?= $GLOBALS['lang-view']['view-no'] ?>"></div>

        <div id="manage-view-table" class="tab-pane fade show active" role="tabpanel">
            <?php include __DIR__ . '/../../layouts/manageResponseLayout.php'; ?>
            <div class="custom-table-container">
                <div class="table-responsive table-head-sticky">
                    <table id="manage-table" class="table table-filter table-update custom-table no-select align-middle m-0" text-filter="<?= $GLOBALS['lang-view']['table-filter'] ?>">
                        <thead class="align-middle">
                            <tr>
                                <th scope="col" class="px40 text-center">#</th>
                                <th scope="col" class="px100"><?= $GLOBALS['lang-view']['table-id'] ?></th>
                                <th scope="col" colspan="2" class="min150"><?= $GLOBALS['lang-view']['table-name'] ?></th>
                                <th scope="col" class="min350"><?= $GLOBALS['lang-view']['table-description'] ?></th>
                                <th scope="col" class="min50 text-center px-0"><?= $GLOBALS['lang-view']['table-need-country'] ?></th>
                                <th scope="col" class="min110 text-center"><?= $GLOBALS['lang-view']['table-status'] ?></th>
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
                        <div id="input-group-status" class="input-group-label">
                            <label class="input-label fixed" for="status"><?= $GLOBALS['lang-view']['form-status-label'] ?></label>
                            <select id="status" class="custom-select form-control" data-placeholder="<?= $GLOBALS['lang-view']['form-status-placeholder'] ?>" validate-value="true" required>
                                <option value=""></option>
                                <option value='true' svg-icon='<?= $GLOBALS['url-path'] ?>/assets/icons/bootstrap.svg#check' svg-icon-fill='var(--color-success)'><?= $GLOBALS['lang-view']['view-status-true'] ?></option>
                                <option value='false' svg-icon='<?= $GLOBALS['url-path'] ?>/assets/icons/bootstrap.svg#x' svg-icon-fill='var(--color-danger)'><?= $GLOBALS['lang-view']['view-status-false'] ?></option>
                            </select>
                            <div class="invalid-feedback"><?= $GLOBALS['lang-view']['form-status-invalid-feedback'] ?></div>
                        </div>
                        <div id="input-group-id" class="input-group-label">
                            <label class="input-label fixed" for="id"><?= $GLOBALS['lang-view']['form-id-label'] ?></label>
                            <input id="id" name="id" type="text" class="form-control" placeholder="<?= $GLOBALS['lang-view']['form-id-placeholder'] ?>" maxlength="50" validate-length="3" input-case="key" required>
                            <div class="invalid-feedback"><?= $GLOBALS['lang-view']['form-id-invalid-feedback'] ?></div>
                        </div>
                        <div id="input-group-name" class="input-group-label">
                            <label class="input-label fixed" for="name"><?= $GLOBALS['lang-view']['form-name-label'] ?></label>
                            <input id="name" type="text" class="form-control" placeholder="<?= $GLOBALS['lang-view']['form-name-placeholder'] ?>" maxlength="50" validate-length="3" required> 
                            <div class="invalid-feedback"><?= $GLOBALS['lang-view']['form-name-invalid-feedback'] ?></div>
                        </div>
                        <div id="input-group-description" class="input-group-label">
                            <label class="input-label fixed" for="description"><?= $GLOBALS['lang-view']['form-description-label'] ?></label>
                            <textarea id="description" class="form-control" cols="1" rows="3" placeholder="<?= $GLOBALS['lang-view']['form-description-placeholder'] ?>" maxlength="500"></textarea>
                        </div>
                        <div id="input-group-need-country" class="input-group-label form-control">
                            <div class="form-check custom-form-check w-100">
                                <input class="form-check-input custom-control" type="checkbox" id="need-country">
                                <label class="form-check-label w-100" for="need-country"><?= $GLOBALS['lang-view']['form-need-country-label'] ?></label>
                            </div>
                        </div>
                        <div id="input-group-icon" class="input-group-label">
                            <div id="icon" class="custom-file form-control"
                                input-type="image"
                                input-accept="<?= $extImages ?>"
                                input-text="<?= $GLOBALS['lang-view']['form-icon-input-text'] ?>"
                                input-button="<?= $GLOBALS['lang-view']['form-icon-input-button'] ?>"
                                input-info-link="<?= $GLOBALS['lang-view']['form-icon-info-link'] ?>"
                                input-replace-view="true"
                                validate-file-equal="true"
                                validate-file-height="50"
                                validate-file-width="50"
                                validate-file-size="100"
                                validate-file="true"
                                required>
                            </div>
                            <div class="invalid-feedback"><?= $GLOBALS['lang-view']['form-icon-invalid-feedback'] ?></div>
                        </div>
                    </div>
                    <?php include __DIR__ . '/../../layouts/manageFormButtonsLayout.php'; ?>
                </form>
            </div> 
        </div>

    </div>
</section>

<?php
echo getScript('new SettingsPaymentMethods()');