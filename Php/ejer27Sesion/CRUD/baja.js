function Borrar(id, nombre) {
    if (confirm(`¿Desea eliminar la canción con ID ${id}: ${nombre}?`)) {
        $.ajax({
            url: './baja.php',
            type: 'GET',
            data: { id: id },
            success: function (response) {
                alert('Registro eliminado exitosamente');
                cargaTabla(); // Recargar la tabla para reflejar el cambio
            },
            error: function () {
                alert('Hubo un error al intentar eliminar el registro');
            }
        });
    } else {
        alert('No se eliminó ningún registro');
    }
}
