<?php
session_start();
include('./db.php');

// Obtener datos de la canción para la modificación
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id'])) {
    try {
        $conn = new PDO("mysql:host=$host;dbname=$dbname", $user, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $Id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);
        $sqlSelect = "SELECT ID AS Id, nombre AS Nombre, genero_id AS Genero, artista AS Artista, fecha_estreno AS Fecha FROM canciones WHERE ID = :ID";
        $stmtSelect = $conn->prepare($sqlSelect);
        $stmtSelect->bindParam(':ID', $Id, PDO::PARAM_INT);
        $stmtSelect->execute();
        $fila = $stmtSelect->fetch(PDO::FETCH_ASSOC);

        if ($fila) {
            echo json_encode($fila);
        } else {
            echo json_encode(["error" => "No se encontraron datos para el ID especificado."]);
        }
    } catch (PDOException $e) {
        echo json_encode(["error" => "Error de conexión: " . $e->getMessage()]);
    }
    exit();
}

// Procesar la modificación de la canción
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['oculto'])) {
    try {
        $conn = new PDO("mysql:host=$host;dbname=$dbname", $user, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $Id = filter_var($_POST['id'], FILTER_SANITIZE_NUMBER_INT);
        $nombre = htmlspecialchars($_POST['Nombre'], ENT_QUOTES, 'UTF-8');
        $genero = filter_var($_POST['Genero'], FILTER_SANITIZE_NUMBER_INT);
        $artista = htmlspecialchars($_POST['Artista'], ENT_QUOTES, 'UTF-8');
        $fecha = htmlspecialchars($_POST['Fecha'], ENT_QUOTES, 'UTF-8');
        $contenidoPortada = null;

        if (!empty($_FILES['Portada']['tmp_name'])) {
            $contenidoPortada = file_get_contents($_FILES['Portada']['tmp_name']);
        }

        $sqlUpdate = "UPDATE canciones SET nombre = ?, genero_id = ?, artista = ?, fecha_estreno = ?, imagen_portada = ? WHERE ID = ?";
        $stmtUpdate = $conn->prepare($sqlUpdate);
        $stmtUpdate->execute([$nombre, $genero, $artista, $fecha, $contenidoPortada, $Id]);

        echo "Canción modificada exitosamente.";
    } catch (PDOException $e) {
        echo "Error al modificar la canción: " . $e->getMessage();
    }
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modificar Canción</title>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <style>
        body {
            background-color: #434141;
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .modalModi {
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
        label {
            color: white;
        }
        input, select, button {
            width: 100%;
            padding: 10px;
            border-radius: 5px;
            background-color: #444;
            color: white;
        }
        button {
            background-color: #0056b3;
            cursor: pointer;
        }
        button:hover {
            background-color: #003d80;
        }
        .cerrar {
            background-color: red;
            color: white;
            cursor: pointer;
            padding: 5px 10px;
        }
    </style>
</head>
<body>
    <dialog class="modalModi" id="modalModi">
        <form id="formDeModi" method="post" enctype="multipart/form-data">
            <input type="hidden" id="oculto" name="oculto" value="1">
            <input type="hidden" id="id" name="id">

            <div>
                <label>Nombre</label>
                <input type="text" id="Nombre" name="Nombre" required>
            </div>
            <div>
                <label>Género</label>
                <select name="Genero" id="GeneroFormModi" required></select>
            </div>
            <div>
                <label>Artista</label>
                <input type="text" id="Artista" name="Artista" required>
            </div>
            <div>
                <label>Fecha de Estreno</label>
                <input type="date" name="Fecha" id="Fecha" required>
            </div>
            <button type="submit">Modificar Canción</button>
        </form>
        <button class="cerrar" onclick="cerrarModi()">Cerrar</button>
    </dialog>

    <script>
        async function Modificar(id) {
            const ModalModi = document.querySelector(".modalModi");

            try {
                const response = await $.ajax({ url: './ModificarCancion.php', type: 'GET', data: { id } });
                const objJson = JSON.parse(response);

                $("#id").val(objJson.Id);
                $("#Nombre").val(objJson.Nombre);
                $("#Artista").val(objJson.Artista);
                $("#Fecha").val(objJson.Fecha);

                const res = await $.ajax({ url: './desplegables.php', type: 'GET' });
                const generos = JSON.parse(res).generos;
                const selectGenero = $("#GeneroFormModi");
                selectGenero.empty();
                generos.forEach(item => {
                    const option = new Option(item.genero, item.id_genero);
                    if (item.id_genero == objJson.Genero) option.selected = true;
                    selectGenero.append(option);
                });

                if (ModalModi) {
                    ModalModi.showModal();
                    $("body").css("opacity", "0.3");
                }
            } catch (error) {
                console.error("Error en la solicitud:", error);
                alert("Error al cargar los datos.");
            }
        }

        function cerrarModi() {
            const ModalModi = document.querySelector(".modalModi");
            if (ModalModi) {
                ModalModi.close();
                $("body").css("opacity", "1");
            }
        }

        $("#formDeModi").on('submit', async function (e) {
            e.preventDefault();

            const nombre = $("#Nombre").val().trim();
            const genero = $("#GeneroFormModi").val();
            const artista = $("#Artista").val().trim();
            const fecha = $("#Fecha").val();

            if (!nombre || !genero || !artista || !fecha) {
                alert("Por favor, completa todos los campos.");
                return;
            }

            try {
                const data = new FormData(this);
                const response = await $.ajax({
                    url: './ModificarCancion.php',
                    type: 'POST',
                    data: data,
                    processData: false,
                    contentType: false
                });
                alert(response);
                cerrarModi();
            } catch (error) {
                alert("Error al modificar la canción.");
            }
        });
    </script>
</body>
</html>
