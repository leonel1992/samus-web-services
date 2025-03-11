<?php include __DIR__ ."/../../modals/codeModal.php" ?>

<section class="d-flex justify-content-center align-items-center vh-100">
    <div class="card shadow-lg p-4" style="max-width: 400px; width: 100%;">
        <h1 class="text-center mb-4 h-2">Recuperar Contraseña</h1>
        <form id="recover-form" action="<?= generateRouteLink('session-recover') ?>?form=true" class="validate-form">
            <!-- Input de Correo -->
            <div class="mb-3">
                <label for="recover-email" class="form-label">Correo Electrónico</label>
                <input type="email" class="form-control" id="recover-email" name="email" validate-email="true" required>
            </div>

            <!-- Botón de enviar -->
            <button id="recover-submit" type="submit" class="btn btn-primary w-100">Enviar</button>
                
            <!-- Mensajes de error -->
            <input type="hidden" id="recover-toast-email" value="Debe ingresarun correo válido">
        </form>
    </div>
</section>

<?php
echo getScript('new SessionRecover()');