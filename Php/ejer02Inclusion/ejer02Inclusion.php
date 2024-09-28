<?php 
include ("./include.php");

echo "Valor de una variable incluida desde otro archivo: ". $numeroEjemplo;
echo "<br><br>";
echo "<table border='1'>";
echo "<tr>";
$contarProgramadores = count($programadores);
for ($i = 0; $i < $contarProgramadores; $i++) {
    echo "<tr>";
    foreach ($programadores[$i] as $valor) {
        echo "<td>";
        echo $valor;
        echo "</td>";
    }
    echo "</tr>";
}
echo "</table><br>";

echo "La longitud del arreglo es de:  ". $contarProgramadores; 
?>
