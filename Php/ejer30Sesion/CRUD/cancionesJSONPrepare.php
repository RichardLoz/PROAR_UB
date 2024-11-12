<?php
include("./db.php");

try {
    // Establecer conexión con la base de datos
    $dsn = "mysql:host=$host;dbname=$dbname";
    $dbh = new PDO($dsn, $user, $password);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo json_encode(["error" => "Error de conexión: " . $e->getMessage()]);
    exit;
}

// Añadir un retraso para simular la carga
sleep(3);

// Capturar los filtros enviados por GET
$orden = isset($_GET["orden"]) && !empty($_GET["orden"]) ? $_GET["orden"] : 'ID';
$filterId = '%' . $_GET['filterID'] . '%';
$filterNombre = '%' . $_GET['filterNombre'] . '%';
$filterGenero = $_GET['filterGenero'];
$filterArtista = '%' . $_GET['filterArtista'] . '%';
$filterFecha = '%' . $_GET['filterFecha'] . '%';

try {
    // Consulta SQL para obtener las canciones con su género asociado
    $sql = "SELECT c.ID, c.nombre, IFNULL(g.genero, 'Sin género') as genero, 
                   c.artista, c.fecha_estreno, c.imagen_portada
            FROM canciones c
            LEFT JOIN generos g ON c.genero_id = g.id_genero
            WHERE 
                c.ID LIKE :ID AND 
                c.nombre LIKE :Nombre AND 
                c.artista LIKE :Artista AND 
                c.fecha_estreno LIKE :Fecha";
    
    // Agregar el filtro de género si está presente
    if (!empty($filterGenero)) {
        $sql .= " AND c.genero_id = :Genero";
    }

    // Ordenar los resultados
    $sql .= " ORDER BY " . $orden;
    $stmt2 = $dbh->prepare($sql);

    // Vincular los parámetros
    $stmt2->bindParam(':ID', $filterId);
    $stmt2->bindParam(':Nombre', $filterNombre);
    $stmt2->bindParam(':Artista', $filterArtista);
    $stmt2->bindParam(':Fecha', $filterFecha);

    if (!empty($filterGenero)) {
        $stmt2->bindParam(':Genero', $filterGenero);
    }

    $stmt2->execute();

    // Crear un array para almacenar las canciones
    $canciones = [];
    while ($fila = $stmt2->fetch(PDO::FETCH_ASSOC)) {
        // Preparar la imagen de portada
        $imagenPortada = $fila['imagen_portada'] ? base64_encode($fila['imagen_portada']) : null;

        // Construir cada fila con la información necesaria
        $canciones[] = [
            'ID' => $fila['ID'],
            'nombre' => $fila['nombre'],
            'genero' => $fila['genero'],
            'artista' => $fila['artista'],
            'fecha_estreno' => $fila['fecha_estreno'],
            'imagen_portada' => $imagenPortada
        ];
    }

    // Enviar la respuesta en formato JSON
    echo json_encode(['canciones' => $canciones]);

} catch (PDOException $e) {
    echo json_encode(["error" => "Error en la consulta SQL: " . $e->getMessage()]);
    exit;
}

// Cerrar la conexión a la base de datos
$dbh = null;
?>
