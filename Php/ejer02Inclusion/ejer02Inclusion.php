<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ejercicio02Inclusion</title>
    <link rel="stylesheet" href="./style.css">
</head>
<body>

<?php 

include ("./include.php");

echo "<h2>Feria Tecnológica 2026</h2>";
echo "<h3>Ejercicio de inclusión (include). Número de ejemplo: ". $numeroEjemplo . "</h3>";
echo "<table border='1'>";
echo "<tr><th>Taller</th><th>Instructor/a</th></tr>";
$cantidadTalleres = count($talleres);
for ($i = 0; $i < $cantidadTalleres; $i++) {
    echo "<tr><td>" . $talleres[$i][0] . "</td><td>" . $talleres[$i][1] . "</td></tr>";
}
echo "</table>";

echo "<h4>Cantidad de talleres: " . $cantidadTalleres . "</h4>";
?>
</body>
</html>
