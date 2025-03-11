<?php require_once __DIR__ . "/../../lang/{$GLOBALS['lang']}/layouts/webFooterLang.php"; ?>

<footer class="py-3">
    <div class="container">
        <div class="row">
    
            <div class="col-12">
                <div class="logo">
                    <a href="<?= $GLOBALS['url-lang'] ?>/">
                        <img src="<?= $GLOBALS['url-path'] ?>/assets/img/logo.png" alt="">
                        <span class="text-uppercase"><?= $GLOBALS['title'] ?></span>
                    </a>
                </div>
            </div>

            <div class="col-12 col-sm-12 col-lg-3 col-xl-4 mb-3 mb-lg-0">
                <p class="slogan"><?= $GLOBALS['lang-layouts']['footer']['slogan'] ?></p>
            </div>
            
            <div class="col-12 col-sm-5 col-lg-4 col-xl-3 mb-3 mb-sm-0 offset-xl-1">
                <h6><?= $GLOBALS['lang-layouts']['footer']['contact'] ?></h6>
                <?php
                    if(isset($GLOBALS['social']['text']['address']) && $GLOBALS['social']['text']['address']){
                        if(isset($GLOBALS['social']['link']['map']) && $GLOBALS['social']['link']['map']){
                            echo '<p>
                                <a href="'. $GLOBALS['social']['link']['map'] .'" target="_blank" class="d-flex flex-row align-items-center">
                                    <span><i class="bi bi-geo-alt-fill"></i></span>
                                    <span class="ms-2 text-break">'. $GLOBALS['social']['text']['address'] .'</span>
                                </a>
                            </p>';
                        }else{
                            echo '<p class="d-flex flex-row align-items-center">
                                <span><i class="bi bi-geo-alt-fill"></i></span>
                                <span class="ms-2 text-break">'. $GLOBALS['social']['text']['address'] .'</span>
                            </p>';
                        }
                    }

                    if(isset($GLOBALS['social']['email']['contact']) && $GLOBALS['social']['email']['contact']){ 
                        echo '<p>
                            <a href="mailto:'. $GLOBALS['social']['email']['contact'] .'" target="_blank" class="d-flex flex-row align-items-center">
                                <span><i class="bi bi-envelope-fill"></i></span>
                                <span class="ms-2 text-break">'. $GLOBALS['social']['email']['contact'] .'</span>
                            </a>
                        </p>';
                    }
                    
                    if(isset($GLOBALS['social']['phone']['contact']) && $GLOBALS['social']['phone']['contact']){ 
                        echo '<p>
                            <a href="tel:'. $GLOBALS['social']['phone']['contact'] .'" target="_blank" class="d-flex flex-row align-items-center">
                                <span><i class="bi bi-telephone-fill"></i></span>
                                <span class="ms-2 text-break">'. $GLOBALS['social']['phone']['contact'] .'</span>
                            </a>
                        </p>';
                    }
                ?>
            </div>

            <div class="col-7 col-sm-4 col-lg-3 col-xl-2">
                <h6><?= $GLOBALS['lang-layouts']['footer']['legal'] ?></h6>
                <p><a target="blank" href="<?= generateRouteLink('legal-terms') ?>"><?= $GLOBALS['lang-layouts']['footer']['terms'] ?></a></p>
                <p><a target="blank" href="<?= generateRouteLink('legal-cookies') ?>"><?= $GLOBALS['lang-layouts']['footer']['cookies'] ?></a></p>
                <p><a target="blank" href="<?= generateRouteLink('legal-privacy') ?>"><?= $GLOBALS['lang-layouts']['footer']['privacy'] ?></a></p>
            </div>

            <div class="col-5 col-sm-3 col-lg-2 col-xl-2">
                <h6><?= $GLOBALS['lang-layouts']['footer']['more'] ?></h6>
                <p><a target="blank" href="<?= generateRouteLink('public-about') ?>"><?= $GLOBALS['lang-layouts']['footer']['about'] ?></a></p>
            </div>
            
            <div class="col-12">
                <div class="divider"></div>
            </div>
            
            <div class="social col-12 text-center">
                <?php
                    if (isset($GLOBALS['social']['social']) && is_array($GLOBALS['social']['social'])) {
                        foreach ($GLOBALS['social']['social'] as $key => $item) {
                            if ($item) {
                                echo '<div class="icon"><a href="'. $item .'" target="_blank"><i class="bi bi-'. $key .'"></i></a></div>';
                            }
                        }
                    }
                ?>
            </div>
            
            <div class="col-12 text-center mt-2">
                <p class="m-0"><?= $GLOBALS['lang-layouts']['footer']['company'] ?></p>
                <p class="m-0"><?= $GLOBALS['lang-layouts']['footer']['copyright'] ?></p>
            </div>
  
        </div>
    </div>
</footer>