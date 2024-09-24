const opcionesMarca = (concesionaria) => {
    concesionaria.marcas.forEach(function(argValor) {
        const objOpcion = document.createElement("option");
        objOpcion.setAttribute("class", "elementoOptionSelect");
        objOpcion.setAttribute("value", argValor.Marca);
        objOpcion.innerHTML = argValor.Marca;
        document.getElementById("marca").appendChild(objOpcion);
    });
};

$(document).ready(function () {
    fetch('/Especiales/recursos/marcas.json')
        .then(response => response.json())
        .then(data => {
            console.log('Productos: ', data);
            opcionesMarca(data);
        })
        .catch(error => console.error('Error al cargar el archivo JSON:', error));
});