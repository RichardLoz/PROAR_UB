<?php

$objRenglonAutomoviles = new stdclass;
$objRenglonAutomoviles->codAuto = "aut1";
$objRenglonAutomoviles->Descripcion = "Audi A4 2018";
$objRenglonAutomoviles->PrecioAuto = 400000;
$objRenglonAutomoviles->Cantidad = 4;

$objRenglonAutomoviles2 = new stdclass;
$objRenglonAutomoviles2->codAuto = "aut2";
$objRenglonAutomoviles2->Descripcion = "Bmw X6 2024";
$objRenglonAutomoviles2->PrecioAuto = 600000;
$objRenglonAutomoviles2->Cantidad = 3;

echo "<h1>Variables Objeto </h1>";
echo " <h1 style='color:blue'> \$objRenglonAutomoviles </h1>";
echo "<h3>codAuto: " . $objRenglonAutomoviles->codAuto . "<br>";
echo "Descripcion: " . $objRenglonAutomoviles->Descripcion . "<br>";
echo "PrecioAuto: $" . $objRenglonAutomoviles->PrecioAuto . "<br>";
echo "Cantidad: " . $objRenglonAutomoviles->Cantidad . "<br> </h3>";
echo "<h1>Tipo de <span style='color:blue'> \$objRenglonAutomoviles : </span> ". gettype($objRenglonAutomoviles)." </h1>";

echo "<h1>Arreglo de Objetos </h1>";

$RenglonesAutomoviles = [];
array_push($RenglonesAutomoviles,$objRenglonAutomoviles,$objRenglonAutomoviles2);

echo "<h1 style='color:blue'>\$RenglonesAutomoviles : ";

foreach($RenglonesAutomoviles as $objRenglonAutomoviles){
    echo "<h4> Cod Auto: " . $objRenglonAutomoviles->codAuto . " | " .
         "Descripción: " . $objRenglonAutomoviles->Descripcion . " | " .
         "Precio: " . $objRenglonAutomoviles->PrecioAuto . " | " .
         "Cantidad: " . $objRenglonAutomoviles->Cantidad . "</h4>";
};
echo "<h3>Cantidad de renglones en el arreglo :" . count($RenglonesAutomoviles) . "</h3>";

$objRenglonesAutomoviles = new stdClass();

$objRenglonesAutomoviles->RenglonesAutomoviles=$RenglonesAutomoviles;
$objRenglonesAutomoviles->cantidadRenglones= count($RenglonesAutomoviles);

echo "<h3>Cantidad de renglones en el objRenglonesAutomoviles: " . $objRenglonesAutomoviles->cantidadRenglones . "</h3>";

echo "<h2>Producción de un JSON jsonRenglones: </h2>";

$jsonRenglonesAutomoviles = json_encode($objRenglonesAutomoviles);
echo "<h3>" .$jsonRenglonesAutomoviles . "</h3>";

?>