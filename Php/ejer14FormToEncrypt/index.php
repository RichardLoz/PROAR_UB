<?php
// isset() es true solo si el navegador envió la variable "clave" por POST
// (formulario completado). Si no, se devuelve el formulario.
if (isset($_POST["clave"])) {
    $Aencriptar = $_POST["clave"];

    // htmlspecialchars evita que lo escrito por el usuario se interprete como HTML
    echo "Clave Ingresada: " . htmlspecialchars($Aencriptar) . "<br><br>";

    // md5(): hash unidireccional de 128 bits = 16 pares hexadecimales (128/8)
    echo "Clave encriptada en md5 (128 bits o 16 pares hexadecimales)<br>";
    echo md5($Aencriptar), "<br><br>";

    // sha1(): hash unidireccional de 160 bits = 20 pares hexadecimales (160/8)
    echo "Clave encriptada en Sha1 (160 bits o 20 pares hexadecimales)<br>";
    echo sha1($Aencriptar);
}
else {
// Se cierra PHP para emitir el HTML del formulario tal cual
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./style.css">
    <title>ejer14FormToEncrypt</title>
</head>
<body>
    <div class="container">
        <h1>Formulario de encriptación</h1>
        <!-- El form se envía a este mismo archivo por POST -->
        <form action="index.php" method="post">
            <label for="Clave"><h1>Ingrese la clave a encriptar</h1></label>
            <input type="text" name="clave" required>
            <button type="submit">ENCRIPTAR</button>
        </form>
    </div>
</body>
</html>
<?php
}
?>
