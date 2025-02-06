<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nuevo Registro</title>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <style>
        /* Estilo del modal ajustado */
        dialog {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 40%; /* Ajustar el ancho del modal */
            max-width: 450px;
            background-color: #1C1C1C; /* Fondo oscuro */
            border: none;
            border-radius: 8px;
            box-shadow: 0px 4px 15px rgba(0, 0, 0, 0.3);
            padding: 20px;
            color: #E0E0E0; /* Texto claro */
            z-index: 1000;
            overflow: hidden;
        }

        /* Formulario con inputs y labels alineados en columna y centrados */
        form {
            display: flex;
            flex-direction: column;
            gap: 15px;
            align-items: center; /* Alineamos los campos al centro */
            width: 100%; /* Asegura que el formulario ocupe todo el espacio horizontal */
        }

        /* Agrupamos cada input y label en una form-group centrada */
        .form-group {
            width: 80%; /* Todos los inputs y labels ocupan solo el 80% del modal */
            display: flex;
            flex-direction: column;
            align-items: center; /* Alineamos cada grupo de inputs y labels al centro */
        }

        form input,
        form select,
        form button {
            background-color: #2C2C2C;
            color: #E0E0E0;
            border: 1px solid #333;
            padding: 10px;
            font-size: 1em;
            border-radius: 5px;
            width: 80%; /* Asegura que los inputs y selects ocupen todo el ancho del form-group */
        }

        form label {
            font-size: 1em;
            color: #E0E0E0;
            margin-bottom: 5px;
            display: block;
            width: 80%; /* El label también ocupará el ancho del form-group */
            text-align: left; /* Alineamos los labels a la izquierda */
        }

        form button {
            background-color: blue; /* Botón rojo llamativo */
            color: #FFF;
            border: none;
            padding: 15px;
            font-size: 1em;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
            width: 70%; /* El botón ocupa el mismo ancho que los inputs */
        }

        form button:hover {
            background-color: #FF5733;
        }

        dialog .cerrarventana {
            position: absolute;
            top: 10px;
            right: 15px;
            background: none;
            border: none;
            font-size: 1.5em;
            color: #E0E0E0;
            cursor: pointer;
        }
    </style>
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
            <input type="file" id="PortadaForm" name="Portada" accept=".jpg,.png,.jpeg">
        </div>

        <button id="submits" type="submit" value="DarAlta">Enviar Formulario</button>
    </form>

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
</body>
</html>
