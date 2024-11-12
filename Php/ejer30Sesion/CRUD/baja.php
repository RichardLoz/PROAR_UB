<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    include('db.php');

    try {
        $conn = new PDO("mysql:host=$host;dbname=$dbname", $user, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $Id = $_POST['id'];

        $sql = "DELETE FROM canciones WHERE ID = :ID";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':ID', $Id);
        $stmt->execute();

        echo "Registro eliminado exitosamente";
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
    <title>Eliminar Canción</title>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
</head>
<body>
    <script>
        function Borrar(id, nombre) {
            if (confirm(`¿Desea eliminar la canción con ID ${id}: ${nombre}?`)) {
                $.ajax({
                    url: 'Baja.php',
                    type: 'POST',
                    data: { id: id },
                    success: function (response) {
                        alert(response);
                    },
                    error: function () {
                        alert('Hubo un error al intentar eliminar el registro');
                    }
                });
            } else {
                alert('No se eliminó ningún registro');
            }
        }
    </script>
</body>
</html>
