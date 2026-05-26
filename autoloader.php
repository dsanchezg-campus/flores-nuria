<?php
spl_autoload_register(function ($nombre_clase) {
    // Buscamos la clase en la carpeta 'clases'
    $archivo = __DIR__ . "/php/classes/$nombre_clase.php";

    if (file_exists($archivo)) {
        require_once $archivo;
    } else{
        error_log("Error: No se pudo encontrar el archivo en $archivo", 3, "logs/errores.log");
        echo "Error: 505";
        exit;
    }
});