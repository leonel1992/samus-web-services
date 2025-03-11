<div class="position-fixed top-0 start-0 w-100 h-100 d-flex justify-content-center align-items-center flex-column bg-light">
    <h1 class="text-center">CUENTA INICIO</h1>
    <form id="logout-form" action="<?= generateRouteLink('session-login') ?>" method="POST" class="mt-3">
        <button type="submit" class="btn btn-danger">Cerrar sesión</button>
    </form>
</div>