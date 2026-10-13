<?php
// Devuelve en JSON los renglones de órdenes de compra, aplicando filtros y orden.
// Lo llama index.php por AJAX al presionar "Cargar Datos".
include ("./db.php"); // trae $host, $dbname, $user, $password

// ---- 1. Conexión a la base ----
try {
    $dsn = "mysql:host=$host;dbname=$dbname;charset=utf8mb4";
    $dbh = new PDO($dsn, $user, $password);
    // Que PDO lance excepciones si hay un error SQL
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    echo json_encode(["error" => "Error de conexión: " . $e->getMessage()]);
    exit;
}

// Pausa de 3 segundos para poder ver el "Esperando respuesta..." en el navegador (efecto didáctico)
sleep(3);

// ---- 2. Orden ----
// Lista blanca: solo se puede ordenar por estas columnas.
// Evita inyección SQL, porque ORDER BY no admite parámetros con prepare().
$ordenesPermitidos = [
    'id'              => 'r.id',
    'nro_orden'       => 'r.nro_orden',
    'codigo_producto' => 'r.codigo_producto',
    'descripcion'     => 'r.descripcion',
    'cantidad'        => 'r.cantidad',
    'cod_unidad'      => 'r.cod_unidad',
    'precio_unitario' => 'r.precio_unitario',
    'importe_renglon' => 'r.importe_renglon',
];
$orden = isset($_GET["orden"]) ? strtolower($_GET["orden"]) : '';
// Si el valor no está en la lista (o viene vacío), se usa el orden por defecto
$orden = $ordenesPermitidos[$orden] ?? 'r.nro_orden, r.id';

// ---- 3. Filtros (llegan por GET) ----
// Los de texto llevan % a ambos lados para que LIKE busque "contiene"
$filterNroOrden = '%' . ($_GET['filterNroOrden'] ?? '') . '%';
$filterCodigo = '%' . ($_GET['filterCodigo'] ?? '') . '%';
$filterDescripcion = '%' . ($_GET['filterDescripcion'] ?? '') . '%';
$filterUnidad = $_GET['filterUnidad'] ?? ''; // el de unidad es exacto (viene de un select)

try {
    // ---- 4. Consulta SQL ----
    // LEFT JOIN: trae la descripción de la unidad desde unidades_medida
    // Los :NombreParametro se reemplazan de forma segura más abajo (bindParam)
    $sql = "SELECT r.nro_orden, r.codigo_producto, r.descripcion, r.cantidad,
                   r.cod_unidad, IFNULL(u.descripcion, '') AS unidad_desc,
                   r.precio_unitario, r.importe_renglon, r.pdf_imagen
            FROM renglones_orden_compra r
            LEFT JOIN unidades_medida u ON r.cod_unidad = u.cod_unidad
            WHERE
                r.nro_orden LIKE :NroOrden AND
                r.codigo_producto LIKE :Codigo AND
                r.descripcion LIKE :Descripcion";

    // El filtro de unidad solo se agrega si el usuario eligió una
    if (!empty($filterUnidad)) {
        $sql .= " AND r.cod_unidad = :Unidad";
    }

    // Agregar el orden validado en el paso 2
    $sql .= " ORDER BY " . $orden;

    // ---- 5. Preparar y ejecutar ----
    $stmt2 = $dbh->prepare($sql);
    // Asociar cada parámetro con su valor
    $stmt2->bindParam(':NroOrden', $filterNroOrden);
    $stmt2->bindParam(':Codigo', $filterCodigo);
    $stmt2->bindParam(':Descripcion', $filterDescripcion);
    if (!empty($filterUnidad)) {
        $stmt2->bindParam(':Unidad', $filterUnidad);
    }
    $stmt2->setFetchMode(PDO::FETCH_ASSOC); // cada fila como array asociativo
    $stmt2->execute();

    // ---- 6. Armar la respuesta ----
    // Por cada fila de la base se crea un objeto renglón con los nombres que usa el JS
    $renglones = [];
    while ($fila = $stmt2->fetch()) {
        $objRenglon = new stdClass();
        $objRenglon->NroOrden = $fila['nro_orden'];
        $objRenglon->CodigoProducto = $fila['codigo_producto'];
        $objRenglon->Descripcion = $fila['descripcion'];
        $objRenglon->Cantidad = $fila['cantidad'];
        // Unidad en formato "cod-unidad descripción", ej: "KG Kilogramo"
        $objRenglon->Unidad = $fila['cod_unidad'] . ' ' . $fila['unidad_desc'];
        $objRenglon->PrecioUnitario = $fila['precio_unitario'];
        $objRenglon->ImporteRenglon = $fila['importe_renglon']; // cantidad * precio (calculado en la base)
        $objRenglon->PdfImagen = $fila['pdf_imagen'];           // ruta de la imagen del producto
        array_push($renglones, $objRenglon);
    }

    // Objeto final: { "renglones": [...], "cuenta": N }
    $objRenglones = new stdClass();
    $objRenglones->renglones = $renglones;
    $objRenglones->cuenta = count($renglones);

    // Enviar el JSON al navegador
    echo json_encode($objRenglones);

} catch (PDOException $e) {
    // Si falla la consulta, devolver el error en JSON
    echo json_encode(["error" => "Error en la consulta SQL: " . $e->getMessage()]);
    exit;
}

$dbh = null; // cerrar la conexión
?>
