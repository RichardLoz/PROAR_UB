<?php
include ("./db.php");

try {
    // Establecer conexión con la base de datos
    $dsn = "mysql:host=$host;dbname=$dbname";
    $dbh = new PDO($dsn, $user, $password);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    // Manejo de error en la conexión
    echo json_encode(["error" => "Error de conexión: " . $e->getMessage()]);
    exit;
}

sleep(3);

// Capturar los filtros enviados por GET
$orden = isset($_GET["orden"]) && !empty($_GET["orden"]) ? $_GET["orden"] : 'ID';
$filterId = '%' . $_GET['filterID'] . '%';
$filterNombre = '%' . $_GET['filterNombre'] . '%';
$filterGenero = $_GET['filterGenero']; // Filtro exacto de género
$filterArtista = '%' . $_GET['filterArtista'] . '%';
$filterFecha = '%' . $_GET['filterFecha'] . '%';

$filterGenero = $_GET['filterGenero']; // Filtro exacto de género
error_log("Genero recibido en el servidor: " . $filterGenero);


try {
    // Consulta SQL con LEFT JOIN para incluir los géneros
    $sql = "SELECT c.ID, c.nombre, IFNULL(g.genero, 'Sin género') as genero, c.artista, c.fecha_estreno
            FROM canciones c
            LEFT JOIN generos g ON c.genero_id = g.id_genero
            WHERE 
                c.ID LIKE :ID AND 
                c.nombre LIKE :Nombre AND 
                c.artista LIKE :Artista AND 
                c.fecha_estreno LIKE :Fecha";
    
    // Agregar el filtro de género solo si el filtro no está vacío
    if (!empty($filterGenero)) {
        $sql .= " AND c.genero_id = :Genero";
    }

    // Ordenar según el campo elegido
    $sql .= " ORDER BY " . $orden;

    // Preparar la consulta
    $stmt2 = $dbh->prepare($sql);

    // Vincular los parámetros
    $stmt2->bindParam(':ID', $filterId);
    $stmt2->bindParam(':Nombre', $filterNombre);
    $stmt2->bindParam(':Artista', $filterArtista);
    $stmt2->bindParam(':Fecha', $filterFecha);

    // Si el filtro de género no está vacío, vinculamos el valor de `genero_id`
    if (!empty($filterGenero)) {
        $stmt2->bindParam(':Genero', $filterGenero);
    }

    // Ejecutar la consulta
    $stmt2->setFetchMode(PDO::FETCH_ASSOC);
    $stmt2->execute();

    // Crear un array para almacenar las canciones
    $canciones = [];
    while ($fila = $stmt2->fetch()) {
        $objCancion = new stdClass();
        $objCancion->Id = $fila['ID'];
        $objCancion->Nombre = $fila['nombre'];
        $objCancion->Genero = $fila['genero'];
        $objCancion->Artista = $fila['artista'];
        $objCancion->Fecha = $fila['fecha_estreno'];
        array_push($canciones, $objCancion);
    }

    // Crear el objeto JSON con la lista de canciones
    $objCanciones = new stdClass();
    $objCanciones->canciones = $canciones;
    $objCanciones->cuenta = count($canciones);

    // Enviar la respuesta en formato JSON
    echo json_encode($objCanciones);

} catch (PDOException $e) {
    // Enviar el error si la consulta falla
    echo json_encode(["error" => "Error en la consulta SQL: " . $e->getMessage()]);
    exit;
}

// Cerrar la conexión
$dbh = null;
?>
