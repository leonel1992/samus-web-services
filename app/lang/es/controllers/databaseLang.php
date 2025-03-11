<?php
$GLOBALS['lang-controllers']['db'] = [

    // "app_emails" => [
    //     "insert" => "Se registro su email correctamente, pronto te estaremos contactando.",
    //     "invalid-app" => "Dato inválido. Debe indicar la app del registro.",
    //     "invalid-email" => "Dato inválido. Debe indicar un correo válido.",
    // ],

    // "api_apps" => [
    //     "insert" => "Se generó correctamente una nueva aplicación para la API.",
    //     "update" => "Se editó la aplicación de la API correctamente.",
    //     "delete" => "Se eliminó la aplicación de la API correctamente.",
    //     "invalid-user" => "Dato inválido. No se especificó el usuario de la API o es incorrecto.",
    //     "invalid-name" => "Dato inválido. Debe indicar un nombre válido para la aplicación.",
    // ],
    // "api_keys" => [
    //     "insert" => "Se generó correctamente una nueva llave para la API.",
    //     "delete" => "Se eliminó la llave de la API correctamente.",
    //     "invalid-app" => "Dato inválido. No se especificó la aplicación o es incorrecta.",
    // ],
    // "api_users" => [
    //     "insert" => "Se registró el usuario para la API.",
    //     "invalid-user" => "El usuario es inválido.",
    // ],

    "users" => [
        "insert" => "Se registró el usuario.",
        "update" => "Se editó el usuario.",
        "delete" => "Se eliminó el usuario.",
        "update-pass-error" => "No se pudo editar la clave, intenta nuevamente.",
        "update-pass-success" => "Su nueva clave se ha guardado con éxito.",
        "register-succes" => "Se ha registrado satisfactoriamente.",
        "register-error" => "No se ha podido completar el registro, intenta nuevamente.",
        "invalid-name" => "Dato inválido. Debe indicar un nombre válido.",
        "invalid-last-name" => "Dato inválido. Debe indicar un apellido válido.",
        "invalid-country" => "Dato inválido. Debe indicar un país válido.",
        "invalid-email" => "Dato inválido. Debe indicar un correo válido.",
        "invalid-phone" => "Dato inválido. Debe indicar un número de teléfono válido.",
        "invalid-password" => "Contraseña inválida. Debe tener entre 8 y 20 caracteres, al menos 1 mayúscula, 1 minúscula, 1 número y un símbolo.",
        "invalid-password-equal" => "Las contraseñas no coinciden.",
    ],

    "actions" => [
        "insert" => "Se registró la acción en el sistema.",
        "update" => "Se editó la acción correctamente.",
        "delete" => "Se eliminó la acción correctamente.",
        "invalid-id" => "Debe ingresar un ID válido para la acción.",
        "invalid-name" => "Debe ingresar un nombre válido para la acción.",
    ],
    "modules" => [
        "insert" => "Se registró el módulo en el sistema.",
        "update" => "Se editó el módulo correctamente.",
        "delete" => "Se eliminó el módulo correctamente.",
        "invalid-id" => "Debe ingresar un ID válido para el módulo.",
        "invalid-module" => "Debe ingresar un nombre de módulo válido.",
    ],
    "permissions" => [
        "insert" => "Se registró el permiso en el sistema.",
        "update" => "Se editó el permiso correctamente.",
        "delete" => "Se eliminó el permiso correctamente.",
        "invalid-module" => "Debe ingresar un módulo válido para el permiso.",
        "invalid-action" => "Debe ingresar una acción válida para el permiso.",
    ],
    "permissions_roles" => [
        "insert" => "Se registró el permiso del rol en el sistema.",
        "update" => "Se editó el permiso del rol correctamente.",
        "delete" => "Se eliminó el permiso del rol correctamente.",
        "invalid-rol" => "Debe ingresar un rol válido para el permiso.",
        "invalid-permision" => "Debe ingresar permiso válido asociado al rol.",
    ],
    "roles" => [
        "insert" => "Se registró el rol en el sistema.",
        "update" => "Se editó el rol correctamente.",
        "delete" => "Se eliminó el rol correctamente.",
        "invalid-id" => "Debe ingresar un ID válido para el rol.",
        "invalid-name" => "Debe ingresar un nombre válido para el rol.",
        "invalid-permissions" => "Debe ingresar los permisos asociados al rol.",
    ]
];