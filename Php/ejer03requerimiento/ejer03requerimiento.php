<?php 
require ("./require.php");

echo "Valor de una variable incluida desde otro archivo: ". $numeroEjemplo;
echo "<br><br>";
echo "<table border='1'>";
echo "<tr>";
$contarProfesores = count($profesores);
for ($i = 0; $i < $contarProfesores; $i++) {
    echo "<tr>";
    foreach ($profesores[$i] as $valor) {
        echo "<td>";
        echo $valor;
        echo "</td>";
    }
    echo "</tr>";
}
echo "</table><br>";

echo "La longitud del arreglo es de:  ". $contarProfesores; 
?>
