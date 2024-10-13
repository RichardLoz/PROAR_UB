<?php
include ("./db.php");

try {
    $dsn = "mysql:host=$host;dbname=$dbname";
    $dbh = new PDO($dsn, $user, $password);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    echo "Error de conexión: " . $e->getMessage();
}

sleep(1);

// Capturando los filtros enviados desde el frontend
$orden = $_GET["orden"];
$filterId = '%' . $_GET['filterID'] . '%';
$filterNombre = '%' . $_GET['filterNombre'] . '%';
$filterGenero = '%' . $_GET['filterGenero'] . '%';
$filterArtista = '%' . $_GET['filterArtista'] . '%';
$filterFecha = '%' . $_GET['filterFecha'] . '%';

// Consultando las canciones aplicando los filtros
$sql = "SELECT c.id_cancion, c.nombre, g.descripcion as genero_nombre, c.artista, c.fecha_estreno, c.imagen_portada 
        FROM canciones c
        LEFT JOIN generos g ON c.genero_id = g.id
        WHERE 
            (c.id_cancion LIKE :id) AND 
            (c.nombre LIKE :nombre) AND
            (c.genero_id LIKE :genero) AND 
            (c.artista LIKE :artista) AND 
            (c.fecha_estreno LIKE :fecha_estreno)
        ORDER BY " . $orden;

$stmt2 = $dbh->prepare($sql);

// Vinculando los parámetros de la consulta
$stmt2->bindParam(':id', $filterId);
$stmt2->bindParam(':nombre', $filterNombre);
$stmt2->bindParam(':genero', $filterGenero);
$stmt2->bindParam(':artista', $filterArtista);
$stmt2->bindParam(':fecha_estreno', $filterFecha);

$stmt2->setFetchMode(PDO::FETCH_ASSOC);
$stmt2->execute();

// Creando un array para almacenar las canciones
$canciones = [];
while ($fila = $stmt2->fetch()) {
    $objCancion = new stdClass();
    $objCancion->id_cancion = $fila['id_cancion'];
    $objCancion->nombre = $fila['nombre'];
    $objCancion->genero_nombre = $fila['genero_nombre'];
    $objCancion->artista = $fila['artista'];
    $objCancion->fecha_estreno = $fila['fecha_estreno'];
    $objCancion->imagen_portada = base64_encode($fila['imagen_portada']); // Convertir la imagen a base64
    array_push($canciones, $objCancion);
}

// Crear el objeto JSON con las canciones y la cuenta total
$objCanciones = new stdClass();
$objCanciones->canciones = $canciones;
$objCanciones->cuenta = count($canciones);

// Convertir el objeto a formato JSON
$salidaJson = json_encode($objCanciones);

// Enviar la respuesta en formato JSON
echo $salidaJson;

// Cerrar la conexión
$dbh = null;
?>
