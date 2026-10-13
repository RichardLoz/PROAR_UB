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
    <main class="container">
        <div class="card">
            <h2>Respuesta (JSON)</h2>
            <!-- JSON_PRETTY_PRINT lo indenta; htmlspecialchars evita interpretar el contenido como HTML -->
            <pre class="json"><?php echo htmlspecialchars(json_encode($Renglon, JSON_PRETTY_PRINT)); ?></pre>
            <div class="botones">
                <a class="btn btn-primario" href="ejer18FormtoJson.html">Volver</a>
            </div>
        </div>
    </main>
    <footer>
        <h1>Alumno: Ricardo Lozano</h1>
    </footer>
</body>

</html>
