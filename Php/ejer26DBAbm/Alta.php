<?php
if(!isset($_POST['oculto'])){
    exit();
}
else{
    conect();
}

$respuesta_estado = ''; 

function conect (){
    include('./db.php');
try {
        $conn = new PDO("mysql:host=$host;dbname=$dbname", $user, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    }
    catch(PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
    $Nombre = $_POST['Nombre'];
    $Genero= $_POST['Genero'];
    $Artista= $_POST['Artista'];
    $Fecha= $_POST['Fecha'];
    $contenidoPdf = file_get_contents($_FILES['PDF']['tmp_name']); 

    $sql= ('INSERT INTO canciones(nombre,genero_id,artista,fecha_estreno,imagen_portada) VALUES(?,?,?,?,?)'); 
    $stmt = $conn->prepare($sql);

    $stmt->execute([$id,$Nombre,$Genero,$Artista,$Fecha,$contenidoPdf]);

    $conn = null;
}

