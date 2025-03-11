<?php include __DIR__ ."/../../modals/codeModal.php" ?>

<section class="d-flex justify-content-center align-items-center vh-100">
    <div class="card shadow-lg p-4" style="max-width: 400px; width: 100%;">
        <h1 class="text-center mb-4 h-2">Registro</h1>
        <form id="register-form" class="validate-form">

            <!-- Input de correo -->
            <div class="mb-3">
                <label for="register-email" class="form-label">Correo</label>
                <input type="email" class="form-control" id="register-email" name="register-email" readonly>
            </div>

            <!-- Input de nombre -->
            <div class="mb-3">
                <label for="register-name" class="form-label">Nombre</label>
                <input type="text" class="form-control" id="register-name" name="register-name" validate-name="true" required>
            </div>

            <!-- Input de apellido -->
            <div class="mb-3">
                <label for="register-last-name" class="form-label">Apellido</label>
                <input type="text" class="form-control" id="register-last-name" name="register-last-name" validate-name="true" required>
            </div>

            <!-- Input de pais -->
            <div class="mb-3">
                <label for="register-country" class="form-label">País</label>
                <input type="text" class="form-control" id="register-country" name="register-country" validate-value="true" required>
            </div>

            <!-- Input de teléfono -->
            <div class="mb-3">
                <label for="register-phone" class="form-label">Tléfono</label>
                <input type="phone" class="form-control" id="register-phone" name="register-phone" validate-phone="true" required>
            </div>

            <!-- Input de Contraseña -->
            <div class="mb-3">
                <label for="register-password" class="form-label">Contraseña</label>
                <input type="password" class="form-control" id="register-password" name="register-password" validate-password="true" required>
            </div>

            <!-- Input de repetir contraseña -->
            <div class="mb-3">
                <label for="register-password-confirm" class="form-label">Repetir Contraseña</label>
                <input type="password" class="form-control" id="register-password-confirm" name="register-password-confirm" validate-equal="#register-password" required>
            </div>

            <!-- Botón de enviar -->
            <button id="register-submit" type="submit" class="btn btn-primary w-100">Enviar</button>
                
            <!-- Datos del código de validacion -->
            <input type="hidden" id="register-code" value="">
            <input type="hidden" id="register-code-id" value="">

            <!-- Mensajes de error -->
            <input type="hidden" id="register-toast-name" value="Debe ingresar un nombre válido.">
            <input type="hidden" id="register-toast-last-name" value="Debe ingresar un pellido válido.">
            <input type="hidden" id="register-toast-country" value="Debe ingresar un país válido.">
            <input type="hidden" id="register-toast-phone" value="Debe ingresar un teléfono válido.">
            <input type="hidden" id="register-toast-password" value="Debe ingresar una contraseña válida, debe contener Letras mayúsculas, minúsculas, numeros y caracteres especiales.">
            <input type="hidden" id="register-toast-password-confirm" value="Las contraseñas no coinciden.">
            
        </form>
    </div>
</section>

<div id="register-success" class="vw-100 vh-100 position-absolute top-0 start-0 bg-white" style="display:none;">
    <div class="d-flex flex-column justify-content-center align-items-center vh-100">
        <span class="text-success fs-1">
            <i class="bi bi-check2-all"></i>
        </span>
        <h5>Se completó su registro</h5>
    </div>
</div>