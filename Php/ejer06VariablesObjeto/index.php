<?php

$objRenglonAutomoviles = new stdclass;
$objRenglonAutomoviles->codAuto = "aut1";
$objRenglonAutomoviles->Descripcion = "Audi A4 2018";
$objRenglonAutomoviles->PrecioAuto = 400000;
$objRenglonAutomoviles->Cantidad = 4;

echo "<h1>Variables Objeto </h1><br><br>";
echo " <h1 style='color:blue'> \$objRenglonAutomoviles </h1>";
echo "<h3>codAuto: " . $objRenglonAutomoviles->codAuto . "<br>";
echo "Descripcion: " . $objRenglonAutomoviles->Descripcion . "<br>";
echo "PrecioAuto: $" . $objRenglonAutomoviles->PrecioAuto . "<br>";
echo "Cantidad: " . $objRenglonAutomoviles->Cantidad . "<br> </h3>";
echo "<h1 style='color:blue'>\$objRenglonAutomoviles : ". gettype($objRenglonAutomoviles)." </h1>";



$RenglonesAutomoviles = [];
array_push($RenglonesAutomoviles,$objRenglonAutomoviles);

echo "<h1 style='color:blue'>\$RenglonesAutomoviles : <br>";


foreach($RenglonesAutomoviles as $objRenglonAutomoviles){
    echo "<h4> Cod Auto : " . $objRenglonAutomoviles->codAuto . "</h4>";
    echo "<h4> Descripcion: " . $objRenglonAutomoviles->Descripcion . "</h4>";
    echo "<h4> Precio Auto : " . $objRenglonAutomoviles->PrecioAuto . "</h4>";
    echo "<h4> Cantidad : " . $objRenglonAutomoviles->Cantidad . "</h4>";
};
echo "<h3>Cantidad de renglones en el arreglo :" . count($RenglonesAutomoviles) . "</h3>";

$objRenglonesAutomoviles = new stdClass();

$objRenglonesAutomoviles->RenglonesAutomoviles=$RenglonesAutomoviles;
$objRenglonesAutomoviles->cantidadRenglones= count($RenglonesAutomoviles);

echo "<br><br><h3>Cantidad de renglones en el objRenglonesAutomoviles: " . $objRenglonesAutomoviles->cantidadRenglones . "</h3><br><br>";

$jsonRenglonesAutomoviles = json_encode($objRenglonesAutomoviles);
echo "<h3>" .$jsonRenglonesAutomoviles . "</h3>";

?>