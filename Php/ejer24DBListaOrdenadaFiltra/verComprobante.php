<?php
// Entrega el binario (pdf o imagen) guardado en pdf_comprobante para un renglón.
// Lo abre el link "Ver" de index.php: verComprobante.php?id=3
include ("./db.php"); // trae $host, $dbname, $user, $password

$id = (int) ($_GET['id'] ?? 0);

try {
    $dbh = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $user, $password);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $stmt = $dbh->prepare("SELECT pdf_comprobante FROM renglones_orden_compra WHERE id = :id");
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    $contenido = $stmt->fetchColumn();
    $dbh = null;

    if ($contenido === false || $contenido === null || $contenido === '') {
        http_response_code(404);
        echo "Sin comprobante";
        exit;
    }

    // Detectar el tipo (application/pdf, image/jpeg, ...) mirando el contenido del binario
    $finfo = new finfo(FILEINFO_MIME_TYPE);
    header("Content-Type: " . $finfo->buffer($contenido));
    echo $contenido;
} catch (PDOException $e) {
    http_response_code(500);
    echo "Error: " . $e->getMessage();
}
?>
