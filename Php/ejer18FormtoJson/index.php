<?php
// Respuesta del requerimiento asincronico (AJAX): delay de 3 segundos para ver el loader
sleep(3);

include "renglon.php";

// Se devuelve el renglon como JSON
echo json_encode($Renglon);
?>
