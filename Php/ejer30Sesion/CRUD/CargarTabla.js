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
                        <td>${cancion.Nombre}</td>
                        <td>${cancion.Genero}</td>
                        <td>${cancion.Artista}</td>
                        <td>${cancion.Fecha}</td>
                        <td><img src="${imagenPortada}" alt="Portada" width="50" height="50"></td>
                        <td>
                            <button class="btnModificar" onclick="Modificar(${cancion.id})">Modificar</button>
                            <button class="btnEliminar" onclick="Borrar(${cancion.id})">Eliminar</button>
                        </td>
                    </tr>`;
                    $("#tbDatos").append(row);
                });
                $("#totalRegistros").html("Nro de registros: " + objJson.canciones.length);
            },
            error: function () {
                $("#tbDatos").empty();
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