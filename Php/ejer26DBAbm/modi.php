<?php

if(!isset($_POST['oculto'])){
    exit();
}
else{
    conectModi();
}

function conectModi(){
    include('./db.php');
    try {
        $conn = new PDO("mysql:host=$host;dbname=$dbname", $user, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch(PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
    
    $Id= $_POST['id'];
    $Nombre = $_POST['Nombre'];
    $Genero= $_POST['Genero'];
    $Artista= $_POST['Artista'];
    $Fecha= $_POST['Fecha'];
    $PDF= $_FILES['PDF'];
    
    $sql="UPDATE canciones SET nombre=:Nombre,genero_id=:Genero,artista=:Artista, fecha_estreno=:Fecha WHERE ID=:ID";
    
    
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':ID', $Id);
    $stmt->bindParam(':Nombre', $Nombre);
    $stmt->bindParam(':Genero', $Genero);
    $stmt->bindParam(':Artista', $Artista);
    $stmt->bindParam(':Fecha', $Fecha);
    
    $stmt->setFetchMode(PDO::FETCH_ASSOC);
    $stmt->execute();
    
    $automobiles=[];
    While($fila = $stmt->fetch()) {
    $objAuto= new stdClass();
    $objAuto->Id=$fila['ID'];
    $objAuto->Nombre=$fila['Nombre'];
    $objAuto->Genero=$fila['Genero'];
    $objAuto->Artista=$fila['Artista'];
    $objAuto->Fecha=$fila['Fecha'];
    array_push($canciones,$objAuto);
    }
    
    $objCanciones = new stdClass();
    $objCanciones->automobiles=$canciones;
    $salidaJson = json_encode($objCanciones);
    
    echo $salidaJson;
    
}


?>