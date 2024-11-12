<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./style.css">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <title>ejer30-Sesión-ABM</title>
</head>

<body>
    <div class="head">
        <header>
            <h3>Canciones UB-MUSIC</h3>
            <button id="cerrarSesion">Cerrar Sesión</button>
        </header>
        <div class="command">
            <p>Orden</p>
            <input type="text" id="order">
            <button id="cargar">Cargar Datos</button>
            <button id="vaciar">Vaciar Datos</button>
            <button id="limpiarBtn">Limpiar Filtros</button>
            <button id="altaBtn">Alta Registro</button>
        </div>
    </div>

    <div class="modales">
        <!-- Modal para Alta de Canción -->
        <dialog class="modalAlta" id="modalAlta">
            <div id="formContainer"></div>
            <button class='cerrarventana' onclick="cerrarAlta()">X</button>
        </dialog>

        <!-- Modal para Confirmar Eliminación -->
        <dialog class="modalEliminar" id="modalEliminar">
            <p id="eliminarInfo"></p>
            <button class="confirm" id="confirmDelete">CONFIRMAR</button>
            <button class="cancel" id="cancelDelete">CANCELAR</button>
        </dialog>
    </div>

    <table style="width: 100%;">
        <thead>
            <tr>
                <th campo-dato='id'><button id="btnID">Id</button></th>
                <th campo-dato='nombre'><button id="btnNombre">Nombre</button></th>
                <th campo-dato='genero_id'><button id="btnGenero">Género</button></th>
                <th campo-dato='artista'><button id="btnArtista">Artista</button></th>
                <th campo-dato='fecha_estreno'><button id="btnFecha">Fecha de Estreno</button></th>
                <th campo-dato='png'>Portada</th>
                <th campo-dato='acciones'>Acciones</th>
            </tr>
        </thead>
        <tbody id="tbDatos"></tbody>
    </table>
    <footer><span id="totalRegistros"></span> Registros</footer>

    <!-- Notificación estilo "toast" -->
    <div id="toast" style="display: none;"></div>
</body>

<script src="./CargarTabla.js"></script>
<script src="./MostrarPDF.js"></script>
<script src="./Modificar.js"></script>
<script src="./baja.js"></script>

<script>
    $(document).ready(function () {
        const modalAlta = document.querySelector("#modalAlta");
        const modalEliminar = document.querySelector("#modalEliminar");
        let idEliminar = null;

        // Abrir modal para Alta de Canción
        $('#altaBtn').click(function () {
            $('#formContainer').load('AltaCancion.php', function () {
                modalAlta.showModal();
            });
        });

        // Cerrar modal de alta
        function cerrarAlta() {
            if (modalAlta) {
                modalAlta.close();
                $('#formContainer').empty();
            }
        }
        window.cerrarAlta = cerrarAlta;

        // Mostrar modal de confirmación para eliminar
        window.Borrar = function (id, nombre) {
            idEliminar = id;
            $("#eliminarInfo").text(`¿Desea eliminar la canción con ID ${id}: ${nombre}?`);
            if (modalEliminar) {
                modalEliminar.showModal();
            }
        };

        // Confirmar eliminación
        $('#confirmDelete').click(async function () {
            if (idEliminar) {
                try {
                    const response = await $.ajax({
                        type: 'POST',
                        url: 'baja.php',
                        data: { id: idEliminar }
                    });

                    if (response.trim() === "success") {
                        showToast("Canción eliminada exitosamente");
                        cargaTabla(); // Recargar la tabla después de eliminar
                    } else {
                        showToast(response);
                    }
                } catch (error) {
                    showToast("Error al eliminar la canción");
                }
            }
            modalEliminar.close();
        });

        // Cancelar eliminación
        $('#cancelDelete').click(function () {
            modalEliminar.close();
            showToast("Acción cancelada");
        });

        // Mostrar notificación tipo "toast"
        function showToast(message) {
            const toast = $('#toast');
            toast.text(message).fadeIn();
            setTimeout(() => toast.fadeOut(), 3000);
        }

        // Cerrar sesión
        $("#cerrarSesion").click(function () {
            location.href = "../DestruirSesion.php";
        });

        // Función para cargar la tabla de canciones
        function cargaTabla() {
            $.ajax({
                type: "GET",
                url: './cancionesJSONPrepare.php',
                success: function (data) {
                    let canciones = JSON.parse(data);
                    let tablaHtml = "";
                    canciones.forEach(cancion => {
                        tablaHtml += `
                        <tr>
                            <td>${cancion.ID}</td>
                            <td>${cancion.nombre}</td>
                            <td>${cancion.genero}</td>
                            <td>${cancion.artista}</td>
                            <td>${cancion.fecha_estreno}</td>
                            <td><img src="./img_no.jpeg" alt="Portada" width="50"></td>
                            <td>
                                <button class="btnModificar" onclick="Modificar(${cancion.ID})">Modificar</button>
                                <button class="btnEliminar" onclick="Borrar(${cancion.ID}, '${cancion.nombre}')">Eliminar</button>
                            </td>
                        </tr>`;
                    });
                    $('#tbDatos').html(tablaHtml);
                    $("#totalRegistros").text(`Nro de registros: ${canciones.length}`);
                },
                error: function () {
                    showToast("Error al cargar los datos");
                }
            });
        }

        cargaTabla(); // Cargar la tabla al inicio
    });
</script>

</html>
