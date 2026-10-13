<?php
// Un solo archivo para los dos tipos de envio:
//  - AJAX: devuelve solo el JSON (con delay de 3 segundos para ver el loader)
//  - Tradicional: muestra una pagina HTML con el JSON

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

// jQuery agrega este header en los requerimientos AJAX
$esAjax = isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] === 'XMLHttpRequest';

if ($esAjax) {
    sleep(3);
    echo json_encode($Renglon);
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Respuesta - Renglon de Orden de Compra</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <header>
        <h1>Renglon recibido (envio tradicional)</h1>
    </header>
    <main class="container">
        <div class="card">
            <h2>Respuesta (JSON)</h2>
            <!-- JSON_PRETTY_PRINT lo indenta; htmlspecialchars evita interpretar el contenido como HTML -->
            <pre class="json"><?php echo htmlspecialchars(json_encode($Renglon, JSON_PRETTY_PRINT)); ?></pre>
            <div class="botones">
                <a class="btn btn-primario" href="ejer18FormtoJson.html">Volver</a>
            </div>
        </div>
    </main>
    <footer>
        <h1>Alumno: Ricardo Lozano</h1>
    </footer>
</body>

</html>
