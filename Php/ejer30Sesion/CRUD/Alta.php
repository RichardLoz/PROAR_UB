<?php
session_start();


if (!isset($_POST['oculto'])) {
    exit("Error: El formulario no fue enviado correctamente.");
}

$respuesta_estado = ''; 

function conect()
{
    include('./db.php');
    try {
        // Conexión a la base de datos
        $conn = new PDO("mysql:host=$host;dbname=$dbname", $user, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Obtener datos del formulario
        $Nombre = $_POST['Nombre'];
        $Genero = $_POST['Genero'];
        $Artista = $_POST['Artista'];
        $Fecha = $_POST['Fecha'];
        $contenidoPortada = null;

        // Verifica si se subió un archivo de imagen y lo procesa
        if (!empty($_FILES['Portada']['tmp_name'])) {
            $contenidoPortada = file_get_contents($_FILES['Portada']['tmp_name']);
        }

        // Inserción en la base de datos
        $sql = 'INSERT INTO canciones (nombre, genero_id, artista, fecha_estreno, imagen_portada) VALUES (?, ?, ?, ?, ?)';
        $stmt = $conn->prepare($sql);
        $stmt->execute([$Nombre, $Genero, $Artista, $Fecha, $contenidoPortada]);

        echo "Registro guardado correctamente.";
    } catch (PDOException $e) {
        echo "Error al guardar el registro: " . $e->getMessage();
    } finally {
        $conn = null;
    }
}

// Ejecuta la función de conexión
conect();
?>
