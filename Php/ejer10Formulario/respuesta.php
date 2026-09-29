<?php
$nombre = $_GET["nombre"];
$apellido = $_GET["apellido"];
echo "<html>
<head>
    <link rel='stylesheet' type='text/css' href='style.css'>
</head>
<body>
  <div class='container'>
    <h2 class='form-title'>Datos recibidos</h2>
    <dl class='result-list'>
      <div class='result-row'>
        <dt class='result-label'>Nombre</dt>
        <dd class='result-value'>$nombre</dd>
      </div>
      <div class='result-row'>
        <dt class='result-label'>Apellido</dt>
        <dd class='result-value'>$apellido</dd>
      </div>
    </dl>
    <div class='button-container'>
      <a href='ejer10Formulario.html' class='button'>Volver.</a>
    </div>
  </div>
</body>
</html>";
?>
