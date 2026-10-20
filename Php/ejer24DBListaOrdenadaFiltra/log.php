<?php
// Escribe una línea en errores.log (misma carpeta) con fecha, hora, script que falló y el mensaje.
// Los demás scripts lo incluyen y llaman registrarError() desde sus bloques catch.
function registrarError($mensaje) {
    // "a" = modo adición: agrega al final sin borrar lo anterior
    $puntero = fopen(__DIR__ . "/errores.log", "a");
    if ($puntero === false) {
        return; // si no se puede escribir el log, no se rompe la respuesta al navegador
    }
    fwrite($puntero, date("Y-m-d H:i") . " [" . basename($_SERVER['SCRIPT_NAME']) . "] " . $mensaje);
    fwrite($puntero, "\n");
    fclose($puntero);
}
?>
