function confirmarEnvio() {
    //valores de los campos de entrada
    const nombre = document.getElementById('nombre').value;
    const apellido = document.getElementById('apellido').value;

    // Mostrar una ventana de confirmación
    return confirm('¿Desea enviar el formulario con los siguientes datos?\n\nNombre: ' + nombre + '\nApellido: ' + apellido);
}

// Función para limpiar el formulario
function limpiarFormulario() {
    document.getElementById('nombre').value = '';
    document.getElementById('apellido').value = '';
}