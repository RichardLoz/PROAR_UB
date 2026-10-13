<?php
// Devuelve en JSON las unidades de medida para llenar el desplegable (select) del filtro.
// Lo llama index.php por AJAX al cargar la página.
include ("./db.php"); // trae $host, $dbname, $user, $password

try {
    // 1. Conectar a la base con PDO
    $conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $user, $password);
    // Que PDO lance excepciones si hay un error SQL
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // 2. Consulta: unidades de medida (tabla parametrizable), ordenadas por descripción
    $sql = "SELECT cod_unidad, descripcion FROM unidades_medida ORDER BY descripcion";
    $stmt = $conn->prepare($sql);
    $stmt->setFetchMode(PDO::FETCH_ASSOC); // cada fila como array asociativo
    $stmt->execute();

    // 3. Pasar cada fila a un array
    $unidades = [];
    while ($fila = $stmt->fetch()) {
        array_push($unidades, $fila);
    }

    // 4. Armar el objeto de respuesta: { "unidades": [ {cod_unidad, descripcion}, ... ] }
    $objUnidades = new stdClass();
    $objUnidades->unidades = $unidades;

    // 5. Enviar el JSON al navegador
    echo json_encode($objUnidades);

} catch(PDOException $e) {
    // Si algo falla, avisar al navegador con un JSON de error
    echo json_encode(["error" => "Error: " . $e->getMessage()]);
}
$conn = null; // cerrar la conexión
