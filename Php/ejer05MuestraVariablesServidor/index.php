
<?php
echo "<html><head><title>Mostrar variables de Servidor</title></head><body>";

echo "<h1>Variables de Servidor</h1>";
echo "<table border='1'>";
echo "<tr><th>Variable</th><th>Valor</th></tr>";

echo "<tr><td>SERVER_ADDR</td><td>".$_SERVER['SERVER_ADDR']."</td></tr>";
echo "<tr><td>SERVER_PORT</td><td>".$_SERVER['SERVER_PORT']."</td></tr>";
echo "<tr><td>DOCUMENT_ROOT</td><td>".$_SERVER['DOCUMENT_ROOT']."</td></tr>";
echo "<tr><td>SERVER_NAME</td><td>".$_SERVER['SERVER_NAME']."</td></tr>";

echo "</table>";

echo "<h1>Variables de Cliente</h1>";
echo "<table border='1'>";
echo "<tr><th>Variable</th><th>Valor</th></tr>";

echo "<tr><td>REMOTE_ADDR</td><td>".$_SERVER['REMOTE_ADDR']."</td></tr>";
echo "<tr><td>REMOTE_PORT</td><td>".$_SERVER['REMOTE_PORT']."</td></tr>";

echo "</table>";

echo "<h1>Variables de Requerimiento</h1>";
echo "<table border='1'>";
echo "<tr><th>Variable</th><th>Valor</th></tr>";

echo "<tr><td>SCRIPT_NAME</td><td>".$_SERVER['SCRIPT_NAME']."</td></tr>";
echo "<tr><td>REQUEST_METHOD</td><td>".$_SERVER['REQUEST_METHOD']."</td></tr>";

echo "</table>";

echo "</body></html>";
?>
