<?php
sleep(2);

// Unidades de medida parametrizables (cod => descripcion)
$unidades = array(
    1 => "Kg",
    2 => "Uni",
    3 => "Lata",
    4 => "Caja",
    5 => "Litro"
);

$nroOrden = $_POST['nroOrden'];
$codigoProducto = $_POST['codigoProducto'];
$descripcion = $_POST['descripcion'];
$cantidad = $_POST['cantidad'];
$codUnidad = $_POST['unidadDeMedida'];
$precioUnitario = $_POST['precioUnitario'];
$importeRenglon = $_POST['importeRenglon'];
$pdfComprobante = isset($_FILES['pdfComprobante']) ? $_FILES['pdfComprobante']['name'] : "";

$Renglon = new stdClass;
$Renglon->NroDeOrden = $nroOrden;
$Renglon->CodigoProducto = $codigoProducto;
$Renglon->Descripcion = $descripcion;
$Renglon->Cantidad = $cantidad;
$Renglon->UnidadDeMedida = $codUnidad . " - " . (isset($unidades[$codUnidad]) ? $unidades[$codUnidad] : "Desconocida");
$Renglon->PrecioUnitario = $precioUnitario;
$Renglon->ImporteRenglon = $importeRenglon;
$Renglon->PdfComprobante = $pdfComprobante;
$renglonJSON = json_encode($Renglon);
echo $renglonJSON;
?>
