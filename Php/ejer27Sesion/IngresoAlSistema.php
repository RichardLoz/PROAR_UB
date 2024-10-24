<?php
include('./db.php');

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $user, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

} catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
}
$log = $_POST['usuario'];
$cl= $_POST['pass'];
$encriptada = sha1($cl);
$stmt = $conn->prepare("SELECT * FROM usuarios WHERE login = :usuario");
$stmt->bindParam(':usuario', $log);
$stmt->execute();
$usuario_bd = $stmt->fetch(PDO::FETCH_ASSOC);
if ($usuario_bd) {
    if (hash_equals($usuario_bd['password'], $encriptada)) {
        session_start();
        $_SESSION['usuario'] = $usuario_bd['login'];
        $stmt2 = $conn->prepare("SELECT contador FROM usuarios WHERE login= :usuario");
        $stmt2->bindParam(':usuario', $log);
        $stmt2->execute();
        $usuarioContador = $stmt2->fetch(PDO::FETCH_ASSOC);
        $contadorActual = $usuarioContador['contador'];
        $SumarContador = $contadorActual + 1;
        $stmt3 =$conn->prepare( "UPDATE usuarios SET contador = $SumarContador WHERE login = :usuario");
        $stmt3->bindParam(':usuario', $log);
        $stmt3->execute();
        header('Location: ./DataIngreso.php?contador='.$SumarContador.'');
        
    } else {
        echo "Contraseña incorrecta";

    }
} else {
    
    echo 'Usuario no encontrado';
    
}
?>
<html>
    <Button><a href="./FormLogin.php">Volver</a></Button>
</html>

