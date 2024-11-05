<?php
session_start(); // Iniciar sesión

// Verificar si la sesión está activa
if (!isset($_SESSION['usuario'])) {
    // Si no hay sesión, redirigir a la página de error
    header('Location: ../no_session.php');
    exit();
}

include ('./db.php');

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $user, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $Id = $_GET['id'];

    $sql = "DELETE FROM canciones WHERE ID = :ID";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':ID', $Id);
    $stmt->execute();

    echo "Registro eliminado exitosamente";
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>
