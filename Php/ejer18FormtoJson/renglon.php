<?php
// Arma el objeto Renglon a partir de los datos recibidos por POST/FILES.
// Lo comparten index.php (AJAX, devuelve JSON) y respuesta.php (envio tradicional).

// Unidades de medida parametrizables (cod => descripcion)
$unidades = array(
    1 => "Kg",
    2 => "Uni",
    3 => "Lata",
    4 => "Caja",
    5 => "Litro"
);

$codUnidad = $_POST['unidadDeMedida'];

$Renglon = new stdClass;
$Renglon->NroDeOrden = $_POST['nroOrden'];
$Renglon->CodigoProducto = $_POST['codigoProducto'];
$Renglon->Descripcion = $_POST['descripcion'];
$Renglon->Cantidad = $_POST['cantidad'];
$Renglon->UnidadDeMedida = $codUnidad . " - " . (isset($unidades[$codUnidad]) ? $unidades[$codUnidad] : "Desconocida");
$Renglon->PrecioUnitario = $_POST['precioUnitario'];
$Renglon->ImporteRenglon = $_POST['importeRenglon'];
// Del PDF solo informamos el nombre del archivo recibido
$Renglon->PdfComprobante = isset($_FILES['pdfComprobante']) ? $_FILES['pdfComprobante']['name'] : "";
?>
