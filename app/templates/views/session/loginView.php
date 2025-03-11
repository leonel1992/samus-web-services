<?php include __DIR__ ."/../../modals/codeModal.php" ?>

<section class="d-flex justify-content-center align-items-center vh-100">
    <div class="card shadow-lg p-4" style="max-width: 400px; width: 100%;">
        <h1 class="text-center mb-4 h-2">Iniciar Sesión</h1>
        <form id="login-form" class="validate-form">
            <!-- Input de Correo -->
            <div class="mb-3">
                <label for="login-email" class="form-label">Correo Electrónico</label>
                <input type="email" class="form-control" id="login-email" name="email" validate-email="true" required>
            </div>

            <!-- Input de Contraseña -->
            <div class="mb-3">
                <label for="login-password" class="form-label">Contraseña</label>
                <input type="password" class="form-control" id="login-password" name="password" validate-value="true" required>
            </div>

            <!-- Checkbox para mantener sesión abierta -->
            <div class="form-check mb-3">
                <input class="form-check-input" type="checkbox" id="login-remember" name="remember">
                <label class="form-check-label" for="login-remember">
                    Mantener sesión abierta
                </label>
            </div>

            <!-- Botón de enviar -->
            <button id="login-submit" type="submit" class="btn btn-primary w-100">Iniciar Sesión</button>
                
            <!-- Mensajes de error -->
             <input type="hidden" id="login-toast-email" value="Debe ingresarun correo válido">
             <input type="hidden" id="login-toast-password" value="Debe ingresar la contraseña.">

        </form>
    </div>
</section>

<?php 
$redirect = $GLOBALS['web-redirect'];
echo getScript("new SessionLogin('$redirect')"); 