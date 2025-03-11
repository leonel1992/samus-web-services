<?php
    if (isset($_SESSION['user']['avatar']) && $_SESSION['user']['avatar']) {
        $avatar = '<img src="'. $GLOBALS['url-path'] .'/image/avatar/'. $_SESSION['user']['avatar'] .'" alt="">';
    } else {
        $avatar = '<svg class="bi" fill="currentColor">
            <use xlink:href="'. $GLOBALS['url-path'] .'/assets/icons/bootstrap.svg#person-fill"/>
        </svg>';
    }
?>

<div class="navbar-toggler-offcanvas">
    <button id="navbar-offcanvas-AVATAR" class="navbar-toggler toggler-avatar dropdown-toggle" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasAvatar" aria-controls="offcanvasAvatar">
        <?= $avatar ?>
    </button>
</div>