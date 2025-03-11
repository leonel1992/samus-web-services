<?php include __DIR__ ."/../../modals/codeModal.php" ?>

<section class="d-flex justify-content-center align-items-center vh-100">
    <div class="card shadow-lg p-4" style="max-width: 400px; width: 100%;">
        <h1 class="text-center mb-4 h-2">Recuperar Contraseña</h1>
        <form id="recover-form" class="validate-form">
            <!-- Input de Contraseña -->
            <div class="mb-3">
                <label for="recover-password" class="form-label">Contraseña</label>
                <input type="password" class="form-control" id="recover-password" name="recover-password" validate-password="true" required>
            </div>

            <!-- Input de repetir contraseña -->
            <div class="mb-3">
                <label for="recover-password-confirm" class="form-label">Repetir Contraseña</label>
                <input type="password" class="form-control" id="recover-password-confirm" name="recover-password-confirm" validate-equal="#recover-password" required>
            </div>

            <!-- Botón de enviar -->
            <button id="recover-submit" type="submit" class="btn btn-primary w-100">Enviar</button>
                
            <!-- Datos del código de validacion -->
            <input type="hidden" id="recover-code" value="">
            <input type="hidden" id="recover-code-id" value="">

            <!-- Mensajes de error -->
            <input type="hidden" id="recover-toast-password" value="Debe ingresar una contraseña válida, debe contener Letras mayúsculas, minúsculas, numeros y caracteres especiales.">
            <input type="hidden" id="recover-toast-password-confirm" value="Las contraseñas no coinciden.">
            
        </form>
    </div>
</section>

<div id="recover-success" class="vw-100 vh-100 position-absolute top-0 start-0 bg-white" style="display:none;">
    <div class="d-flex flex-column justify-content-center align-items-center vh-100">
        <span class="text-success fs-1">
            <i class="bi bi-check2-all"></i>
        </span>
        <h5>Se cambió la contraseña</h5>
    </div>
</div>