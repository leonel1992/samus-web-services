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

        <div id="manage-option-na" data-text="<?= $GLOBALS['lang-view']['view-na'] ?>" ></div>
        <div id="manage-details-status"
            data-true="<?= $GLOBALS['lang-view']['view-status-true'] ?>"
            data-false="<?= $GLOBALS['lang-view']['view-status-false'] ?>"
        ></div>
        <div id="manage-details-invert"
            data-yes="<?= $GLOBALS['lang-view']['view-yes'] ?>"
            data-no="<?= $GLOBALS['lang-view']['view-no'] ?>"
        ></div>
        <div id="manage-details-country"
            data-paceholder-true="<?= $GLOBALS['lang-view']['form-country-placeholder-true'] ?>"
            data-paceholder-false="<?= $GLOBALS['lang-view']['form-country-placeholder-false'] ?>"
        ></div>

        <div id="manage-view-table" class="tab-pane fade show active" role="tabpanel">
            <?php include __DIR__ . '/../../layouts/manageResponseLayout.php'; ?>
            <div class="custom-table-container">
                <div class="table-responsive table-head-sticky">
                    <table id="manage-table" class="table table-filter table-update custom-table no-select align-middle m-0" text-filter="<?= $GLOBALS['lang-view']['table-filter'] ?>">
                        <thead class="align-middle">
                            <tr>
                                <th scope="col" class="px40 text-center">#</th>
                                <th scope="col" colspan="2" class="min120"><?= $GLOBALS['lang-view']['table-country'] ?></th>
                                <th scope="col" colspan="2" class="min150"><?= $GLOBALS['lang-view']['table-payment'] ?></th>
                                <th scope="col" colspan="2" class="min120"><?= $GLOBALS['lang-view']['table-name'] ?></th>
                                <th scope="col" class="px70 text-center px-0"><small><?= $GLOBALS['lang-view']['table-currency'] ?></small></th>
                                <th scope="col" class="px70 text-center px-0"><small><?= $GLOBALS['lang-view']['table-symbol'] ?></small></th>
                                <th scope="col" class="px70 text-center px-0"><small><?= $GLOBALS['lang-view']['table-decimals'] ?></small></th>
                                <th scope="col" class="px60 text-center px-0"><small><?= $GLOBALS['lang-view']['table-invert'] ?></small></th>
                                <th scope="col" class="px110 text-center"><small><?= $GLOBALS['lang-view']['table-status-buy'] ?></small></th>
                                <th scope="col" class="px110 text-center"><small><?= $GLOBALS['lang-view']['table-status-sell'] ?></small></th>
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
                        <div id="input-group-payment" class="input-group-label">
                            <label class="input-label fixed" for="payment"><?= $GLOBALS['lang-view']['form-payment-label'] ?></label>
                            <select id="payment" class="custom-select form-control" data-placeholder="<?= $GLOBALS['lang-view']['form-payment-placeholder'] ?>" validate-value="true" required></select>
                            <div class="invalid-feedback"><?= $GLOBALS['lang-view']['form-payment-invalid-feedback'] ?></div>
                        </div>
                        <div id="input-group-country" class="input-group-label">
                            <label class="input-label fixed" for="country"><?= $GLOBALS['lang-view']['form-country-label'] ?></label>
                            <select id="country" class="custom-select form-control" data-placeholder="<?= $GLOBALS['lang-view']['form-country-placeholder-false'] ?>" validate-value="false" ></select>
                            <div class="invalid-feedback"><?= $GLOBALS['lang-view']['form-country-invalid-feedback'] ?></div>
                        </div>
                        <div id="input-group-currency" class="input-group-label mb-2">
                            <label class="input-label fixed" for="currency"><?= $GLOBALS['lang-view']['form-currency-label'] ?></label>
                            <select id="currency" class="custom-select form-control" data-placeholder="<?= $GLOBALS['lang-view']['form-currency-placeholder'] ?>" validate-value="true" required></select>
                            <div class="invalid-feedback"><?= $GLOBALS['lang-view']['form-currency-invalid-feedback'] ?></div>
                        </div>
                        <div id="input-group-name" class="input-group-label">
                            <label class="input-label fixed" for="name"><?= $GLOBALS['lang-view']['form-name-label'] ?></label>
                            <input id="name" type="text" class="form-control" placeholder="<?= $GLOBALS['lang-view']['form-name-placeholder'] ?>" maxlength="50" validate-length="3" required> 
                            <div class="invalid-feedback"><?= $GLOBALS['lang-view']['form-name-invalid-feedback'] ?></div>
                        </div>
                        <div class="row">
                            <div class="col-12 col-md-6 pe-md-2">
                                <div id="input-group-status-buy" class="input-group-label">
                                    <label class="input-label fixed" for="status-buy"><?= $GLOBALS['lang-view']['form-status-buy-label'] ?></label>
                                    <select id="status-buy" class="custom-select form-control" data-placeholder="<?= $GLOBALS['lang-view']['form-status-buy-placeholder'] ?>" validate-value="true" required>
                                        <option value=""></option>
                                        <option value='true' svg-icon='<?= $GLOBALS['url-path'] ?>/assets/icons/bootstrap.svg#check' svg-icon-fill='var(--color-success)'><?= $GLOBALS['lang-view']['view-status-true'] ?></option>
                                        <option value='false' svg-icon='<?= $GLOBALS['url-path'] ?>/assets/icons/bootstrap.svg#x' svg-icon-fill='var(--color-danger)'><?= $GLOBALS['lang-view']['view-status-false'] ?></option>
                                    </select>
                                    <div class="invalid-feedback"><?= $GLOBALS['lang-view']['form-status-buy-invalid-feedback'] ?></div>
                                </div>
                            </div>
                            <div class="col-12 col-md-6 ps-md-2">
                                <div id="input-group-status-sell" class="input-group-label">
                                    <label class="input-label fixed" for="status-sell"><?= $GLOBALS['lang-view']['form-status-sell-label'] ?></label>
                                    <select id="status-sell" class="custom-select form-control" data-placeholder="<?= $GLOBALS['lang-view']['form-status-sell-placeholder'] ?>" validate-value="true" required>
                                        <option value=""></option>
                                        <option value='true' svg-icon='<?= $GLOBALS['url-path'] ?>/assets/icons/bootstrap.svg#check' svg-icon-fill='var(--color-success)'><?= $GLOBALS['lang-view']['view-status-true'] ?></option>
                                        <option value='false' svg-icon='<?= $GLOBALS['url-path'] ?>/assets/icons/bootstrap.svg#x' svg-icon-fill='var(--color-danger)'><?= $GLOBALS['lang-view']['view-status-false'] ?></option>
                                    </select>
                                    <div class="invalid-feedback"><?= $GLOBALS['lang-view']['form-status-sell-invalid-feedback'] ?></div>
                                </div>
                            </div>
                        </div>
                        <div id="input-group-invert" class="input-group-label form-control">
                            <div class="form-check custom-form-check w-100">
                                <input class="form-check-input custom-control" type="checkbox" id="invert">
                                <label class="form-check-label w-100" for="invert"><?= $GLOBALS['lang-view']['form-invert-label'] ?></label>
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
echo getScript('new SettingsProcessors()');