<?php
session_start(); // Iniciar sesión

// Verificar si la sesión está activa
if (!isset($_SESSION['usuario'])) {
    // Si no hay sesión, redirigir a la página de error
    header('Location: ../no_session.php');
    exit();
}

if (!isset($_GET['id'])) {
    echo json_encode(["error" => "No se recibió un ID válido."]);
    exit();
}

include('./db.php');

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $user, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    echo json_encode(["error" => "Error de conexión: " . $e->getMessage()]);
    exit();
}

$Id = $_GET['id'];
$sqlSelect = "SELECT id AS Id, nombre AS Nombre, genero_id AS Genero, artista AS Artista, fecha_estreno AS Fecha FROM canciones WHERE id = :ID";
$stmtSelect = $conn->prepare($sqlSelect);
$stmtSelect->bindParam(':ID', $Id, PDO::PARAM_INT);
$stmtSelect->execute();
$fila = $stmtSelect->fetch(PDO::FETCH_ASSOC);

if ($fila) {
    echo json_encode($fila);
} else {
    echo json_encode(["error" => "No se encontraron datos para el ID especificado."]);
}
?>
