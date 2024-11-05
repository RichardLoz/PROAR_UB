
<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header('Location: ../no_session.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./style.css">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <title>ejer26DBAbm</title>
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
        <dialog class="modalAbrirPDF"></dialog>
        <dialog class="modalAlta"><iframe src="./AltaForm.php"  width='800px' height='500px' frameborder="0"></iframe><button class='cerrarventana' onclick=cerrarAlta()>X</button></dialog>
        <dialog class="modalModi"><iframe src="./Modiform.php"  width='800px' height='800px' frameborder="0"></iframe><button class='cerrarventana' onclick=cerrarModi()>X</button></dialog></dialog> 
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
            <th campo-dato='png'>TImagen</th>
        </tfoot>
    </table>
    <footer><span id="totalRegistros"></span> Registros</footer>
</body>
<script>
$(document).ready(function() {
          const ModalAbrirAlta = document.querySelector(".modalAlta");
          if (ModalAbrirAlta) {
              $('#altaBtn').click(function() {
                  ModalAbrirAlta.showModal();
              });
          } else {
              console.error("Modal para 'Alta Registro' no encontrado.");
          }
      });
</script>

<script src="./CargarTabla.js"></script>
<script src="./MostrarPDF.js"></script>
<script src="./Modificar.js"></script>
<script src="./baja.js"></script>

<script>
    const ModalAbrirAlta = document.querySelector(".modalAlta");
    $('#altaBtn').click(function(){
        if (ModalAbrirAlta) {
            ModalAbrirAlta.showModal();
        }
    });

    function cerrarAlta(){
        if (ModalAbrirAlta) {
            ModalAbrirAlta.close();
        }
    }
    
    const ModalAbrirModi = document.querySelector(".modalModi");
    $('#Modificar').click(function(){
        if (ModalAbrirModi) {
            ModalAbrirModi.showModal();
        }
    });

    function cerrarModi(){
        if (ModalAbrirModi) {
            ModalAbrirModi.close();
        }
    }

    $(document).ready(function() {
    $("#cerrarSesion").click(function() {
    location.href="../DestruirSesion.php";
    });


    function eliminarCancion(id) {
    if (confirm("¿Estás seguro de que deseas eliminar esta canción?")) {
        $.ajax({
            type: "POST",
            url: "baja.php",
            data: { id: id },
            success: function(response) {
                alert(response);
                cargaTabla(); // Recargar la tabla para reflejar los cambios
            },
            error: function() {
                alert("Error al eliminar la canción.");
            }
        });
    }
}


});

</script>

</html>
