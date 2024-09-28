<?php
$nombre = $_POST["nombre"];
$apellido = $_POST["apellido"];
echo "<html>
<head>
    <link rel='stylesheet' type='text/css' href='style.css'>
</head>
<body>
  <div class='container'>
    <p class='bold-text'>Nombre: $nombre</p>
    <p class='bold-text'>Apellido: $apellido</p>
    <div class='button-container'>
      <form action='index.php'>
        <input type='submit' value='Volver' class='button'>
      </form>
    </div>
  </div>
</body>
</html>";
?>
