<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./style.css">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <title>ejer24DBListaOrdenadaFiltra</title>
</head>

<body>
    <div class="head">
        <header>
            <h3>Canciones</h3>
        </header>
        <div class="command">
            <p>Orden</p>
            <input type="text" id="order"></input>
            <button id="cargar">Cargar Datos</button>
            <button id="vaciar">Vaciar Datos</button>
        </div>
    </div>
    <table style="width: 100%;">
        <thead>
            <tr>
                <th campo-dato='id'><button id="btnID">Id</button></th>
                <th campo-dato='nombre'><button id="btnNombre">Nombre</button></th>
                <th campo-dato='genero_id'><button id="btnGenero">Género</button></th>
                <th campo-dato='artista'><button id="btnArtista">Artista</button></th>
                <th campo-dato='fecha_estreno'><button id="btnFecha">Fecha de Estreno</button></th>
            </tr>
            <tr id="FiltrosTR">
                <td><input type="text" id="filterID"></td>
                <td><input type="text" id="filterNombre"></td>
                <td><select name="selection" id="filterGenero">
                        <option value=""></option>
                    </select></td>
                <td><input type="text" id="filterArtista"></td>
                <td><input type="date" id="filterFecha"></td>
            </tr>
        </thead>
        <tbody id="tbDatos"></tbody>
        <tfoot>
            <th campo-dato='id'>TId</th>
            <th campo-dato='nombre'>TNombre</th>
            <th campo-dato='genero_id'>TGénero</th>
            <th campo-dato='artista'>TArtista</th>
            <th campo-dato='fecha_estreno'>TFecha de Estreno</th>
        </tfoot>
    </table>
    <footer><span id="totalRegistros"></span>Footer</footer>
</body>
<script>

    $(document).ready(function () {
        $("#order").val("ID");
        $.ajax({
            url: './desplegables.php', // Aquí se obtienen los géneros
            type: 'GET',
            success: function (response) {
                var generos = response;
                generosJson = JSON.parse(generos);
                console.log(generosJson);
                var select = $('#filterGenero');
                select.empty();
                select.append('<option value="">Selecciona</option>');
                generosJson.generos.forEach(function (item) {
                    select.append('<option value="' + item.genero_id + '">' + item.nombre + '</option>');
                });
            }
        })
    });

    function cargaTabla() {
        $("#tbDatos").empty();
        $("#tbDatos").html("<p>Esperando respuesta ...</p>");
        var objAjax = $.ajax({
            type: "GET",
            url: "./cancionesJSONPrepare.php", // Cambia el archivo que prepara la respuesta JSON
            data: {
                orden: $("#order").val(),
                filterID: $("#filterID").val(),
                filterNombre: $("#filterNombre").val(),
                filterGenero: $("#filterGenero").val(),
                filterArtista: $("#filterArtista").val(),
                filterFecha: $("#filterFecha").val()
            },
            success: function (respuestaDelServer) {
                $("#tbDatos").empty();
                var tdatos = $("#tbDatos");
                console.log(respuestaDelServer);
                objJson = JSON.parse(respuestaDelServer);
                objJson.canciones.forEach(function (cancion) {
                    var row = document.createElement("tr");
                    row.innerHTML = `
                    <td campo-dato='id'> ${cancion.ID} </td>
                    <td campo-dato='nombre'> ${cancion.nombre} </td>
                    <td campo-dato='genero_id'> ${cancion.genero_nombre} </td>
                    <td campo-dato='artista'> ${cancion.artista} </td>
                    <td campo-dato='fecha_estreno'> ${cancion.fecha_estreno} </td>`;
                    $("#tbDatos").append(row);
                });
                $("#totalRegistros").html("Nro de registros: " + objJson.canciones.length);
            }
        });
    }

    $("#cargar").click(function () {
        cargaTabla()
    });

    $("#vaciar").click(function () {
        $("#tbDatos").empty();
    });
    
    $(document).ready(function () {
        $("#btnID").click(function () {
            $("#order").val("ID");
        });
        $("#btnNombre").click(function () {
            $("#order").val("nombre");
        });
        $("#btnGenero").click(function () {
            $("#order").val("genero_id");
        });
        $("#btnArtista").click(function () {
            $("#order").val("artista");
        });
        $("#btnFecha").click(function () {
            $("#order").val("fecha_estreno");
        });
    });
    
</script>

</html>
