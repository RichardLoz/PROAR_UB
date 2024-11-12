<?php


include ('db.php');

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $user, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $Id = $_POST['id']; 

    $sql = "DELETE FROM canciones WHERE ID = :ID";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':ID', $Id);
    $stmt->execute();

    echo "Registro eliminado exitosamente";
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>
