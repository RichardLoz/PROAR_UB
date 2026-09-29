<?php

$objEquipo = new stdClass();
$objEquipo->codigo = "eq001";
$objEquipo->descripcion = "Notebook para el taller de programación";
$objEquipo->precio = 850000;
$objEquipo->cantidad = 12;

$objEquipo2 = new stdClass();
$objEquipo2->codigo = "eq002";
$objEquipo2->descripcion = "Kit de robótica educativa";
$objEquipo2->precio = 120000;
$objEquipo2->cantidad = 20;

echo "<h1>Feria Tecnológica 2026: equipos</h1>";
echo "<h2>Objeto individual: <span style='color:blue'>\$objEquipo</span></h2>";
echo "<h3>Código: " . $objEquipo->codigo . "<br>";
echo "Descripción: " . $objEquipo->descripcion . "<br>";
echo "Precio por unidad: $" . $objEquipo->precio . "<br>";
echo "Cantidad disponible: " . $objEquipo->cantidad . "</h3>";
echo "<h3>Tipo de <span style='color:blue'>\$objEquipo</span>: " . gettype($objEquipo) . "</h3>";

echo "<h2>Arreglo de objetos</h2>";
$equipos = [];
array_push($equipos, $objEquipo, $objEquipo2);
echo "<h3 style='color:blue'>\$equipos</h3>";

foreach ($equipos as $equipo) {
    echo "<h4>Código: " . $equipo->codigo . " | " .
         "Descripción: " . $equipo->descripcion . " | " .
         "Precio por unidad: $" . $equipo->precio . " | " .
         "Cantidad disponible: " . $equipo->cantidad . "</h4>";
}
echo "<h3>Cantidad de tipos de equipo: " . count($equipos) . "</h3>";

$objInventario = new stdClass();
$objInventario->equipos = $equipos;
$objInventario->cantidadTiposDeEquipo = count($equipos);

echo "<h3>Cantidad de tipos de equipo en el objeto inventario: " . $objInventario->cantidadTiposDeEquipo . "</h3>";
echo "<h2>Inventario en formato JSON:</h2>";
$jsonInventario = json_encode($objInventario, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
echo "<pre>" . $jsonInventario . "</pre>";

?>
