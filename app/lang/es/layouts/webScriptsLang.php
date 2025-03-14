<?php
$GLOBALS['lang-layouts']['scripts'] = [
    "calendar" => [
        "days" => [
            "DOM", 
            "LUN", 
            "MAR", 
            "MIE", 
            "JUE", 
            "VIE", 
            "SAB"
        ],
        "months" => [
            "ene", 
            "feb", 
            "mar", 
            "abr", 
            "may", 
            "jun", 
            "jul",
            "ago", 
            "sep", 
            "oct", 
            "nov", 
            "dic"
        ]
    ],

    "error" => [
        "0" => "Ocurrió un error desconocido. Por favor, intenta nuevamente.",
      "400" => "La solicitud contiene datos incorrectos. Revisa y vuelve a intentarlo.",
      "401" => "No estás autorizado para ver esta página. Inicia sesión y vuelve a intentarlo.",
      "403" => "No tienes permisos para acceder a este recurso.",
      "404" => "La página solicitada no se pudo encontrar.",
      "405" => "La acción que intentaste no está permitida en esta página.",
      "406" => "El contenido solicitado no está disponible en un formato compatible.",
      "408" => "La conexión tardó demasiado en responder. Por favor, intenta de nuevo.",
      "409" => "Hubo un conflicto con tu solicitud. Revisa los datos y vuelve a intentarlo.",
      "410" => "La página que buscas ya no está disponible.",
      "413" => "El archivo o datos enviados son demasiado grandes. Reduce el tamaño e intenta de nuevo.",
      "415" => "El formato de archivo enviado no es compatible. Usa un formato aceptado.",
      "429" => "Has realizado demasiadas solicitudes. Espera un momento e intenta de nuevo.",
      "500" => "Ocurrió un error en el servidor. Intenta más tarde.",
      "501" => "La función solicitada no está disponible en este servidor.",
      "502" => "Hay un problema temporal de conexión. Por favor, intenta nuevamente.",
      "503" => "El servicio no está disponible en este momento. Intenta más tarde.",
      "504" => "La respuesta del servidor tardó demasiado. Intenta nuevamente más tarde.",
      "505" => "La versión de navegador usada no es compatible. Actualiza el navegador e intenta de nuevo.",
      "default" => "Ocurrió un error inesperado. Por favor, intenta nuevamente o contacta al soporte si el problema persiste.",
      "title" => "Error [[CODE]]"
    ],

    "load" => [
        "errorTitle" => "Error de carga",
        "errorHtml" => "Error de carga",
        "button" => "Reintentar"
    ],
    "modal" => [
        "buttonNo" => "NO",
        "buttonYes" => "SI",
        "buttonAccept" => "Aceptar",
        "buttonClose" => "Cerrar",
        "buttonRetry" => "Reintentar"
    ],
    "toast" => [
        "danger" => "Error",
        "warning" => "Advertencia",
        "success" => "Correcto",
        "info" => "Información"
    ],

    "inputFile" => [
        "or" => "o",
        "button" => "Subir",
        "text" => "Arrastra el archivo",
        "error" => [
            "default" => [
                "resp" => "Ocurrió un error inesperado, intenta nuevamente.",
                "type" => "El archivo seleccionado es inválido.",
                "size" => "El archivo debe pesar menos de [[SIZE]]kB"
            ],
            "image" => [
                "type" => "Sólo se permiten archivos de tipo IMAGEN.",
                "size" => "La imagen debe pesar menos de [[SIZE]]kB",
                "equal" => "La imagen debe ser cuadrada<br>ANCHO = ALTO",
                "pixels" => "La resolución de la imagen tiene que ser mayor a [[WIDTH]]x[[HEIGHT]]px"
            ]
        ]
    ],
];