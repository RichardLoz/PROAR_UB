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
    <title>Nuevo Registro</title>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="./AltaForm.css">

</head>

<body>
    <!-- Título del formulario -->
    <h2 style="text-align:center; color: #E0E0E0; font-size: 1.5em;">Nueva Canción</h2>

    <form id="formDeAlta" method="post" enctype="multipart/form-data">
        <!-- Agrupamos cada label e input en un form-group para alinearlos bien -->
        <div class="form-group">
            <label for="Nombre">Nombre</label>
            <input type="text" id="Nombre" name="Nombre" required>
        </div>

        <div class="form-group">
            <label for="Genero">Género</label>
            <select name="Genero" id="GeneroFormAlta" required>
                <option value="">Selecciona</option>
            </select>
        </div>

        <div class="form-group">
            <label for="Artista">Artista</label>
            <input type="text" id="Artista" name="Artista" required>
        </div>

        <div class="form-group">
            <label for="Fecha">Fecha de Estreno</label>
            <input type="date" name="Fecha" id="Fecha" required>
        </div>

        <div class="form-group">
            <label for="Portada">Portada</label>
            <input type="file" id="PortadaForm" name="Portada" accept='.jpg,.png,.jpeg'>
        </div>
        <input type="hidden" id='oculto' name='oculto'>
        <button id="submits" type="submit" value="DarAlta">Enviar Formulario</button>
    </form>
</body>


<script>

    // Script para cargar los géneros desde desplegables.php
    $(document).ready(function () {
        $.ajax({
            url: './desplegables.php', // Se llama a este archivo para obtener los géneros
            type: 'GET',
            success: function (response) {
                var generos = response;
                generosJson = JSON.parse(generos);
                var select = $('#GeneroFormAlta');
                select.empty();
                select.append('<option value="">Selecciona</option>');
                generosJson.generos.forEach(function (item) {
                    select.append('<option value="' + item.id_genero + '">' + item.genero + '</option>');
                });
            }
        });
    });

    // Script para enviar el formulario de alta mediante AJAX
    $(document).ready(function () {
        $("#submits").click(function (e) {
            e.preventDefault(); // Prevenir el comportamiento por defecto del submit
            $("#oculto").val("1");
            var data = new FormData($("#formDeAlta")[0]);
            $.ajax({
                type: 'POST',
                enctype: 'multipart/form-data',
                url: "./Alta.php",
                processData: false,
                contentType: false,
                cache: false,
                data: data,
                success: function (respuestaDelServer, estado) {
                    console.log(respuestaDelServer); // Mensaje de éxito o error
                    console.log(estado);
                }
            });
        });
    });

</script>


</html>