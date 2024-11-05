<?php
session_start(); // Iniciar sesión

// Verificar si la sesión está activa
if (!isset($_SESSION['usuario'])) {
    // Si no hay sesión, redirigir a la página de error
    header('Location: ../no_session.php');
    exit();
}

$dbname="u182626001_PROAR_Rlozano";
$host="rilozano.com";
$user="u182626001_rlozano";
$password="Misoas2021";
?>
