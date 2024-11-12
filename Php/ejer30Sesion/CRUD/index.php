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
            <input type="text" id="order"></input>
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
    $(document).ready(function() {
        const ModalAbrirAlta = document.querySelector("#modalAlta");

        // Abrir modal para Alta de Canción
        $('#altaBtn').click(function() {
            $('#formContainer').load('AltaCancion.php', function() {
                ModalAbrirAlta.showModal();
            });
        });

        // Cerrar modal de alta
        function cerrarAlta() {
            if (ModalAbrirAlta) {
                ModalAbrirAlta.close();
                $('#formContainer').empty();
            }
        }

        // Manejar el cierre del modal de Alta de Canción
        window.cerrarAlta = cerrarAlta;

        // Toast Notification Function
        function showToast(message) {
            const toast = $('#toast');
            toast.text(message).fadeIn();
            setTimeout(() => toast.fadeOut(), 3000);
        }

        // Cerrar sesión
        $("#cerrarSesion").click(function() {
            location.href = "../DestruirSesion.php";
        });

        // Función para eliminar canción
        function eliminarCancion(id) {
            if (confirm("¿Estás seguro de que deseas eliminar esta canción?")) {
                $.ajax({
                    type: "POST",
                    url: "baja.php",
                    data: { id: id },
                    success: function(response) {
                        showToast(response);
                        cargaTabla();
                    },
                    error: function() {
                        showToast("Error al eliminar la canción.");
                    }
                });
            }
        }
    });
</script>

</html>
