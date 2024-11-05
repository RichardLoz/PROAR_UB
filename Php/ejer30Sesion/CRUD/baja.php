<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header('Location: ../No_session.php');
    exit();
}

include ('./db.php');

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $user, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $Id = $_POST['id']; // Asegúrate de usar POST

    $sql = "DELETE FROM canciones WHERE ID = :ID";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':ID', $Id);
    $stmt->execute();

    echo "Registro eliminado exitosamente";
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>
