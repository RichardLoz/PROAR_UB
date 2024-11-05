function Modificar(id) {
    const ModalModi = document.querySelector(".modalModi");

    $.ajax({
        url: './modi.php',
        type: 'GET',
        data: { id: id },
        success: function (response) {
            try {
                const objJson = JSON.parse(response);

                // Llenar el select de Géneros
                $.ajax({
                    url: './desplegables.php',
                    type: 'GET',
                    success: function (res) {
                        const generos = JSON.parse(res).generos;
                        const selectGenero = $("#GeneroFormModi");
                        selectGenero.empty();

                        generos.forEach(function (item) {
                            const option = new Option(item.genero, item.id_genero);
                            if (item.id_genero == objJson.genero_id) {
                                option.selected = true;
                            }
                            selectGenero.append(option);
                        });
                    },
                    error: function() {
                        alert("Error al cargar los géneros.");
                    }
                });

                // Llenar otros campos con los datos del registro seleccionado
                $("#Nombre").val(objJson.nombre);
                $("#Artista").val(objJson.artista);
                $("#Fecha").val(objJson.fecha_estreno);

                // Mostrar el modal y aplicar opacidad
                if (ModalModi) {
                    ModalModi.showModal();
                    $("body").css("opacity", "0.3");
                } else {
                    console.error("No se encontró el modal para modificar.");
                }
            } catch (e) {
                console.error("Error al parsear JSON:", e, response);
                alert("Error al cargar los datos de la canción.");
            }
        },
        error: function () {
            alert('Error en la solicitud a modi.php');
        }
    });
}

function cerrarModi() {
    const ModalModi = document.querySelector(".modalModi");
    if (ModalModi) {
        ModalModi.close();
        $("body").css("opacity", "1"); 
    } else {
        console.error("No se encontró el modal para cerrar.");
    }
}

// Restaurar opacidad al cerrar modal
document.querySelector(".modalModi").addEventListener("close", function () {
    $("body").css("opacity", "1");
});
