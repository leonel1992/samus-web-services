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
            data-false="<?= $GLOBALS['lang-view']['view-status-false'] ?>"
        ></div>

        <div id="manage-view-table" class="tab-pane fade show active" role="tabpanel">
            <?php include __DIR__ . '/../../layouts/manageResponseLayout.php'; ?>
            <div class="custom-table-container">
                <div class="table-responsive table-head-sticky">
                    <table id="manage-table" class="table table-filter table-update custom-table no-select align-middle m-0" text-filter="<?= $GLOBALS['lang-view']['table-filter'] ?>">
                        <thead class="align-middle">
                            <tr>
                                <th scope="col" class="px50 text-center">#</th>
                                <th scope="col" class="px60 text-center"><small><?= $GLOBALS['lang-view']['table-prefix'] ?></small></th>
                                <th scope="col" class="px60 text-center"><small><?= $GLOBALS['lang-view']['table-iso_2'] ?></small></th>
                                <th scope="col" class="px60 text-center"><small><?= $GLOBALS['lang-view']['table-iso_3'] ?></small></th>
                                <th scope="col" class="px60 text-center"><small><?= $GLOBALS['lang-view']['table-currency'] ?></small></th>
                                <th scope="col" class="px60 text-center"><small><?= $GLOBALS['lang-view']['table-symbol'] ?></small></th>
                                <th scope="col" class="px60 text-center"><small><?= $GLOBALS['lang-view']['table-emoji'] ?></small></th>
                                <th scope="col" colspan="2" class="min180"><?= $GLOBALS['lang-view']['table-name'] ?></th>
                                <th scope="col" class="min150"><?= $GLOBALS['lang-view']['table-timezone'] ?></th>
                                <th scope="col" class="px110 text-center"><?= $GLOBALS['lang-view']['table-status-reg'] ?></th>
                                <th scope="col" class="px120 text-center"><?= $GLOBALS['lang-view']['table-status-calc'] ?></th>
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
                        <div id="input-group-name" class="input-group-label">
                            <label class="input-label fixed" for="name"><?= $GLOBALS['lang-view']['form-name-label'] ?></label>
                            <input id="name" type="text" class="form-control" placeholder="<?= $GLOBALS['lang-view']['form-name-placeholder'] ?>" maxlength="100" validate-length="3" required> 
                            <div class="invalid-feedback"><?= $GLOBALS['lang-view']['form-name-invalid-feedback'] ?></div>
                        </div>
                        <div id="input-group-currency" class="input-group-label mb-2">
                            <label class="input-label fixed" for="currency"><?= $GLOBALS['lang-view']['form-currency-label'] ?></label>
                            <select id="currency" class="custom-select form-control" data-placeholder="<?= $GLOBALS['lang-view']['form-currency-placeholder'] ?>" validate-value="true" required></select>
                            <div class="invalid-feedback"><?= $GLOBALS['lang-view']['form-currency-invalid-feedback'] ?></div>
                        </div>
                        <div id="input-group-timezone" class="input-group-label mb-2">
                            <label class="input-label fixed" for="timezone"><?= $GLOBALS['lang-view']['form-timezone-label'] ?></label>
                            <select id="timezone" class="custom-select form-control" data-placeholder="<?= $GLOBALS['lang-view']['form-timezone-placeholder'] ?>" validate-value="true" required></select>
                            <div class="invalid-feedback"><?= $GLOBALS['lang-view']['form-timezone-invalid-feedback'] ?></div>
                        </div>
                        <div class="row">
                            <div class="col-12 col-md-6">
                                <div id="input-group-iso-2" class="input-group-label mb-2">
                                    <label class="input-label fixed" for="iso-2"><?= $GLOBALS['lang-view']['form-iso-2-label'] ?></label>
                                    <input id="iso-2" name="iso-2" type="text" class="form-control" placeholder="<?= $GLOBALS['lang-view']['form-iso-2-placeholder'] ?>" maxlength="2" validate-length="2" input-case="upper" required>
                                    <div class="invalid-feedback"><?= $GLOBALS['lang-view']['form-iso-2-invalid-feedback'] ?></div>
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div id="input-group-iso-3" class="input-group-label mb-2">
                                    <label class="input-label fixed" for="iso-3"><?= $GLOBALS['lang-view']['form-iso-3-label'] ?></label>
                                    <input id="iso-3" name="iso-3" type="text" class="form-control" placeholder="<?= $GLOBALS['lang-view']['form-iso-2-placeholder'] ?>" maxlength="3" validate-length="3" input-case="upper" required>
                                    <div class="invalid-feedback"><?= $GLOBALS['lang-view']['form-iso-3-invalid-feedback'] ?></div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 col-md-6">
                                <div id="input-group-prefix" class="input-group-label mb-2">
                                    <label class="input-label fixed" for="prefix"><?= $GLOBALS['lang-view']['form-prefix-label'] ?></label>
                                    <input id="prefix" name="prefix" type="tel" class="form-control" placeholder="<?= $GLOBALS['lang-view']['form-prefix-placeholder'] ?>" maxlength="6" input-case="prefix" validate-prefix="true" required>
                                    <div class="invalid-feedback"><?= $GLOBALS['lang-view']['form-prefix-invalid-feedback'] ?></div>
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div id="input-group-emoji" class="input-group-label mb-2">
                                    <label class="input-label fixed" for="emoji"><?= $GLOBALS['lang-view']['form-emoji-label'] ?></label>
                                    <input id="emoji" name="emoji" type="text" class="form-control" placeholder="<?= $GLOBALS['lang-view']['form-emoji-placeholder'] ?>" maxlength="20" validate-value="true" required>
                                    <div class="invalid-feedback"><?= $GLOBALS['lang-view']['form-emoji-invalid-feedback'] ?></div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 col-md-6 pe-md-2">
                                <div id="input-group-status-reg" class="input-group-label">
                                    <label class="input-label fixed" for="status-reg"><?= $GLOBALS['lang-view']['form-status-reg-label'] ?></label>
                                    <select id="status-reg" class="custom-select form-control" data-placeholder="<?= $GLOBALS['lang-view']['form-status-reg-placeholder'] ?>" validate-value="true" required>
                                        <option value=""></option>
                                        <option value='true' svg-icon='<?= $GLOBALS['url-path'] ?>/assets/icons/bootstrap.svg#check' svg-icon-fill='var(--color-success)'><?= $GLOBALS['lang-view']['view-status-true'] ?></option>
                                        <option value='false' svg-icon='<?= $GLOBALS['url-path'] ?>/assets/icons/bootstrap.svg#x' svg-icon-fill='var(--color-danger)'><?= $GLOBALS['lang-view']['view-status-false'] ?></option>
                                    </select>
                                    <div class="invalid-feedback"><?= $GLOBALS['lang-view']['form-status-reg-invalid-feedback'] ?></div>
                                </div>
                            </div>
                            <div class="col-12 col-md-6 ps-md-2">
                                <div id="input-group-status-calc" class="input-group-label">
                                    <label class="input-label fixed" for="status-calc"><?= $GLOBALS['lang-view']['form-status-calc-label'] ?></label>
                                    <select id="status-calc" class="custom-select form-control" data-placeholder="<?= $GLOBALS['lang-view']['form-status-calc-placeholder'] ?>" validate-value="true" required>
                                        <option value=""></option>
                                        <option value='true' svg-icon='<?= $GLOBALS['url-path'] ?>/assets/icons/bootstrap.svg#check' svg-icon-fill='var(--color-success)'><?= $GLOBALS['lang-view']['view-status-true'] ?></option>
                                        <option value='false' svg-icon='<?= $GLOBALS['url-path'] ?>/assets/icons/bootstrap.svg#x' svg-icon-fill='var(--color-danger)'><?= $GLOBALS['lang-view']['view-status-false'] ?></option>
                                    </select>
                                    <div class="invalid-feedback"><?= $GLOBALS['lang-view']['form-status-calc-invalid-feedback'] ?></div>
                                </div>
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
echo getScript('new SettingsCountries()');