const ModalModi = document.querySelector(".modalModi");
function Modificar(id){
    $.ajax({
        url: './modi.php',
        type: 'GET',
        data: {
            id: id,
            Nombre: $("#Nombre").val(),
            Genero: $("#Genero").val(),
            Artista: $("#Artista").val(),
            Fecha: $("#Fecha").val(),
        },
        success: function (response) {
            console.log(response);
            $objJson = JSON.parse(response);
            $modalModi = $(".modalModi");
            $modalModi.html("<iframe src='./Modiform.php' frameborder='0'></iframe><button class='cerrarVentanaModi' onclick=cerrarModi()>X</button>");
            $modalModi.showModal();
            $("body").css("opacity", "0.3");
            $(".cerrarVentanaModi").css({ "float": "right", "padding": "20px" });
            $modalModi.css("background-color", "rgb(4, 22, 22)");
            objJson.canciones.forEach(function (auto) {
            console.log(cancion.Nombre)
            $("#Nombre").append(cancion.Nombre);
            $("#Genero").append(cancion.Genero);
            $("#Artista").append(cancion.Artista);
            $("#Fecha").append(cancion.Fecha);
        })
}
    })}
function cerrarModi() {
    ModalModi.close();
    $("body").css("opacity", "1");
};
