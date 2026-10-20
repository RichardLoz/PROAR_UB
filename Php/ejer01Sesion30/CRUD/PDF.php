<?php
include('./db.php');
try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $user, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
}


$Id= $_GET['id'];

$sql="SELECT imagen_portada FROM canciones WHERE (ID LIKE :ID)";

$stmt = $conn->prepare($sql);
$stmt->bindParam(':ID', $Id);
$stmt->setFetchMode(PDO::FETCH_ASSOC);
$stmt->execute();


While($fila = $stmt->fetch()) {
$objCancion= new stdClass();
$objCancion->PNG=base64_encode($fila['PDF']);
}

$salidaJson = json_encode($objCancion,JSON_INVALID_UTF8_SUBSTITUTE);
echo $salidaJson;
$conn = null;