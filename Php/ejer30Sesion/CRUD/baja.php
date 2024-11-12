<?php
// Verificar si es una solicitud POST y si se recibe un ID
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    include('db.php');

    try {
        $conn = new PDO("mysql:host=$host;dbname=$dbname", $user, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $Id = filter_var($_POST['id'], FILTER_VALIDATE_INT);

        // Validar que el ID sea un número válido
        if (!$Id) {
            echo "Error: ID no válido.";
            exit;
        }

        // Eliminar la canción de la base de datos
        $sql = "DELETE FROM canciones WHERE ID = :ID";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':ID', $Id);

        if ($stmt->execute() && $stmt->rowCount() > 0) {
            echo "success";
        } else {
            echo "Error: No se pudo eliminar el registro.";
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
    exit;
}
?>
