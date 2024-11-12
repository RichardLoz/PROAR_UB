<?php
session_start();
include('./db.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['oculto'])) {
    try {
        $conn = new PDO("mysql:host=$host;dbname=$dbname", $user, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $nombre = htmlspecialchars($_POST['Nombre'], ENT_QUOTES, 'UTF-8');
        $genero = filter_var($_POST['Genero'], FILTER_VALIDATE_INT);
        $artista = htmlspecialchars($_POST['Artista'], ENT_QUOTES, 'UTF-8');
        $fecha = htmlspecialchars($_POST['Fecha'], ENT_QUOTES, 'UTF-8');
        $contenidoPortada = null;

        if (empty($nombre) || empty($genero) || empty($artista) || empty($fecha)) {
            echo "Error: Todos los campos son obligatorios.";
            exit;
        }

        if (!empty($_FILES['Portada']['tmp_name'])) {
            $contenidoPortada = file_get_contents($_FILES['Portada']['tmp_name']);
        }

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
    <title>Alta de Canción</title>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <style>
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
        .modalConfirm {
            display: none;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background-color: #2C2C2C;
            padding: 20px;
            border-radius: 8px;
            z-index: 1000;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.8);
        }
        .modalConfirm button {
            padding: 10px;
            margin: 10px;
            border-radius: 5px;
            cursor: pointer;
        }
        .modalConfirm button.confirm {
            background-color: #28a745;
            color: white;
        }
        .modalConfirm button.cancel {
            background-color: #dc3545;
            color: white;
        }
        #toast {
            position: fixed;
            bottom: 20px;
            right: 20px;
            background-color: rgba(0, 0, 0, 0.9);
            color: #FFF;
            padding: 15px 25px;
            border-radius: 8px;
            font-size: 1rem;
            z-index: 2000;
            display: none;
        }
    </style>
</head>
<body>
    <h2>Alta de Canción</h2>
    
    <form id="formDeAlta" method="post" enctype="multipart/form-data">
        <input type="hidden" id="oculto" name="oculto" value="1">
        <div><label>Nombre</label><input type="text" id="Nombre" name="Nombre" required></div>
        <div>
            <label>Género</label>
            <select id="GeneroFormAlta" name="Genero" required>
                <option value="">Selecciona un género</option>
            </select>
        </div>
        <div><label>Artista</label><input type="text" id="Artista" name="Artista" required></div>
        <div><label>Fecha</label><input type="date" id="Fecha" name="Fecha" required></div>
        <div><label>Portada</label><input type="file" id="Portada" name="Portada" accept=".jpg,.jpeg,.png"></div>
        <button type="button" id="showModal">Agregar Canción</button>
    </form>

    <div class="modalConfirm" id="modalConfirm">
        <p>¿Desea agregar la canción?</p>
        <button class="confirm" id="confirmAdd">CONFIRMAR</button>
        <button class="cancel" id="cancelAdd">CANCELAR</button>
    </div>

    <div id="toast"></div>

    <script>
        $(document).ready(function () {
            $('#showModal').click(function () {
                $('#modalConfirm').fadeIn();
            });

            $('#confirmAdd').click(async function () {
                const formData = new FormData($('#formDeAlta')[0]);
                const response = await $.ajax({
                    type: 'POST',
                    url: './AltaCancion.php',
                    data: formData,
                    processData: false,
                    contentType: false
                });

                if (response === "success") {
                    showToast("Canción agregada exitosamente");
                    $('#formDeAlta')[0].reset();
                    $('#modalConfirm').fadeOut();
                    parent.cerrarAlta();
                    parent.cargaTabla();
                } else {
                    showToast("Error al agregar la canción");
                }
            });

            $('#cancelAdd').click(function () {
                $('#modalConfirm').fadeOut();
                showToast("Acción cancelada");
            });

            function showToast(message) {
                const toast = $('#toast');
                toast.text(message).fadeIn();
                setTimeout(() => toast.fadeOut(), 3000);
            }

            $.get('./desplegables.php', function (response) {
                const generos = JSON.parse(response).generos;
                const select = $('#GeneroFormAlta');
                select.empty();
                select.append('<option value="">Selecciona un género</option>');
                generos.forEach(g => {
                    select.append(new Option(g.genero, g.id_genero));
                });
            });
        });
    </script>
</body>
</html>
