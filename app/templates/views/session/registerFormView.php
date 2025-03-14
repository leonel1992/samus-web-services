<?php
    require_once __DIR__ . '/../../../models/db/countriesModel.php';
    require_once __DIR__ . '/../../../models/db/countryNitsModel.php';
    require_once __DIR__ . '/../../../models/db/countryDnisModel.php';
    require_once __DIR__ . '/../../../models/db/countryCompaniesModel.php';
    require_once __DIR__ . '/../../../models/db/userAccountsModel.php';
    require_once __DIR__ . '/../../../models/db/userGendersModel.php';
    $conn = DatabaseService::init();

    $userAccountsModel = new UserAccountsModel($conn);
    $userAccountsData = $userAccountsModel->getAll($userAccountsModel->query);
    $userAccounts = $userAccountsData->data ?? [];

    $userGendersModel = new UserGendersModel($conn);
    $userGendersData = $userGendersModel->getAll($userGendersModel->query);
    $userGenders = $userGendersData->data ?? [];

    $countriesModel = new CountriesModel($conn);
    $countriesData = $countriesModel->getAllForRegister();
    $countries = $countriesData->data ?? [];

    $countryDnisModel = new CountryDnisModel($conn);
    $countryDnisData = $countryDnisModel->getAll($countryDnisModel->query);
    $countryDnis = $countryDnisData->data ?? [];

    $countryNitsModel = new CountryNitsModel($conn);
    $countryNitsData = $countryNitsModel->getAll($countryNitsModel->query);
    $countryNits = $countryNitsData->data ?? [];

    $countryCompaniesModel = new CountryCompaniesModel($conn);
    $countryCompaniesData = $countryCompaniesModel->getAll($countryCompaniesModel->query);
    $countryCompanies = $countryCompaniesData->data ?? [];
?>

