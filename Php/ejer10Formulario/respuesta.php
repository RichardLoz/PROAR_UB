<?php
$nombre = $_GET["nombre"];
$apellido = $_GET["apellido"];
echo "<html>
<head>
    <link rel='stylesheet' type='text/css' href='style.css'>
</head>
<body>
  <div class='container'>
    <p class='bold-text'>Nombre: $nombre</p>
    <p class='bold-text'>Apellido: $apellido</p>
    <div class='button-container'>
      <a href='ejer10Formulario.html' class='button'>Volver</a>
    </div>
  </div>
</body>
</html>";
?>
