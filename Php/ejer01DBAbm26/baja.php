<?php
include ('./db.php');

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $user, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
}
$Id= $_GET['id'];

$sql="DELETE FROM canciones WHERE ID = :ID";

$stmt = $conn->prepare($sql);
$stmt->bindParam(':ID', $Id);
$stmt->setFetchMode(PDO::FETCH_ASSOC);
$stmt->execute();

?>
