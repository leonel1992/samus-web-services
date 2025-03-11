<?php include __DIR__ ."/../../modals/codeModal.php" ?>

<section class="d-flex justify-content-center align-items-center vh-100">
    <div class="card shadow-lg p-4" style="max-width: 400px; width: 100%;">
        <h1 class="text-center mb-4 h-2">Registro</h1>
        <form id="register-form" action="<?= generateRouteLink('session-register') ?>?form=true" class="validate-form">
            <!-- Input de Correo -->
            <div class="mb-3">
                <label for="register-email" class="form-label">Correo Electrónico</label>
                <input type="email" class="form-control" id="register-email" name="email" validate-email="true" required>
            </div>

            <!-- Checkbox términos -->
            <div class="form-check mb-3">
                <input class="form-check-input" type="checkbox" id="register-terms" name="register-terms" validate-check="true" required>
                <label class="form-check-label" for="register-terms">
                    Acepto lo términos y condiciones
                </label>
            </div>

            <!-- Botón de enviar -->
            <button id="register-submit" type="submit" class="btn btn-primary w-100">Enviar</button>
                
            <!-- Mensajes de error -->
            <input type="hidden" id="register-toast-email" value="Debe ingresar un correo válido">
            <input type="hidden" id="register-toast-terms" value="Debe aceptar los términos y condiciones">
        </form>
    </div>
</section>

<?php
echo getScript('new SessionRegister()');