<?php
include ("./db.php");
try {
    // Estableciendo la conexión a la base de datos
    $dsn = "mysql:host=$host;dbname=$dbname";
    $dbh = new PDO($dsn, $user, $password);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    // Manejo de error en caso de fallo de conexión
    echo json_encode(["error" => "Error de conexión: " . $e->getMessage()]);
    exit; // Detenemos la ejecución si hay un error de conexión
}

sleep(1);

// Capturando los parámetros enviados por GET
$orden = $_GET["orden"];
$filterId = '%' . $_GET['filterID'] . '%';
$filterNombre = '%' . $_GET['filterNombre'] . '%';
$filterGenero = '%' . $_GET['filterGenero'] . '%';
$filterArtista = '%' . $_GET['filterArtista'] . '%';
$filterFecha = '%' . $_GET['filterFecha'] . '%';

try {
    // Consulta SQL que utiliza filtros para la tabla 'Canciones' (sin JOIN)
    $sql = "SELECT * FROM canciones 
            WHERE 
                (ID LIKE :ID) AND 
                (nombre LIKE :Nombre) AND
                (genero_id LIKE :Genero) AND 
                (artista LIKE :Artista) AND 
                (fecha_estreno LIKE :Fecha)
            ORDER BY " . $orden;

    $stmt2 = $dbh->prepare($sql);

    // Vinculando los parámetros de la sentencia preparada
    $stmt2->bindParam(':ID', $filterId);
    $stmt2->bindParam(':Nombre', $filterNombre);
    $stmt2->bindParam(':Genero', $filterGenero);
    $stmt2->bindParam(':Artista', $filterArtista);
    $stmt2->bindParam(':Fecha', $filterFecha);

    $stmt2->setFetchMode(PDO::FETCH_ASSOC);
    $stmt2->execute();

    // Creando un array para almacenar los datos de las canciones
    $canciones = [];
    while ($fila = $stmt2->fetch()) {
        $objCancion = new stdClass();
        $objCancion->Id = $fila['ID'];
        $objCancion->Nombre = $fila['nombre'];
        $objCancion->Genero = $fila['genero_id'];  // Aquí se devuelve el ID del género, no el nombre
        $objCancion->Artista = $fila['artista'];
        $objCancion->Fecha = $fila['fecha_estreno'];
        array_push($canciones, $objCancion);
    }

    // Crear un objeto JSON con la lista de canciones
    $objCanciones = new stdClass();
    $objCanciones->canciones = $canciones;
    $objCanciones->cuenta = count($canciones);

    // Convertir el objeto a formato JSON
    $salidaJson = json_encode($objCanciones);

    // Enviar la respuesta en formato JSON
    echo $salidaJson;

} catch (PDOException $e) {
    // Si hay un error en la consulta, enviamos el mensaje de error como JSON
    echo json_encode(["error" => "Error en la consulta SQL: " . $e->getMessage()]);
    exit;  // Detenemos la ejecución si hay un error en la consulta
}

// Cerrar la conexión
$dbh = null;
?>
