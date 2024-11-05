<?php
session_start(); // Iniciar sesión

// Verificar si la sesión está activa
if (!isset($_SESSION['usuario'])) {
    // Si no hay sesión, redirigir a la página de error
    header('Location: ../No_session.php');
    exit();
}

include ("./db.php");
try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $user, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sql = "SELECT id_genero, genero FROM generos";
    $stmt = $conn->prepare($sql);
    $stmt->setFetchMode(PDO::FETCH_ASSOC);
    $stmt->execute();

$generos=[];
While($fila = $stmt->fetch()) {
array_push($generos,$fila);
}
$objgeneros = new stdClass();
$objgeneros->generos=$generos;
$salidaJson = json_encode($objgeneros);

echo $salidaJson;

} catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
}
$conn = null;