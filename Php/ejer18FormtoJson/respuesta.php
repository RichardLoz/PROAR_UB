<?php
// Destino del envio tradicional del formulario: muestra los datos en una pagina nueva
include "renglon.php";
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Respuesta - Renglon de Orden de Compra</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <header>
        <h1>Renglon recibido (envio tradicional)</h1>
    </header>
    <div class="container">
        <table class="datos">
            <?php foreach ($Renglon as $campo => $valor) { ?>
                <tr>
                    <th><?php echo htmlspecialchars($campo); ?></th>
                    <td><?php echo htmlspecialchars($valor); ?></td>
                </tr>
            <?php } ?>
        </table>
    </div>
    <div class="container"><a class="abrir" href="ejer18FormtoJson.html">Volver</a></div>
    <footer>
        <h1>Alumno: Ricardo Lozano</h1>
    </footer>
</body>

</html>
