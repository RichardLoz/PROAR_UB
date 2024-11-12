<?php
include("./db.php");

try {
    $dsn = "mysql:host=$host;dbname=$dbname";
    $dbh = new PDO($dsn, $user, $password);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo json_encode(["error" => "Error de conexión: " . $e->getMessage()]);
    exit;
}

$orden = isset($_GET["orden"]) && !empty($_GET["orden"]) ? $_GET["orden"] : 'ID';
$filterId = '%' . $_GET['filterID'] . '%';
$filterNombre = '%' . $_GET['filterNombre'] . '%';
$filterGenero = $_GET['filterGenero'];
$filterArtista = '%' . $_GET['filterArtista'] . '%';
$filterFecha = '%' . $_GET['filterFecha'] . '%';

try {
    $sql = "SELECT c.ID, c.nombre, IFNULL(g.genero, 'Sin género') as genero, 
                   c.artista, c.fecha_estreno, c.imagen_portada
            FROM canciones c
            LEFT JOIN generos g ON c.genero_id = g.id_genero
            WHERE 
                c.ID LIKE :ID AND 
                c.nombre LIKE :Nombre AND 
                c.artista LIKE :Artista AND 
                c.fecha_estreno LIKE :Fecha";

    if (!empty($filterGenero)) {
        $sql .= " AND c.genero_id = :Genero";
    }

    $sql .= " ORDER BY " . $orden;
    $stmt2 = $dbh->prepare($sql);

    $stmt2->bindParam(':ID', $filterId);
    $stmt2->bindParam(':Nombre', $filterNombre);
    $stmt2->bindParam(':Artista', $filterArtista);
    $stmt2->bindParam(':Fecha', $filterFecha);
    if (!empty($filterGenero)) {
        $stmt2->bindParam(':Genero', $filterGenero);
    }

    $stmt2->execute();

    $canciones = [];
    while ($fila = $stmt2->fetch(PDO::FETCH_ASSOC)) {
        $imagenPortada = $fila['imagen_portada'] ? base64_encode($fila['imagen_portada']) : null;
        $canciones[] = [
            'ID' => $fila['ID'],
            'nombre' => $fila['nombre'],
            'genero' => $fila['genero'],
            'artista' => $fila['artista'],
            'fecha_estreno' => $fila['fecha_estreno'],
            'imagen_portada' => $imagenPortada
        ];
    }
    echo json_encode(['canciones' => $canciones]);
} catch (PDOException $e) {
    echo json_encode(["error" => "Error en la consulta SQL: " . $e->getMessage()]);
    exit;
}

$dbh = null;
?>
