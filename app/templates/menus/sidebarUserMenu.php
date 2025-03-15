<div class="offcanvas offcanvas-end offcanvas-user" tabindex="-1" id="offcanvasAvatar" aria-labelledby="offcanvasAvatarLabel">
    <div class="offcanvas-header">
        
        <div class="w-100 text-center">
            <form id="logout-form" action="<?= generateRouteLink('session-login') ?>" method="POST" class="mt-3">
                <button type="submit" class="btn btn-danger">Cerrar sesión</button>
            </form>
        </div>

    </div>
    <div class="offcanvas-body"></div>
</div>