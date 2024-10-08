<?php
sleep(2);

$Apellido = $_POST["apellido"];
$name = $_POST['nombre'];
$edad = $_POST['edad'];
$date = $_POST['fecha_siniestro'];
$seguro = $_POST['seguro'];

$NuevoUser = new stdClass;
$NuevoUser->Nombre = $name;
$NuevoUser->Apellido = $Apellido;
$NuevoUser->Edad = $edad;
$NuevoUser->Seguro = $seguro;
$NuevoUser->FechaSiniestro = $date;
$nuevouserJSON = json_encode($NuevoUser);
echo $nuevouserJSON;
?>
