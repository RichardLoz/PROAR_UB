<?php
$dbname="u182626001_PROAR_Rlozano";
$host="rilozano.com";
$user="u182626001_rlozano";
$password="Misoas2021";
try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $user, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sql = "SELECT genero FROM Generos";
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