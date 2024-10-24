
function Borrar(id){
    if(confirm('Desea eliminar el siguiente el Auto '+ id+ ' ?')){
        $.ajax({
            url: './baja.php',
            type: 'GET',
            data: {
                id: id
            },
            success: function (response) {
                alert('Registro eliminado exitosamente');
            }
        })
    }else{
        alert('No se elimino ningun registro');
    }
    
}
