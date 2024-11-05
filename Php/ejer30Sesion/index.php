<?php
session_start(); // Iniciar la sesión

// Verificar si la sesión está activa
if (!isset($_SESSION['usuario'])) {
    // Si no hay sesión, redirigir a FormLogin.html
    header('Location: FormLogin.html');
    exit();
}

// Si hay sesión, redirigir a la aplicación principal en CRUD/index.php
header('Location: CRUD/index.php');
exit();
?>
