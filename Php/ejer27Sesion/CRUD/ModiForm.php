<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modificar Registro</title>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
    integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
</head>
<body>
    <form id="formDeModi" method="post" enctype="multipart/form-data" >

        <div>
            <label>Marca</label><select name="Marca" id="MarcaFormModi" required>
                <option value=""></option>
            </select><br>
        </div>
        <div>
            <label>Modelo</label>
            <input type="text" id="Modelo" name="Modelo" required><br>
        </div>
        <div>
            <label>Cilindrada</label>
            <input type="text" id="Cilindrada" name="Cilindrada" required><br>
        </div>
        <div>
            <label>Color</label>
            <select name="Color" id="ColorFormModi" name="Color" required>
                <option value=""></option>
            </select><br>
        </div>
        <div>
            <label>Fecha</label>
            <input type="date" name="Fecha" id="Fecha" required><br>
        </div>
        <div>
            <label>PDF</label>
            <input type="file" id="PdfEnForm" name="PDF" accept= '.pdf'/><br>
        </div>
        <input type="hidden" id='oculto' name='oculto'>
        <button id="submits" type="submit" value="DarAlta" >Enviar Formulario</button>
    </form>
</body>

<style>
 body {
        background-color: rgb(67, 65, 65);
        font-family: 'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif;
        font-size: 20px;
    }
button{
    padding: 20px;
    font-size: 20px;
    background-color: rgb(32, 38, 38);
    color: white;
}
form{
    display: block;
    align-content: center;
}    
</style>

<script src="Modificar.js"></script>
<script>
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


$(document).ready(function () {
    $("#submits").click(function () {
            var data = new FormData($("#formDeAlta")[0]);
            var objAjax = $.ajax({
            type: 'post',
            method: 'post',
            enctype: 'multipart/form-data',
            url: "./Modi.php",
            processData: false,
            contentType: false,
            cache: false,
            data: data,
            success: function (respuestaDelServer, estado) {
                console.log(respuestaDelServer);
                console.log('entra');
                console.log(estado);
            }
        })
    })
});

</script>
</html>