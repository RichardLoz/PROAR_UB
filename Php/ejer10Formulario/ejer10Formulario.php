<?php
echo "<html>
<head>
    <link rel='stylesheet' type='text/css' href='style.css'>
</head>
<body>
    <div class='container'>
        <h2 class='form-title'>Formulario de Registro</h2>
        <form action='respuesta_2.php' method='POST'>
            <div class='form-group'>
                <label class='bold-text'>Nombre</label>
                <input name ='nombre' type='text' required>
            </div>
            <div class='form-group'>
                <label class='bold-text'>Apellido</label>
                <input name ='apellido' type='text' required>
            </div>
            <div class='button-container'>
                <button type='submit' class='button'>Enviar</button>
            </div>
        </form>
    </div>
</body>
</html>";
?>


