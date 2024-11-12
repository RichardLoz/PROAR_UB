<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['oculto'])) {
    include('./db.php');

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

        // Procesar imagen de portada si se ha subido
        if (!empty($_FILES['Portada']['tmp_name'])) {
            $contenidoPortada = file_get_contents($_FILES['Portada']['tmp_name']);
        }

        // Insertar en la base de datos
        $sql = 'INSERT INTO canciones (nombre, genero_id, artista, fecha_estreno, imagen_portada) VALUES (?, ?, ?, ?, ?)';
        $stmt = $conn->prepare($sql);
        $stmt->execute([$nombre, $genero, $artista, $fecha, $contenidoPortada]);
        echo "Registro guardado correctamente.";
    } catch (PDOException $e) {
        echo "Error al guardar el registro: " . $e->getMessage();
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
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <style>
        /* Estilos para el formulario */
        body {
            background-color: #1C1C1C;
            color: #E0E0E0;
            font-family: Arial, sans-serif;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100vh;
            margin: 0;
        }
        h2 {
            text-align: center;
            margin-bottom: 20px;
        }
        form {
            background-color: #2C2C2C;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.3);
            width: 400px;
            display: flex;
            flex-direction: column;
            gap: 15px;
        }
        .form-group {
            display: flex;
            flex-direction: column;
        }
        form input, form select, form button {
            background-color: #333;
            color: #E0E0E0;
            border: 1px solid #444;
            padding: 10px;
            border-radius: 5px;
        }
        form label {
            margin-bottom: 5px;
        }
        form button {
            background-color: blue;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        form button:hover {
            background-color: #FF5733;
        }
    </style>
</head>

<body>
    <!-- Título del formulario -->
    <h2>Nueva Canción</h2>
    
    <form id="formDeAlta" method="post" enctype="multipart/form-data">
        <input type="hidden" id="oculto" name="oculto" value="1">

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
            <input type="file" id="PortadaForm" name="Portada" accept=".jpg,.jpeg,.png">
        </div>

        <button type="submit" id="submits">Enviar Formulario</button>
    </form>

    <script>
        $(document).ready(function () {
            // Cargar géneros desde desplegables.php
            $.ajax({
                url: './desplegables.php',
                type: 'GET',
                success: function (response) {
                    let generosJson = JSON.parse(response);
                    let select = $('#GeneroFormAlta');
                    select.empty();
                    select.append('<option value="">Selecciona</option>');
                    generosJson.generos.forEach(function (item) {
                        select.append('<option value="' + item.id_genero + '">' + item.genero + '</option>');
                    });
                }
            });

            // Enviar formulario mediante AJAX
            $("#formDeAlta").on('submit', function (e) {
                e.preventDefault();
                let data = new FormData(this);
                $.ajax({
                    type: 'POST',
                    url: './AltaForm.php',
                    data: data,
                    processData: false,
                    contentType: false,
                    success: function (respuesta) {
                        alert(respuesta);
                        $('#formDeAlta')[0].reset();
                    },
                    error: function () {
                        alert("Error al enviar el formulario.");
                    }
                });
            });
        });
    </script>
</body>

</html>
