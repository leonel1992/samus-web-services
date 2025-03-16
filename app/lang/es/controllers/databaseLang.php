<?php
$GLOBALS['lang-controllers']['db'] = [

    "users" => [
        "insert" => "Se registró el usuario.",
        "update" => "Se editó el usuario.",
        "delete" => "Se eliminó el usuario.",
        "update-pass-error" => "No se pudo editar la clave, intenta nuevamente.",
        "update-pass-success" => "Su nueva clave se ha guardado con éxito.",
        "register-succes" => "Se ha registrado satisfactoriamente.",
        "register-error" => "No se ha podido completar el registro, intenta nuevamente.",
        "invalid-account" => "Dato inválido. Debe indicar un tipo de cuenta.",
        "invalid-gender" => "Dato inválido. Debe indicar un género.",
        "invalid-name" => "Dato inválido. Debe indicar un nombre válido.",
        "invalid-last-name" => "Dato inválido. Debe indicar un apellido válido.",
        "invalid-birthdate" => "Dato inválido. Debe indicar una fecha de nacimiento válida, debe ser mayor de edad.",
        "invalid-document-type" => "Dato inválido. Debe indicar su tipo de documento de identidad.",
        "invalid-document-number" => "Dato inválido. Debe indicar un documento de identidad válido.",
        "invalid-country" => "Dato inválido. Debe indicar su país de residencia.",
        "invalid-state" => "Dato inválido. Debe su estado o departamento de residencia.",
        "invalid-city" => "Dato inválido. Debe indicar su ciudad de residencia.",
        "invalid-address" => "Dato inválido. Debe indicar su dirección completa.",
        "invalid-phone" => "Dato inválido. Debe indicar un número de teléfono válido.",
        "invalid-email" => "Dato inválido. Debe indicar un correo válido.",
        "invalid-password-1" => "Contraseña inválida. Debe tener entre 8 y 20 caracteres, al menos 1 mayúscula, 1 minúscula, 1 número y un símbolo.",
        "invalid-password-2" => "Las contraseñas no coinciden.",
    ],
    "users_business" => [
        "insert" => "Se registró la empresa del usuario.",
        "update" => "Se editó la empresa del usuario.",
        "delete" => "Se eliminó la empresa del usuario.",
        "invalid-name" => "Dato inválido. Debe ingresar el nombre de la empresa.",
        "invalid-country" => "Dato inválido. Debe indicar el país donde opera la empresa.",
        "invalid-state" => "Dato inválido. Debe indicar el estado o provincia de la empresa.",
        "invalid-city" => "Dato inválido. Debe indicar la ciudad donde opera la empresa.",
        "invalid-address" => "Dato inválido. Debe ingresar la dirección fiscal de la empresa.",
        "invalid-type" => "Dato inválido. Debe indicar el tipo de empresa.",
        "invalid-date" => "Dato inválido. Debe indicar la fecha de constitución de la empresa.",
        "invalid-register-type" => "Dato inválido. Debe seleccionar el tipo de identificación fiscal.",
        "invalid-register-number" => "Dato inválido. Debe ingresar un número de identificación fiscal válido.",
        "invalid-phone" => "Dato inválido. Debe ingresar un número de teléfono válidopara la empresa..",
        "invalid-email" => "Dato inválido. Debe ingresar un correo electrónico válido para la empresa.",
    ],

    "currencies" => [
        "insert" => "Se registró la moneda en el sistema.",
        "update" => "Se editó la moneda correctamente.",
        "delete" => "Se eliminó la moneda correctamente.",
        "invalid-type" => "Debe indicar el tipo de moneda.",
        "invalid-code" => "Debe ingresar un código válido para la moneda.",
        "invalid-name" => "Debe ingresar un nombre para la moneda.",
        "invalid-symbol" => "Debe ingresar un símbolo para la moneda.",
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