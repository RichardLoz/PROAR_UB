<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ejercicio01Base</title>
    <link rel="stylesheet" href="./style.css">
</head>
<body>

<h2>Todo lo escrito fuera de las marcas de php es entregado en la respuesta http sin pasar por el procesador php</h2>
<hr>

<?php
$mivariable = "Feria Tecnológica 2026";

echo "<h2> Todo el texto y/o HTML <span> entregado por el procesador PHP </span> usando la sentencia Echo </h2>";
echo "<hr>";

echo "<h2> Sin usar concatenador <span>\$mivariable</span> : $mivariable</h2>";
echo "<h2> Usando concatenador <span>\$mivariable</span> : " . $mivariable . "</h2>";
echo "<hr>";

$mivariable = true;
echo "<h2> Variable tipo booleana (Verdadero) <span>\$mivariable</span> : " . ($mivariable ? 'true' : 'false') . "</h2>";
$mivariable = false;
echo "<h2> Variable tipo booleana (Falso) <span>\$mivariable</span> : " . ($mivariable ? 'true' : 'false') . "</h2>";
echo "<hr>";

define("MiConstante", "ValorConstante");
echo "<h2> <span>MiConstante</span> : " . MiConstante . "</h2>";
echo "<h2>Tipo de <span>MiConstante (tipo)</span> : " . gettype(MiConstante) . "</h2>";
echo "<hr>";

echo "<h2> Arreglos : </h2>";

$aEquipos = array("Notebook", "Tablet");
echo "<p><span>\$aEquipos[0]</span> : $aEquipos[0]</p>";
echo "<p><span>\$aEquipos[1]</span> : $aEquipos[1]</p>";
echo "<p>Tipo de <span> \$aEquipos </span> : " . gettype($aEquipos) . "</p>";

 $aEquipos[] = "Impresora 3D";
 $aEquipos[] = "Robot educativo";
echo "<h2>Se agregan dos equipos al arreglo</h2>";
echo "<h2>Equipos disponibles en la feria:</h2>";
foreach ($aEquipos as $equipo) {
    echo "<ul><li>" . $equipo . "</li></ul>";
}

$ArrayPalabrasEspanol = array("Variable", "Valor", "Tipo");
$ArrayPalabrasIngles = array("Variable", "Value", "Type");
$ArrayPalabrasItaliano = array("Variabile", "Valore", "Tipo");
$ArrayPalabrasFrances = array("Variable", "Valeur", "Type");

$aDiccionarioBasico = [
    $ArrayPalabrasEspanol,
    $ArrayPalabrasIngles,
    $ArrayPalabrasItaliano,
    $ArrayPalabrasFrances,
];

echo "<h2>Arreglo de dos dimensiones: glosario de programación</h2>";
echo "<h4>La variable \$aDiccionarioBasico tiene el siguiente tipo: array</h4>   ";

echo "<table>";
echo "<tr>";
echo "<th>Español</th><th>Inglés</th><th>Italiano</th><th>Francés</th>";
echo "</tr>";

for ($i = 0; $i < count($ArrayPalabrasEspanol); $i++) {
    echo "<tr>";
    foreach ($aDiccionarioBasico as $ArraydePalabras) {
        echo "<td>";
        echo $ArraydePalabras[$i];
        echo "</td>";
    }
    echo "</tr>";
}

echo "</table><br>";
echo "<h3>También se puede acceder con \$aDiccionarioBasico[0][2]: " . $aDiccionarioBasico[0][2] . "</h3>";
echo "<h3>Cantidad de idiomas del glosario: <span>".count($aDiccionarioBasico) ."</span></h3>";
echo "<br>";

echo "<h1>Arreglo asociativo: inscripción a la feria</h1>";
$inscripcion = ["nombre" => "Lucía Gómez", "taller" => "Robótica", "entradas" => 2, "fecha" => "15/10/2026"];
echo "<h4>Participante: " . $inscripcion['nombre'] . "</h4>";
echo "Participante: " . ($inscripcion['nombre']);
echo "<br>";
echo "Taller elegido: " . $inscripcion['taller'];
echo "<br>";
echo "Fecha de inscripción: " . ($inscripcion['fecha']);
echo "<br>";

echo "<h2>Expresiones aritméticas: presupuesto del taller</h2>";
$y = 2;
$x = 8;
$z = $y + $x;
$m = $x - $y;
$s = $x * $y;
$d = $x / $y;
echo "La variable \$y tiene el siguiente valor: " . $y;
echo "<br>";
echo "<br>La variable \$x tiene el siguiente valor: " . $x;
echo "<br>";
echo "<br>La variable \$y tiene el siguiente tipo: " . gettype($y);
echo "<br>";
echo "<br>La variable \$x tiene el siguiente tipo: " . gettype($x);
echo "<br>";
echo "<br>Una suma entre \$x + \$y: " . $z;
echo "<br>";
echo "<br>Una resta entre \$x - \$y: " . $m;
echo "<br>";
echo "<br>Una multiplicación entre \$x * \$y: " . $s;
echo "<br>";
echo "<br>Una división entre \$x / \$y: " . $d;
?>

</body>
</html>