<section class="session d-flex align-items-center justify-content-center py-0 py-sm-4">
    <form id="register-form" action="" method="POST" class="validate-form d-flex flex-column align-items-center scrollable">
       
        <div class="mt-1 mb-2 d-flex justify-content-center align-items-center">
            <img class="logo" src="<?= $GLOBALS['url-path'] ?>/assets/img/logo.png" alt="<?= $GLOBALS['title'] ?>">
        </div>
        
        <div class="text-center">
            <h1 class="h2 fw-expanded"><?= $GLOBALS['lang-view']['title'] ?></h1>
        </div>

        <div id="personal-data" class="w-100">
            <div class="text-center">
                <h5 class="fw-expanded"><?= $GLOBALS['lang-view']['personal-data'] ?></h5>
            </div>

            <div id="input-group-register-user-account" class="input-group-label mt-4" disabled>
                <label class="input-label fixed" for="register-user-account"><span class='text-danger'>*</span> <?= $GLOBALS['lang-view']['label-user-account'] ?></label>
                <select id="register-user-account" name="register-user-account" class="form-control" data-placeholder="<?= $GLOBALS['lang-view']['placeholder-user-account'] ?>" validate-value="true" disabled required>
                    <option value=""></option>
                    <?php foreach($userAccounts as $value){
                        echo "<option value='{$value['id']}'>{$value['name']}</option>";
                    } ?>
                </select>
            </div>

            <div id="input-group-register-user-email" class="input-group-label" disabled>
                <label class="input-label fixed" for="register-user-email"><span class='text-danger'>*</span> <?= $GLOBALS['lang-view']['label-user-email'] ?></label>
                <input id="register-user-email" name="register-email" type="email" class="form-control" placeholder="<?= $GLOBALS['lang-view']['placeholder-user-email'] ?>"  validate-email="true" disabled required>
            </div>

            <div id="input-group-register-user-code" class="input-group-label">
                <label class="input-label fixed" for="register-user-code"><?= $GLOBALS['lang-view']['label-user-code'] ?></label></label>
                <input id="register-user-code" name="register-user-code" type="text" inputmode="numeric" maxlength="4" validate-length="4" class="form-control" input-case="user-code" placeholder="<?= $GLOBALS['lang-view']['placeholder-user-code'] ?>">
            </div>

            <div id="input-group-register-user-gender" class="input-group-label">
                <label class="input-label fixed" for="register-user-gender"><span class='text-danger'>*</span> <?= $GLOBALS['lang-view']['label-user-gender'] ?></label>
                <select id="register-user-gender" name="register-user-gender" class="custom-select form-control" data-placeholder="<?= $GLOBALS['lang-view']['placeholder-user-gender'] ?>"  validate-value="true" required>
                    <option value=""></option>
                    <?php foreach($userGenders as $value){
                        echo "<option value='{$value['id']}'>{$value['name']}</option>";
                    } ?>
                </select>
            </div>

            <div id="input-group-register-user-name" class="input-group-label">
                <label class="input-label fixed" for="register-user-name"><span class='text-danger'>*</span> <?= $GLOBALS['lang-view']['label-user-name'] ?></label>
                <input id="register-user-name" name="register-user-name" type="text" class="form-control" placeholder="<?= $GLOBALS['lang-view']['placeholder-user-name'] ?>" maxlength="50" validate-name="true" required>
            </div>

            <div id="input-group-register-user-last-name" class="input-group-label">
                <label class="input-label fixed" for="register-user-last-name"><span class='text-danger'>*</span> <?= $GLOBALS['lang-view']['label-user-last-name'] ?></label>
                <input id="register-user-last-name" name="register-user-last-name" type="text" class="form-control" placeholder="<?= $GLOBALS['lang-view']['placeholder-user-last-name'] ?>" maxlength="50" validate-name="true" required>
            </div>

            <div id="input-group-register-user-country" class="input-group-label">
                <label class="input-label fixed" for="register-user-country"><span class='text-danger'>*</span> <?= $GLOBALS['lang-view']['label-user-country'] ?></label>
                <select id="register-user-country" name="register-user-country" class="custom-select form-control" data-placeholder="<?= $GLOBALS['lang-view']['placeholder-user-country'] ?>"  validate-value="true" required>
                    <option value=""></option>
                    <?php foreach($countries as $value){
                        echo "<option value='{$value['id']}' data-prefix='{$value['prefix']}' img-icon='{$value['icon_url']}' subtitle'{$value['name']}'>{$value['name']}</option>";
                    } ?>
                </select>
            </div>
            
            <div id="input-group-register-user-state" class="input-group-label">
                <label class="input-label fixed" for="register-user-state"><span class='text-danger'>*</span> <?= $GLOBALS['lang-view']['label-user-state'] ?></label>
                <input id="register-user-state" name="register-user-state" type="text" class="form-control" placeholder="<?= $GLOBALS['lang-view']['placeholder-user-state'] ?>" maxlength="50" validate-length="2" required>
            </div>

            <div id="input-group-register-user-city" class="input-group-label">
                <label class="input-label fixed" for="register-user-city"><span class='text-danger'>*</span> <?= $GLOBALS['lang-view']['label-user-city'] ?></label>
                <input id="register-user-city" name="register-user-city" type="text" class="form-control" placeholder="<?= $GLOBALS['lang-view']['placeholder-user-city'] ?>" maxlength="50" validate-length="2" required>
            </div>

            <div id="input-group-register-user-address" class="input-group-label">
                <label class="input-label fixed" for="register-user-address"><span class='text-danger'>*</span> <?= $GLOBALS['lang-view']['label-user-address'] ?></label>
                <textarea id="register-user-address" name="register-user-address" class="form-control" placeholder="<?= $GLOBALS['lang-view']['placeholder-user-address'] ?>" maxlength="100" validate-length="10" rows="2" required></textarea>
            </div>

            <div id="input-group-register-user-birthdate" class="input-group-label">
                <label class="input-label fixed" for="register-user-birthdate"><span class='text-danger'>*</span> <?= $GLOBALS['lang-view']['label-user-birthdate'] ?></label>
                <div id="register-user-birthdate" class="custom-datepicker form-control" placeholder="<?= $GLOBALS['lang-view']['placeholder-user-birthdate'] ?>" date-max="<?= date('Y/m/d') ?>" validate-age="18" required></div>
            </div>

            <div class="row">
                <div class="col-12 col-sm-5 pe-sm-1">
                    <div id="input-group-register-user-document-type" class="input-group-label">
                        <label class="input-label fixed" for="register-user-document-type"><span class='text-danger'>*</span> <?= $GLOBALS['lang-view']['label-user-document-type'] ?></label>
                        <select id="register-user-document-type" name="register-user-document-type" class="custom-select form-control" data-placeholder="<?= $GLOBALS['lang-view']['placeholder-user-document-type'] ?>"  validate-value="true" required>
                            <option value=""></option>
                            <?php foreach($countryDnis as $value){
                                echo "<option value='{$value['id']}' subtitle='{$value['name']}' data-country='{$value['country']}' class='d-none'>{$value['code']}</option>";
                            } ?>
                        </select>
                    </div>
                </div>
                <div class="col-12 col-sm-7 ps-sm-1">
                    <div id="input-group-register-user-document-number" class="input-group-label">
                        <label class="input-label fixed" for="register-user-document-number"><span class='text-danger'>*</span> <?= $GLOBALS['lang-view']['label-user-document-number'] ?></label>
                        <input id="register-user-document-number" name="register-user-document-number" type="text" class="form-control" placeholder="<?= $GLOBALS['lang-view']['placeholder-user-document-number'] ?>" validate-value="true" required>
                    </div>
                </div>
            </div>

            <div id="input-group-register-user-phone" class="input-group-label">
                <label class="input-label fixed" for="register-user-phone"><span class='text-danger'>*</span> <?= $GLOBALS['lang-view']['label-user-phone'] ?></label>
                <div class="input-group">
                    <span id="register-user-phone-prefix" class="input-group-text input-group-text-label text-center px-3" disabled>- - -</span>
                    <input id="register-user-phone" name="register-user-phone" type="tel" class="form-control border-start-0 ps-0 no-shadow" placeholder="<?= $GLOBALS['lang-view']['placeholder-user-phone'] ?>" maxlength="20" validate-phone="true" required>
                </div>
            </div>

            <div id="input-group-register-user-password-1" class="input-group-label">
                <label class="input-label fixed" for="register-user-password"><span class='text-danger'>*</span> <?= $GLOBALS['lang-view']['label-user-password-1'] ?></label>
                <div class="input-group">
                    <input id="register-user-password-1" name="register-user-password-1" type="password" class="form-control no-shadow custom-password" placeholder="<?= $GLOBALS['lang-view']['placeholder-user-password-1'] ?>" maxlength="20" validate-password="true" required>
                </div>
            </div>

            <div id="input-group-register-user-password-2" class="input-group-label">
                <label class="input-label fixed" for="register-user-password-2"><span class='text-danger'>*</span> <?= $GLOBALS['lang-view']['label-user-password-2'] ?></label>
                <div class="input-group">
                    <input id="register-user-password-2" name="register-user-register-user-password" type="password" class="form-control no-shadow custom-password" placeholder="<?= $GLOBALS['lang-view']['placeholder-user-password-2'] ?>" maxlength="20" validate-equal="#register-user-password-1" required>
                </div>
            </div>

            <input id="register-user-toast-account" type="hidden" value="<?= $GLOBALS['lang-view']['toast-user-account'] ?>">
            <input id="register-user-toast-email" type="hidden" value="<?= $GLOBALS['lang-view']['toast-user-email'] ?>">
            <input id="register-user-toast-code" type="hidden" value="<?= $GLOBALS['lang-view']['toast-user-code'] ?>">
            <input id="register-user-toast-gender" type="hidden" value="<?= $GLOBALS['lang-view']['toast-user-gender'] ?>">
            <input id="register-user-toast-name" type="hidden" value="<?= $GLOBALS['lang-view']['toast-user-name'] ?>">
            <input id="register-user-toast-last-name" type="hidden" value="<?= $GLOBALS['lang-view']['toast-user-last-name'] ?>">
            <input id="register-user-toast-birthdate" type="hidden" value="<?= $GLOBALS['lang-view']['toast-user-birthdate'] ?>">
            <input id="register-user-toast-document-type" type="hidden" value="<?= $GLOBALS['lang-view']['toast-user-document-type'] ?>">
            <input id="register-user-toast-document-number" type="hidden" value="<?= $GLOBALS['lang-view']['toast-user-document-number'] ?>">
            <input id="register-user-toast-country" type="hidden" value="<?= $GLOBALS['lang-view']['toast-user-country'] ?>">
            <input id="register-user-toast-state" type="hidden" value="<?= $GLOBALS['lang-view']['toast-user-state'] ?>">
            <input id="register-user-toast-city" type="hidden" value="<?= $GLOBALS['lang-view']['toast-user-city'] ?>">
            <input id="register-user-toast-address" type="hidden" value="<?= $GLOBALS['lang-view']['toast-user-address'] ?>">
            <input id="register-user-toast-phone" type="hidden" value="<?= $GLOBALS['lang-view']['toast-user-phone'] ?>">
            <input id="register-user-toast-password-1" type="hidden" value="<?= $GLOBALS['lang-view']['toast-user-password-1'] ?>">
            <input id="register-user-toast-password-2" type="hidden" value="<?= $GLOBALS['lang-view']['toast-user-password-2'] ?>">
        </div>

        <div id="business-data" class="w-100 mt-5 pb-2">
            <div class="text-center">
                <h5 class="fw-expanded"><?= $GLOBALS['lang-view']['business-data'] ?></h5>
            </div>

            <div id="input-group-register-business-name" class="input-group-label mt-4">
                <label class="input-label fixed" for="register-business-name"><span class='text-danger'>*</span> <?= $GLOBALS['lang-view']['label-business-name'] ?></label>
                <input id="register-business-name" name="register-business-name" type="text" class="form-control" placeholder="<?= $GLOBALS['lang-view']['placeholder-business-name'] ?>" maxlength="100" validate-length="2" required>
            </div>

            <div id="input-group-register-business-country" class="input-group-label">
                <label class="input-label fixed" for="register-business-country"><span class='text-danger'>*</span> <?= $GLOBALS['lang-view']['label-business-country'] ?></label>
                <select id="register-business-country" name="register-business-country" class="custom-select form-control" data-placeholder="<?= $GLOBALS['lang-view']['placeholder-business-country'] ?>" validate-value="true" required>
                    <option value=""></option>
                    <?php foreach($countries as $value){
                        echo "<option value='{$value['id']}' data-prefix='{$value['prefix']}' img-icon='{$value['icon_url']}' >{$value['name']}</option>";
                    } ?>
                </select>
            </div>

            <div id="input-group-register-business-state" class="input-group-label">
                <label class="input-label fixed" for="register-business-state"><span class='text-danger'>*</span> <?= $GLOBALS['lang-view']['label-business-state'] ?></label>
                <input id="register-business-state" name="register-business-state" type="text" class="form-control" placeholder="<?= $GLOBALS['lang-view']['placeholder-business-state'] ?>" maxlength="50" validate-length="2" required>
            </div>

            <div id="input-group-register-business-city" class="input-group-label">
                <label class="input-label fixed" for="register-business-city"><span class='text-danger'>*</span> <?= $GLOBALS['lang-view']['label-business-city'] ?></label>
                <input id="register-business-city" name="register-business-city" type="text" class="form-control" placeholder="<?= $GLOBALS['lang-view']['placeholder-business-city'] ?>" maxlength="50" validate-length="2" required>
            </div>

            <div id="input-group-register-business-address" class="input-group-label">
                <label class="input-label fixed" for="register-business-address"><span class='text-danger'>*</span> <?= $GLOBALS['lang-view']['label-business-address'] ?></label>
                <textarea id="register-business-address" name="register-business-address" class="form-control" placeholder="<?= $GLOBALS['lang-view']['placeholder-business-address'] ?>" maxlength="100" validate-length="10" rows="2" required></textarea>
            </div>

            <div class="row">
                <div class="col-12 col-sm-6 pe-sm-1">
                    <div id="input-group-register-business-type" class="input-group-label">
                        <label class="input-label fixed" for="register-business-type"><span class='text-danger'>*</span> <?= $GLOBALS['lang-view']['label-business-type'] ?></label>
                        <select id="register-business-type" name="register-business-type" class="custom-select form-control" data-placeholder="<?= $GLOBALS['lang-view']['placeholder-business-type'] ?>" validate-value="true" required>
                            <option value=""></option>
                            <?php foreach($countryCompanies as $value){
                                echo "<option value='{$value['id']}' subtitle='{$value['name']}' data-country='{$value['country']}' class='d-none'>{$value['code']}</option>";
                            } ?>
                        </select>
                    </div>
                </div>

                <div class="col-12 col-sm-6 ps-sm-1">
                    <div id="input-group-register-business-date" class="input-group-label">
                        <label class="input-label fixed" for="register-business-date"><span class='text-danger'>*</span> <?= $GLOBALS['lang-view']['label-business-date'] ?></label>
                        <div id="register-business-date" name="register-business-date" class="custom-datepicker form-control" placeholder="<?= $GLOBALS['lang-view']['placeholder-business-date'] ?>" date-max="<?= date('Y/m/d') ?>" validate-value="true" required></div>
                    </div>
                </div>

                <div class="col-12 col-sm-6 pe-sm-1">
                    <div id="input-group-register-business-register-type" class="input-group-label">
                        <label class="input-label fixed" for="register-business-register-type"><span class='text-danger'>*</span> <?= $GLOBALS['lang-view']['label-business-register-type'] ?></label>
                        <select id="register-business-register-type" name="register-business-register-type" class="custom-select form-control" data-placeholder="<?= $GLOBALS['lang-view']['placeholder-business-register-type'] ?>" validate-value="true" required>
                            <option value=""></option>
                            <?php foreach($countryNits as $value){
                                echo "<option value='{$value['id']}' subtitle='{$value['name']}' data-country='{$value['country']}' class='d-none'>{$value['code']}</option>";
                            } ?>
                        </select>
                    </div>
                </div>

                <div class="col-12 col-sm-6 ps-sm-1">
                    <div id="input-group-register-business-register-number" class="input-group-label">
                        <label class="input-label fixed" for="register-business-register-number"><span class='text-danger'>*</span> <?= $GLOBALS['lang-view']['label-business-register-number'] ?></label>
                        <input id="register-business-register-number" name="register-business-register-number" type="text" class="form-control" placeholder="<?= $GLOBALS['lang-view']['placeholder-business-register-number'] ?>" maxlength="20" validate-value="true" required>
                    </div>
                </div>
            </div>

            <div id="input-group-register-business-phone" class="input-group-label">
                <label class="input-label fixed" for="register-business-phone"><?= $GLOBALS['lang-view']['label-business-phone'] ?></label>
                <div class="input-group">
                    <span id="register-business-phone-prefix" class="input-group-text input-group-text-label text-center px-3" disabled>- - -</span>
                    <input id="register-business-phone" name="register-business-phone" type="tel" class="form-control border-start-0 ps-0 no-shadow" placeholder="<?= $GLOBALS['lang-view']['placeholder-business-phone'] ?>" maxlength="20" validate-phone="true">
                </div>
            </div>

            <div id="input-group-register-business-email" class="input-group-label">
                <label class="input-label fixed" for="register-business-email"><?= $GLOBALS['lang-view']['label-business-email'] ?></label>
                <input id="register-business-email" name="register-business-email" type="email" class="form-control" placeholder="<?= $GLOBALS['lang-view']['placeholder-business-email'] ?>" validate-email="true">
            </div>

            <div id="input-group-register-business-web" class="input-group-label">
                <label class="input-label fixed" for="register-business-web"><?= $GLOBALS['lang-view']['label-business-web'] ?></label>
                <input id="register-business-web" name="register-business-web" type="url" class="form-control" placeholder="<?= $GLOBALS['lang-view']['placeholder-business-web'] ?>" validate-lenght="2">
            </div>

            <input id="register-business-toast-name" type="hidden" value="<?= $GLOBALS['lang-view']['toast-business-name'] ?>"> 
            <input id="register-business-toast-country" type="hidden" value="<?= $GLOBALS['lang-view']['toast-business-country'] ?>">
            <input id="register-business-toast-state" type="hidden" value="<?= $GLOBALS['lang-view']['toast-business-state'] ?>">
            <input id="register-business-toast-city" type="hidden" value="<?= $GLOBALS['lang-view']['toast-business-city'] ?>">
            <input id="register-business-toast-address" type="hidden" value="<?= $GLOBALS['lang-view']['toast-business-address'] ?>">
            <input id="register-business-toast-type" type="hidden" value="<?= $GLOBALS['lang-view']['toast-business-type'] ?>">
            <input id="register-business-toast-date" type="hidden" value="<?= $GLOBALS['lang-view']['toast-business-date'] ?>">
            <input id="register-business-toast-register-type" type="hidden" value="<?= $GLOBALS['lang-view']['toast-business-register-type'] ?>">
            <input id="register-business-toast-register-number" type="hidden" value="<?= $GLOBALS['lang-view']['toast-business-register-number'] ?>">
            <input id="register-business-toast-phone" type="hidden" value="<?= $GLOBALS['lang-view']['toast-business-phone'] ?>">
            <input id="register-business-toast-email" type="hidden" value="<?= $GLOBALS['lang-view']['toast-business-email'] ?>">
            <input id="register-business-toast-web" type="hidden" value="<?= $GLOBALS['lang-view']['toast-business-web'] ?>">
        </div>
        
        <button id="register-submit" type="submit" class="btn custom-btn w-100 mt-4"><?= $GLOBALS['lang-view']['button'] ?></button>
            
        <input id="register-user-terms" type="hidden" value="">
        <input id="register-code" type="hidden" value="">
        <input id="register-code-id" type="hidden" value="">

    </form>
