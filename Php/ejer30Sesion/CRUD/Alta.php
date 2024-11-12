<?php
session_start();

// Validar si el formulario fue enviado correctamente
if (!isset($_POST['oculto'])) {
    exit("Error: El formulario no fue enviado correctamente.");
}

// Variable para mensajes de respuesta
$respuesta_estado = '';

function conectarDB()
{
    include('./db.php');
    try {
        $conn = new PDO("mysql:host=$host;dbname=$dbname", $user, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $conn;
    } catch (PDOException $e) {
        exit("Error al conectar con la base de datos: " . $e->getMessage());
    }
}

function guardarCancion($conn)
{
// Sanitizar datos del formulario
    $nombre = htmlspecialchars($_POST['Nombre'], ENT_QUOTES, 'UTF-8');
    $genero = filter_var($_POST['Genero'], FILTER_VALIDATE_INT);
    $artista = htmlspecialchars($_POST['Artista'], ENT_QUOTES, 'UTF-8');
    $fecha = htmlspecialchars($_POST['Fecha'], ENT_QUOTES, 'UTF-8');
    $contenidoPortada = null;

    // Procesar imagen de portada si fue cargada
    if (!empty($_FILES['Portada']['tmp_name'])) {
        $contenidoPortada = file_get_contents($_FILES['Portada']['tmp_name']);
    }

    // Validar que los campos no estén vacíos
    if (empty($nombre) || empty($genero) || empty($artista) || empty($fecha)) {
        return "Todos los campos son obligatorios.";
    }

    // Insertar en la base de datos
    try {
        $sql = 'INSERT INTO canciones (nombre, genero_id, artista, fecha_estreno, imagen_portada) VALUES (?, ?, ?, ?, ?)';
        $stmt = $conn->prepare($sql);
        $stmt->execute([$nombre, $genero, $artista, $fecha, $contenidoPortada]);
        return "Registro guardado correctamente.";
    } catch (PDOException $e) {
        return "Error al guardar el registro: " . $e->getMessage();
    }
}

// Conectar a la base de datos y guardar el registro
$conn = conectarDB();
$respuesta_estado = guardarCancion($conn);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Canción</title>
    <style>
        /* Estilos del modal */
        dialog {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 40%;
            max-width: 450px;
            background-color: #1C1C1C;
            border: none;
            border-radius: 8px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.3);
            padding: 20px;
            color: #E0E0E0;
            overflow: hidden;
        }
        form {
            display: flex;
            flex-direction: column;
            gap: 15px;
            align-items: center;
            width: 100%;
        }
        .form-group {
            width: 80%;
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        form input, form select, form button {
            background-color: #2C2C2C;
            color: #E0E0E0;
            border: 1px solid #333;
            padding: 10px;
            font-size: 1em;
            border-radius: 5px;
            width: 80%;
        }
        form label {
            font-size: 1em;
            color: #E0E0E0;
            text-align: left;
            margin-bottom: 5px;
        }
        form button {
            background-color: blue;
            color: #FFF;
            padding: 15px;
            cursor: pointer;
            transition: background-color 0.3s ease;
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
    <!-- Modal para el formulario -->
    <dialog id="modal">
        <button class="cerrarventana" onclick="document.getElementById('modal').close()">×</button>
        <form method="POST" enctype="multipart/form-data">
            <input type="hidden" name="oculto" value="1">
            
            <div class="form-group">
                <label for="Nombre">Nombre:</label>
                <input type="text" name="Nombre" id="Nombre" required>
            </div>
            
            <div class="form-group">
                <label for="Genero">Género:</label>
                <select name="Genero" id="Genero" required>
                    <option value="">Seleccione</option>
                    <option value="1">Rock</option>
                    <option value="2">Pop</option>
                    <option value="3">Jazz</option>
                </select>
            </div>
            
            <div class="form-group">
                <label for="Artista">Artista:</label>
                <input type="text" name="Artista" id="Artista" required>
            </div>
            
            <div class="form-group">
                <label for="Fecha">Fecha de Estreno:</label>
                <input type="date" name="Fecha" id="Fecha" required>
            </div>
            
            <div class="form-group">
                <label for="Portada">Portada:</label>
                <input type="file" name="Portada" id="Portada" accept="image/*">
            </div>
            
            <button type="submit">Guardar Canción</button>
        </form>
        <p><?= $respuesta_estado ?></p>
    </dialog>

    <script>
        // Mostrar el modal automáticamente si hay una respuesta
        const respuesta = "<?= $respuesta_estado ?>";
        if (respuesta) {
            const modal = document.getElementById('modal');
            modal.showModal();
        }
    </script>
</body>
</html>
