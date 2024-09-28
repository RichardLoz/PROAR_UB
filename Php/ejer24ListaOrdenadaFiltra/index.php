<?php
echo "<html>
<head>
    <link rel='stylesheet' type='text/css' href='style.css'>
</head>
<body>

<header>
    <div class='header-content'>
        <h1>Formulario y Tabla</h1>
        <div class='input-button-container'>
            <label for='inputOrden'>Orden: </label>
            <input type='text' id='inputTitulo' name='titulo'>
            <button>Cargar Datos</button>
            <button>Vaciar Datos</button>
        </div>
    </div>
</header>

<div class='table-container'>
    <table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Descripcion</th>
            <th>Plataforma</th>
            <th>Fecha Estreno</th>
            <th>Presupuesto</th>
            <th>Imagen Portada</th>
        </tr>
        <tr>
            <td><input type='text' id='inputID' name='id'></td>
            <td><input type='text' id='inputNombre' name='nombre'></td>
            <td><input type='text' id='inputDescripcion' name='descripcion'></td>
            <td><input type='text' id='inputPlataforma' name='plataforma'></td>
            <td><input type='text' id='inputFechaEstreno' name='fecha_estreno'></td>
            <td><input type='text' id='inputPresupuesto' name='presupuesto'></td>
            <td><input type='text' id='inputImagen' name='imagen'></td>
        </tr>
    </thead>
    <tfoot>
        <tr>
            <td>T ID</td>
            <td>T Nombre</td>
            <td>T Descripcion</td>
            <td>T Plataforma</td>
            <td>T Fecha Estreno</td>
            <td>T Presupuesto</td>
            <td>T Imagen</td>
        </tr>
    </tfoot>
    </table>
</div>
<footer>
<p>Nro de registros: </p>
</footer>
</body>
</html>";
?>