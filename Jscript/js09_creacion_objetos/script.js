/*
    js09 - Creación dinámica de objetos del DOM
    ------------------------------------------------------------------
    Apunte jsParte2: "Creación dinámica de objetos. Permite crear
    objetos del DOM desde la nada".

    Métodos que se usan acá:
      document.createElement()  -> crea el objeto en memoria
      objeto.innerHTML          -> le carga el contenido html
      objeto.className          -> le asigna una clase de la galería CSS
      contenedor.appendChild()  -> lo cuelga del contenedor y recién ahí
                                   se convierte en elemento HTML visible
      contenedor.removeChild()  -> borra un nodo del contenedor
      contenedor.childNodes     -> array con los nodos hijos (tiene .length)

    En este ejercicio el contenedor es un <ul> y los objetos creados son <li>.
*/


const objBtCrear = document.getElementById("btCrear");
const objBtLimpiar = document.getElementById("btLimpiar");
const objBtInfo = document.getElementById("btInfo");
const objContenedor = document.getElementById("contenedor");


const crearElemento = () => {

    const objLi = document.createElement("li");

    let textoHtml = "Elemento creado: ";

    textoHtml = textoHtml + "<span class='numero'>";
    textoHtml = textoHtml + objContenedor.childNodes.length;
    textoHtml = textoHtml + "</span>";

    objLi.innerHTML = textoHtml;

    objLi.className = "claseObjetoDinamico";

    objContenedor.appendChild(objLi);

    objContenedor.scrollTop = objContenedor.scrollHeight;
};


const limpiarContenedor = () => {
    while (objContenedor.childNodes.length > 0) {
        objContenedor.removeChild(objContenedor.childNodes[0]);
    }
};


const mostrarInfo = () => {

    const cantidad = objContenedor.childNodes.length;

    if (cantidad > 0) {
        alert("longitud del childNodes: " + cantidad);
    }
    else {
        alert("Todavía no hay elementos creados.");
    }
};



objBtCrear.addEventListener("click", function () {
    crearElemento();
});

objBtLimpiar.addEventListener("click", function () {
    limpiarContenedor();
});

objBtInfo.addEventListener("click", function () {
    mostrarInfo();
});
