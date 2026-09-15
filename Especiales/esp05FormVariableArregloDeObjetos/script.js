/*
    esp05 - Form con variable de tipo arreglo de objetos
    --------------------------------------------------------------
    El <select> de "Paradigma" no se escribe a mano en el HTML:
    se arma por programa a partir de un arreglo de objetos que
    viene de un archivo JSON externo (../recursos/lenguajes.json).
*/

// Función que recibe el objeto con los datos y llena el <select> del formulario.
// Se declara como const + función flecha (convención de la cátedra: const para funciones).
const opcionesParadigma = (catalogo) => {

    // catalogo.paradigmas es el ARREGLO DE OBJETOS. Cada vuelta del forEach
    // trabaja con un objeto del tipo { "Paradigma": "Funcional" }.
    catalogo.paradigmas.forEach(function (argValor) {

        // Creo en memoria un nuevo elemento <option>, todavía suelto (sin padre en el DOM).
        const objOpcion = document.createElement("option");

        // Le pongo una clase CSS, por si después quiero darle estilo a las opciones.
        objOpcion.setAttribute("class", "elementoOptionSelect");

        // El atributo value es el dato que viaja al servidor cuando se envía el form.
        objOpcion.setAttribute("value", argValor.Paradigma);

        // El innerHTML es el texto que el usuario ve desplegado en la lista.
        objOpcion.innerHTML = argValor.Paradigma;

        // Recién acá cuelgo el <option> dentro del <select>, y aparece en pantalla.
        document.getElementById("paradigma").appendChild(objOpcion);
    });
};

// $(document).ready() es de jQuery: espera a que el HTML esté completamente armado
// antes de ejecutar. Sin esto, getElementById("paradigma") podría devolver null.
$(document).ready(function () {

    // fetch() pide el archivo JSON al servidor. Devuelve una promesa (es asincrónico:
    // el navegador sigue trabajando mientras el archivo viaja).
    // Ojo: la ruta es relativa a esta carpeta, por eso el "../" para salir a Especiales.
    fetch('../recursos/lenguajes.json')

        // Primer .then(): llegó la respuesta cruda. La convierto de texto a objeto JavaScript.
        .then(response => response.json())

        // Segundo .then(): acá "data" ya es el objeto { paradigmas: [ {...}, {...} ] }.
        .then(data => {

            // Lo muestro por consola (F12) para verificar que cargó bien.
            console.log('Paradigmas: ', data);

            // Le paso el objeto a mi función para que dibuje las opciones.
            opcionesParadigma(data);
        })

        // .catch() atrapa cualquier error: archivo inexistente, JSON mal formado, o
        // estar abriendo la página con file:// en vez de con un servidor web.
        .catch(error => console.error('Error al cargar el archivo JSON:', error));
});
