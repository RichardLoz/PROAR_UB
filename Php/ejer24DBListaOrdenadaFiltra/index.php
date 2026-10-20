<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./style.css">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <title>ejer24DBListaOrdenadaFiltra_Renglones_OC</title>
</head>

<body>
    <!-- Encabezado: título y controles (campo de orden y botones) -->
    <div class="head">
        <header>
            <h3>Renglones de órdenes de compra</h3>
        </header>
        <div class="command">
            <!-- Acá se escribe (o se completa con los botones de columna) el campo por el que se ordena -->
            <p>Orden</p>
            <input type="text" id="order">
            <button id="cargar">Cargar Datos</button>
            <button id="vaciar">Vaciar Datos</button>
        </div>
    </div>
    <table style="width: 100%;">
        <thead>
            <!-- Fila de títulos: cada botón carga su columna en el campo "Orden" -->
            <tr>
                <th campo-dato='nro_orden'><button id="btnNroOrden">Nro. de Orden</button></th>
                <th campo-dato='codigo_producto'><button id="btnCodigo">Código Producto</button></th>
                <th campo-dato='descripcion'><button id="btnDescripcion">Descripción</button></th>
                <th campo-dato='cantidad'><button id="btnCantidad">Cantidad</button></th>
                <th campo-dato='cod_unidad'><button id="btnUnidad">Unidad de Medida</button></th>
                <th campo-dato='precio_unitario'><button id="btnPrecio">Precio Unitario</button></th>
                <th campo-dato='importe_renglon'><button id="btnImporte">Importe Renglón</button></th>
                <th campo-dato='fecha_orden'><button id="btnFecha">Fecha</button></th>
                <th>Comprobante</th>
            </tr>
            <!-- Fila de filtros: texto para nro/código/descripción y desplegable para unidad -->
            <tr id="FiltrosTR">
                <td><input type="text" id="filterNroOrden"></td>
                <td><input type="text" id="filterCodigo"></td>
                <td><input type="text" id="filterDescripcion"></td>
                <td></td>
                <td><select name="selection" id="filterUnidad">
                        <option value=""></option>
                    </select></td>
                <td></td>
                <td></td>
                <td><input type="text" id="filterFecha" placeholder="AAAA-MM-DD"></td>
                <td></td>
            </tr>
        </thead>
        <!-- Acá el JS inserta las filas que llegan del servidor -->
        <tbody id="tbDatos"></tbody>
        <tfoot>
            <th>Nro. de Orden</th>
            <th>Código Producto</th>
            <th>Descripción</th>
            <th>Cantidad</th>
            <th>Unidad de Medida</th>
            <th>Precio Unitario</th>
            <th>Importe Renglón</th>
            <th>Fecha</th>
            <th>Comprobante</th>
        </tfoot>
    </table>
    <!-- Pie: cantidad de registros mostrados -->
    <footer><span id="totalRegistros"></span> Registros</footer>
