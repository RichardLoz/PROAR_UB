<?php
echo "<html>
<head>
    <link rel='stylesheet' type='text/css' href='style.css'>
</head>
<body>
  <form action='respuesta.php' method='POST'>
    <label class='bold-text'>Nombre <input name ='nombre' type='text' required></label>
    <br><br>
    <label class='bold-text'>Apellido <input name ='apellido' type='text' required></label>
    <br><br>
    <button type='submit' class='button'>Enviar</button>
  </form>
</body>
</html>";
?>


