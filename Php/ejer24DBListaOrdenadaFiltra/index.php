<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./style.css">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <title>ejer24DBListaOrdenadaFiltra_UB_MUSIC</title>
</head>

<body>
    <div class="head">
        <header>
            <h3>Canciones UB-MUSIC</h3>
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
    <footer><span id="totalRegistros"></span> Registros</footer>
</body>
<script>

$("#cargar").click(function () {
    // Imprimir el valor del género para depurar
    console.log("Genero seleccionado:", $("#filterGenero").val());
    cargaTabla();
});


    $(document).ready(function () {
        $("#order").val("");
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
                    select.append('<option value="' + item.id_genero + '">' + item.genero + '</option>');
                });
            }
        })
    });

    function cargaTabla() {
    $("#tbDatos").empty(); // Limpiar tabla
    $("#tbDatos").html("<p>Esperando respuesta... <span class='loader'></span></p>"); // Mostrar mensaje y loader
    
    $.ajax({
        type: "GET",
        url: "./cancionesJSONPrepare.php",
        data: {
            orden: $("#order").val(),
            filterID: $("#filterID").val(),
            filterNombre: $("#filterNombre").val(),
            filterGenero: $("#filterGenero").val(),
            filterArtista: $("#filterArtista").val(),
            filterFecha: $("#filterFecha").val()
        },
        success: function (respuestaDelServer) {
            $("#tbDatos").empty(); // Limpiar tabla una vez que se reciben los datos
            var tdatos = $("#tbDatos");
            console.log(respuestaDelServer);
            objJson = JSON.parse(respuestaDelServer);
            objJson.canciones.forEach(function (cancion) {
                var row = document.createElement("tr");
                row.innerHTML = `
                <td campo-dato='id'> ${cancion.Id} </td>
                <td campo-dato='nombre'> ${cancion.Nombre} </td>
                <td campo-dato='genero'> ${cancion.Genero} </td>
                <td campo-dato='artista'> ${cancion.Artista} </td>
                <td campo-dato='fecha_estreno'> ${cancion.Fecha} </td>`;
                $("#tbDatos").append(row);
            });
            $("#totalRegistros").html("Nro de registros: " + objJson.canciones.length);
        },
        error: function () {
            $("#tbDatos").empty(); // Limpiar la tabla si ocurre un error
            alert("Error al cargar los datos");
        }
    });
}


    $("#cargar").click(function () {
        cargaTabla()
    });

    $("#vaciar").click(function () {
    // Limpiar todos los inputs de texto
    $("#filterID").val('');
    $("#filterNombre").val('');
    $("#filterArtista").val('');
    $("#filterFecha").val('');

    // Dejar el select de género en la opción por defecto
    $("#filterGenero").val('');

    // Limpiar el input de orden
    $("#order").val('');

    // Limpiar la tabla de datos
    $("#tbDatos").empty();

    // Limpiar el número total de registros
    $("#totalRegistros").text('');
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
