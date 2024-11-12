$("#cargar").click(function () {
    console.log("Genero seleccionado:", $("#filterGenero").val());
    cargaTabla();
});

$(document).ready(function () {
    $("#order").val("");
    $.ajax({
        url: './desplegables.php',
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
    });
});

function cargaTabla() {
    $("#tbDatos").empty();
    $("#tbDatos").html("<p>Esperando respuesta... <span class='loader'></span></p>");

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
            $("#tbDatos").empty();
            const objJson = JSON.parse(respuestaDelServer);

            objJson.canciones.forEach(function (cancion) {
                const imagenPortada = cancion.imagen_portada ? `data:image/jpeg;base64,${cancion.imagen_portada}` : './img_no.jpeg';
                const row = `
                <tr>
                    <td>${cancion.Id}</td>
                    <td>${cancion.nombre}</td>
                    <td>${cancion.genero}</td>
                    <td>${cancion.artista}</td>
                    <td>${cancion.fecha_estreno}</td>
                    <td><img src="${imagenPortada}" alt="Portada" width="50"></td>
                    <td>
                        <button class="btnModificar" onclick="Modificar(${cancion.ID})">Modificar</button>
                        <button class="btnEliminar" onclick="Borrar(${cancion.ID}, '${cancion.nombre}')">Eliminar</button>
                    </td>
                </tr>`;
                $("#tbDatos").append(row);
            });
            $("#totalRegistros").html(`Nro de registros: ${objJson.canciones.length}`);
        },
        error: function () {
            $("#tbDatos").empty();
            alert("Error al cargar los datos");
        }
    });
}

// Evento para cargar la tabla al hacer clic en el botón "Cargar Datos"
$("#cargar").click(function () {
    cargaTabla();
});

// Limpiar filtros y tabla
$("#vaciar").click(function () {
    $("#filterID").val('');
    $("#filterNombre").val('');
    $("#filterArtista").val('');
    $("#filterFecha").val('');
    $("#filterGenero").val('');
    $("#order").val('');
    $("#tbDatos").empty();
    $("#totalRegistros").text('');
});

// Ordenar por columnas al hacer clic en los botones de encabezado
$(document).ready(function () {
    $("#btnID").click(function () { $("#order").val("ID"); cargaTabla(); });
    $("#btnNombre").click(function () { $("#order").val("nombre"); cargaTabla(); });
    $("#btnGenero").click(function () { $("#order").val("genero_id"); cargaTabla(); });
    $("#btnArtista").click(function () { $("#order").val("artista"); cargaTabla(); });
    $("#btnFecha").click(function () { $("#order").val("fecha_estreno"); cargaTabla(); });
});
