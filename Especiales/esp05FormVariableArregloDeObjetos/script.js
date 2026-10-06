/*
    esp05 - Form con variable de tipo arreglo de objetos
    El <select> de unidades se arma desde un JSON externo (../recursos/unidades.json)
    y el importe del renglón se calcula solo (cantidad x precio).
*/

// Llena el <select> con un <option> por cada objeto de catalogo.unidades.
const opcionesUnidad = (catalogo) => {
    // Cada objeto tiene la forma { "Cod": "KG", "Unidad": "Kg", "Descripcion": "Kilogramo" }.
    catalogo.unidades.forEach(function (argValor) {
        // Creo el <option> en memoria.
        const objOpcion = document.createElement("option");
        objOpcion.setAttribute("class", "elementoOptionSelect");
        // value = lo que viaja al enviar el form (el código).
        objOpcion.setAttribute("value", argValor.Cod);
        // Texto visible para el usuario.
        objOpcion.innerHTML = argValor.Cod + " - " + argValor.Unidad + " (" + argValor.Descripcion + ")";
        // Lo cuelgo en el <select>: recién ahí aparece en pantalla.
        document.getElementById("unidad_medida").appendChild(objOpcion);
    });
};

// importe_renglon = cantidad x precio_unitario (si un campo está vacío cuenta como 0).
const calcularImporte = () => {
    const cantidad = parseFloat($("#cantidad").val()) || 0;
    const precio = parseFloat($("#precio_unitario").val()) || 0;
    $("#importe_renglon").val((cantidad * precio).toFixed(2));
};

// Espera a que el HTML esté listo antes de buscar elementos.
$(document).ready(function () {

    // Recalcula el importe cada vez que se escribe cantidad o precio.
    $("#cantidad, #precio_unitario").on("input", calcularImporte);

    // Pide el JSON (ruta relativa a esta carpeta; requiere servidor web, no file://).
    fetch('../recursos/unidades.json')
        .then(response => response.json())   // texto -> objeto JS
        .then(data => {
            console.log('Unidades de medida: ', data);
            opcionesUnidad(data);            // dibuja las opciones
        })
        .catch(error => console.error('Error al cargar el archivo JSON:', error));
});
