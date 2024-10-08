<?php
$Aencriptar = $_POST["clave"];

echo "Clave Ingresada: ". $Aencriptar . "<br><br>";

echo "Clave encriptada en md5 (128 bits o 16 pares hexadecimales)<br>";
echo md5($Aencriptar), "<br><br>";

echo "Clave encriptada en Sha1 (160 bits o 20 pares hexadecimales)<br>";
echo sha1($Aencriptar);

?>