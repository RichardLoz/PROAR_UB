<?php
session_start(); // Iniciar sesión

// Verificar si la sesión está activa
if (!isset($_SESSION['usuario'])) {
    // Si no hay sesión, redirigir a la página de error
    header('Location: ../no_session.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modificar Canción</title>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
            integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
</head>
<body>
    <form id="formDeModi" method="post" enctype="multipart/form-data">
        <div>
            <label>Nombre</label>
            <input type="text" id="Nombre" name="Nombre" required><br>
        </div>
        <div>
            <label>Género</label>
            <select name="Genero" id="GeneroFormModi" required>
                <option value="">Selecciona</option>
            </select><br>
        </div>
        <div>
            <label>Artista</label>
            <input type="text" id="Artista" name="Artista" required><br>
        </div>
        <div>
            <label>Fecha de Estreno</label>
            <input type="date" name="Fecha" id="Fecha" required><br>
        </div>
        <div>
            <label>Portada</label>
            <input type="file" id="PortadaForm" name="Portada" accept=".jpg, .jpeg, .png"/><br>
        </div>
        <input type="hidden" id="oculto" name="oculto">
        <button id="submits" type="submit" value="Modificar">Modificar Canción</button>
    </form>
</body>

<style>
    body {
        background-color: rgb(67, 65, 65);
        font-family: 'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif;
        font-size: 20px;
    }
    button {
        padding: 20px;
        font-size: 20px;
        background-color: rgb(32, 38, 38);
        color: white;
    }
    form {
        display: block;
        align-content: center;
    }
</style>

<script src="Modificar.js"></script>
<script>
    $(document).ready(function () {
        // Cargar géneros en el select
        $.ajax({
            url: './desplegables.php',
            type: 'GET',
            success: function (response) {
                const generosJson = JSON.parse(response);
                const selectGenero = $('#GeneroFormModi');
                selectGenero.empty();
                selectGenero.append('<option value="">Selecciona</option>');
                generosJson.generos.forEach(function (item) {
                    selectGenero.append('<option value="' + item.id_genero + '">' + item.genero + '</option>');
                });
            }
        });

        // Enviar el formulario de modificación
        $("#submits").click(function (e) {
            e.preventDefault();
            const data = new FormData($("#formDeModi")[0]);
            $.ajax({
                type: 'POST',
                enctype: 'multipart/form-data',
                url: "./Modi.php",
                processData: false,
                contentType: false,
                cache: false,
                data: data,
                success: function (respuestaDelServer) {
                    console.log("Respuesta del servidor:", respuestaDelServer);
                    alert("Canción modificada exitosamente.");
                },
                error: function () {
                    alert("Error al modificar la canción.");
                }
            });
        });
    });
</script>
</html>
