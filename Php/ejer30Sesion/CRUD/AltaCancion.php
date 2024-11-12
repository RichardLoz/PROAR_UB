<?php
session_start();
include('./db.php');

// Procesar la inserción de la canción si se envía el formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['oculto'])) {
    try {
        $conn = new PDO("mysql:host=$host;dbname=$dbname", $user, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Sanitizar y validar entradas
        $nombre = htmlspecialchars($_POST['Nombre'], ENT_QUOTES, 'UTF-8');
        $genero = filter_var($_POST['Genero'], FILTER_VALIDATE_INT);
        $artista = htmlspecialchars($_POST['Artista'], ENT_QUOTES, 'UTF-8');
        $fecha = htmlspecialchars($_POST['Fecha'], ENT_QUOTES, 'UTF-8');
        $contenidoPortada = null;

        // Validar campos obligatorios
        if (empty($nombre) || empty($genero) || empty($artista) || empty($fecha)) {
            echo "Error: Todos los campos son obligatorios.";
            exit;
        }

        // Procesar imagen si se ha subido
        if (!empty($_FILES['Portada']['tmp_name'])) {
            $contenidoPortada = file_get_contents($_FILES['Portada']['tmp_name']);
        }

        // Insertar en la base de datos
        $sql = 'INSERT INTO canciones (nombre, genero_id, artista, fecha_estreno, imagen_portada) VALUES (?, ?, ?, ?, ?)';
        $stmt = $conn->prepare($sql);
        $stmt->execute([$nombre, $genero, $artista, $fecha, $contenidoPortada]);

        echo "success";
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nueva Canción</title>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <style>
        /* Estilos para el formulario y los modales */
        body {
            background-color: #1C1C1C;
            color: #E0E0E0;
            font-family: Arial, sans-serif;
        }
        form {
            background-color: #2C2C2C;
            padding: 20px;
            border-radius: 8px;
            width: 400px;
            margin: 20px auto;
            display: flex;
            flex-direction: column;
            gap: 15px;
        }
        input, select, button {
            padding: 10px;
            border-radius: 5px;
        }
        #toast {
            position: fixed;
            bottom: 20px;
            right: 20px;
            background-color: #333;
            color: white;
            padding: 10px 20px;
            border-radius: 5px;
            display: none;
        }
        #modalConfirm {
            display: none;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background-color: #2C2C2C;
            padding: 20px;
            border-radius: 8px;
            z-index: 1000;
        }
    </style>
</head>
<body>
    <h2>Nueva Canción</h2>
    
    <!-- Formulario de Alta -->
    <form id="formDeAlta" method="post" enctype="multipart/form-data">
        <input type="hidden" id="oculto" name="oculto" value="1">
        <div>
            <label>Nombre</label>
            <input type="text" id="Nombre" name="Nombre" required>
        </div>
        <div>
            <label>Género</label>
            <select id="GeneroFormAlta" name="Genero" required></select>
        </div>
        <div>
            <label>Artista</label>
            <input type="text" id="Artista" name="Artista" required>
        </div>
        <div>
            <label>Fecha de Estreno</label>
            <input type="date" id="Fecha" name="Fecha" required>
        </div>
        <div>
            <label>Portada</label>
            <input type="file" id="Portada" name="Portada" accept=".jpg,.jpeg,.png">
        </div>
        <button type="button" id="showModal">Agregar Canción</button>
    </form>

    <!-- Modal de confirmación -->
    <div id="modalConfirm">
        <p>¿Desea agregar la canción?</p>
        <button id="confirmAdd">CONFIRMAR</button>
        <button id="cancelAdd">CANCELAR</button>
    </div>

    <!-- Notificación estilo "toast" -->
    <div id="toast"></div>

    <script>
        $(document).ready(function () {
            // Cargar géneros dinámicamente
            $.get('./desplegables.php', function (response) {
                const generos = JSON.parse(response).generos;
                const select = $('#GeneroFormAlta');
                generos.forEach(g => select.append(new Option(g.genero, g.id_genero)));
            });

            // Mostrar modal de confirmación
            $('#showModal').click(function () {
                $('#modalConfirm').show();
            });

            // Confirmar la inserción
            $('#confirmAdd').click(async function () {
                const formData = new FormData($('#formDeAlta')[0]);
                const response = await $.post({
                    url: './AltaCancion.php',
                    data: formData,
                    processData: false,
                    contentType: false
                });

                if (response === "success") {
                    showToast("Canción agregada exitosamente");
                    $('#formDeAlta')[0].reset();
                } else {
                    showToast("Error al agregar la canción");
                }
                $('#modalConfirm').hide();
            });

            // Cancelar la inserción
            $('#cancelAdd').click(function () {
                $('#modalConfirm').hide();
                showToast("Acción cancelada");
            });

            // Función para mostrar notificaciones tipo "toast"
            function showToast(message) {
                const toast = $('#toast');
                toast.text(message).fadeIn();
                setTimeout(() => toast.fadeOut(), 3000);
            }
        });
    </script>
</body>
</html>