</body>
<script>
    // Escapa HTML: convierte caracteres como < o > en texto seguro (evita inyectar código en la tabla)
    function esc(texto) {
        return $("<div>").text(texto ?? "").html();
    }

    // Formatea números al estilo argentino con 2 decimales: 1234.5 -> 1.234,50
    function formatoMoneda(valor) {
        return Number(valor).toLocaleString("es-AR", { minimumFractionDigits: 2, maximumFractionDigits: 2 });
    }

    // Se ejecuta cuando la página termina de cargar
    $(document).ready(function () {
        $("#order").val("");
        // Pedir al servidor las unidades de medida y llenar el select del filtro.
        // Unidades de medida parametrizables (cod-unidad descripción)
        $.ajax({
            url: './desplegables.php',
            type: 'GET',
            success: function (response) {
                // El servidor responde texto JSON; se convierte a objeto
                var unidadesJson = JSON.parse(response);
                var select = $('#filterUnidad');
                select.empty();
                select.append('<option value="">Selecciona</option>');
                // Una opción por unidad, con formato "cod-unidad descripción"
                unidadesJson.unidades.forEach(function (item) {
                    select.append('<option value="' + esc(item.cod_unidad) + '">' + esc(item.cod_unidad) + ' ' + esc(item.descripcion) + '</option>');
                });
            }
        });

        // Cada botón de título escribe el nombre de su columna en el campo "Orden"
        $("#btnNroOrden").click(function () { $("#order").val("nro_orden"); });
        $("#btnCodigo").click(function () { $("#order").val("codigo_producto"); });
        $("#btnDescripcion").click(function () { $("#order").val("descripcion"); });
        $("#btnCantidad").click(function () { $("#order").val("cantidad"); });
        $("#btnUnidad").click(function () { $("#order").val("cod_unidad"); });
        $("#btnPrecio").click(function () { $("#order").val("precio_unitario"); });
        $("#btnImporte").click(function () { $("#order").val("importe_renglon"); });
        $("#btnFecha").click(function () { $("#order").val("fecha_orden"); });
    });

    // Pide los renglones al servidor (con filtros y orden) y dibuja la tabla
    function cargaTabla() {
        $("#tbDatos").html("<p>Esperando respuesta... <span class='loader'></span></p>");

        $.ajax({
            type: "GET",
            url: "./renglonesJSONPrepare.php",
            // Parámetros que viajan por GET al PHP
            data: {
                orden: $("#order").val(),
                filterNroOrden: $("#filterNroOrden").val(),
                filterCodigo: $("#filterCodigo").val(),
                filterDescripcion: $("#filterDescripcion").val(),
                filterFecha: $("#filterFecha").val(),
                filterUnidad: $("#filterUnidad").val()
            },
            // Si el servidor responde bien:
            success: function (respuestaDelServer) {
                $("#tbDatos").empty();
                var objJson = JSON.parse(respuestaDelServer);
                // Si el PHP devolvió un error, mostrarlo y cortar
                if (objJson.error) {
                    alert(objJson.error);
                    return;
                }
                // Por cada renglón se crea una fila <tr> y se agrega a la tabla
                objJson.renglones.forEach(function (r) {
                    // Link al comprobante (pdf o imagen guardado en la base); "-" si no tiene
                    var comprobante = r.TienePdf
                        ? "<a href='./verComprobante.php?id=" + encodeURIComponent(r.Id) + "' target='_blank'>Ver</a>"
                        : "-";
                    var row = document.createElement("tr");
                    row.innerHTML = `
                    <td campo-dato='nro_orden'> ${esc(r.NroOrden)} </td>
                    <td campo-dato='codigo_producto'> ${esc(r.CodigoProducto)} </td>
                    <td campo-dato='descripcion'> ${esc(r.Descripcion)} </td>
                    <td campo-dato='cantidad'> ${formatoMoneda(r.Cantidad)} </td>
                    <td campo-dato='unidad'> ${esc(r.Unidad)} </td>
                    <td campo-dato='precio_unitario'> ${formatoMoneda(r.PrecioUnitario)} </td>
                    <td campo-dato='importe_renglon'> ${formatoMoneda(r.ImporteRenglon)} </td>
                    <td campo-dato='fecha_orden'> ${esc(r.FechaOrden)} </td>
                    <td campo-dato='pdf_comprobante'> ${comprobante} </td>`;
                    $("#tbDatos").append(row);
                });
                $("#totalRegistros").html("Nro de registros: " + objJson.cuenta);
            },
            // Si falla la comunicación con el servidor:
            error: function () {
                $("#tbDatos").empty();
                alert("Error al cargar los datos");
            }
        });
    }

    // Botón "Cargar Datos"
    $("#cargar").click(function () {
        cargaTabla();
    });

    // Botón "Vaciar Datos": limpia filtros, orden, tabla y contador
    $("#vaciar").click(function () {
        $("#filterNroOrden").val('');
        $("#filterCodigo").val('');
        $("#filterDescripcion").val('');
        $("#filterFecha").val('');
        $("#filterUnidad").val('');
        $("#order").val('');
        $("#tbDatos").empty();
        $("#totalRegistros").text('');
    });
</script>

</html>