</section>

<section id="register-success" class="session-message" style="display:none;">
    <div class="message-view">
        <div class="image-view">
            <img src="<?= $GLOBALS['url-path'] ?>/assets/img/web/completed.png" />
            <div class="position-absolute top-0 bottom-0 left-0 right-0">
                <img src="<?= $GLOBALS['url-path'] ?>/assets/img/web/completed-text-<?= $GLOBALS['lang'] ?>.png" alt=""/>
            </div>
        </div>
        <div class="mt-2 text-view fw-condensed">
            <p class="mt-2 mb-3 fs-5"><?= $GLOBALS['lang-view']['success-message'] ?></p>
            <div class="d-flex mb-3 w-100 justify-content-center">
                <a style="width:calc(100% - 32px); max-width:<?= $GLOBALS['lang-view']['success-btn-width'] ?>;" class="me-2" href="<?= generateRouteLink('public-home') ?>">
                    <button class="w-100 h-100 btn custom-btn" type="button"><?= $GLOBALS['lang-view']['success-home'] ?></button>
                </a>
                <a style="width:calc(100% - 32px); max-width:<?= $GLOBALS['lang-view']['success-btn-width'] ?>;" class="ms-2" href="<?= generateRouteLink('session-login') ?>">
                    <button class="w-100 h-100 btn custom-btn" type="button"><?= $GLOBALS['lang-view']['success-login'] ?></button>
                </a>
            </div>
        </div>
    </div>
</section>

<script type="text/javascript" src="<?= $GLOBALS['url-path'] . $GLOBALS['files']['local']['script']['messages'] ?>"></script>