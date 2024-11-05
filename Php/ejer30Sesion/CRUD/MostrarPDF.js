const ModalAbrirPDF = document.querySelector(".modalAbrirPDF")
function MostrarPDF(id) {
    $.ajax({
        url: './PDF.php',
        type: 'GET',
        data: {
            id: id
        },
        success: function (response) {
            $PDFSJson = JSON.parse(response);
            $(".modalAbrirPDF").html("<iframe frameborder='0' width='800px' height='600px' src='data:application/pdf;base64, " + $PDFSJson.PNG + "'></iframe><button class='cerrarVentana' onclick=cerrarPDF()>X</button>");
            ModalAbrirPDF.showModal();
            $("body").css("opacity", "0.3");
            $(".cerrarVentana").css({ "float": "right", "padding": "20px" });
            $(".modalAbrirPDF").css("background-color", "rgb(4, 22, 22)");
        }
    })
}
function cerrarPDF() {
    ModalAbrirPDF.close();
    $("body").css("opacity", "1");
};
