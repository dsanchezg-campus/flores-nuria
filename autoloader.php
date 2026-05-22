<?php
spl_autoload_register(function ($clase) {
    // Buscamos la clase en la carpeta 'clases'
    $archivo = __DIR__ . "/php/clases/$clase.php";

    if (file_exists($archivo)) {
        require_once $archivo;
    } else{
        error_log("Error: No se pudo encontrar el archivo en $archivo", 3, "errores.log");
        echo "Error: 505";
    }
});