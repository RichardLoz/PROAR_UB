<?php
// Verificar si se trata de una solicitud POST y si el parámetro 'id' está presente
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    include('db.php');

    try {
        // Establecer conexión con la base de datos
        $conn = new PDO("mysql:host=$host;dbname=$dbname", $user, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Validar el ID recibido
        $Id = filter_var($_POST['id'], FILTER_VALIDATE_INT);

        // Si el ID no es válido, devolver un error
        if (!$Id) {
            echo "Error: ID no válido. Recibido: " . $_POST['id'];
            exit;
        }

        // Preparar y ejecutar la consulta para eliminar la canción
        $sql = "DELETE FROM canciones WHERE ID = :ID";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':ID', $Id);

        if ($stmt->execute()) {
            // Verificar si se eliminó alguna fila
            if ($stmt->rowCount() > 0) {
                echo "success"; // Eliminación exitosa
            } else {
                // Mostrar error de depuración
                 $errorInfo = $stmt->errorInfo();
                 echo "Error: No se encontró la canción para eliminar. rowCount=" . $stmt->rowCount() . ". Info: " . print_r($errorInfo, true);
            }
        } else {
            echo "Error: No se pudo eliminar el registro.";
        }
    } catch (PDOException $e) {
        // Capturar y mostrar cualquier error de la base de datos
        echo "Error en la base de datos: " . $e->getMessage();
    }
    exit;
} else {
    // Si la solicitud no es válida, devolver un error
    echo "Solicitud no válida.";
    exit;
}
?>
