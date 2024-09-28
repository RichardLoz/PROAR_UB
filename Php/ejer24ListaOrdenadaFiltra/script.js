const series = {
  seriesData: [
    {
      "ID": 1,
      "Nombre": "The Witcher",
      "Descripcion": "Aventuras y fantasía",
      "Plataforma": "Netflix",
      "Fecha_estreno": "2021-12-17",
      "Imagen_portada": "witcher.jpg",
      "Presupuesto": 80000000
    },
    {
      "ID": 2,
      "Nombre": "Stranger Things",
      "Descripcion": "Ciencia ficción y terror",
      "Plataforma": "Netflix",
      "Fecha_estreno": "2016-07-15",
      "Imagen_portada": "stranger_things.jpg",
      "Presupuesto": 75000000
    },
    {
      "ID": 3,
      "Nombre": "The Mandalorian",
      "Descripcion": "Space western",
      "Plataforma": "Disney",
      "Fecha_estreno": "2019-11-12",
      "Imagen_portada": "mandalorian.jpg",
      "Presupuesto": 100000000
    },
    {
      "ID": 4,
      "Nombre": "Game of Thrones",
      "Descripcion": "Drama y fantasía",
      "Plataforma": "HBO",
      "Fecha_estreno": "2011-04-17",
      "Imagen_portada": "game_of_thrones.jpg",
      "Presupuesto": 100000000
    },
    {
      "ID": 5,
      "Nombre": "Breaking Bad",
      "Descripcion": "Drama y crimen",
      "Plataforma": "Netflix",
      "Fecha_estreno": "2008-01-20",
      "Imagen_portada": "breaking_bad.jpg",
      "Presupuesto": 35000000
    },
    {
      "ID": 6,
      "Nombre": "Friends",
      "Descripcion": "Comedia",
      "Plataforma": "Netflix",
      "Fecha_estreno": "1994-09-22",
      "Imagen_portada": "friends.jpg",
      "Presupuesto": 10000000
    },
    {
      "ID": 7,
      "Nombre": "The Crown",
      "Descripcion": "Drama histórico",
      "Plataforma": "Netflix",
      "Fecha_estreno": "2016-11-04",
      "Imagen_portada": "the_crown.jpg",
      "Presupuesto": 13000000
    },
    {
      "ID": 8,
      "Nombre": "The Boys",
      "Descripcion": "Superhéroes y acción",
      "Plataforma": "Amazon",
      "Fecha_estreno": "2019-07-26",
      "Imagen_portada": "the_boys.jpg",
      "Presupuesto": 50000000
    },
    {
      "ID": 9,
      "Nombre": "Westworld",
      "Descripcion": "Ciencia ficción",
      "Plataforma": "HBO",
      "Fecha_estreno": "2016-10-02",
      "Imagen_portada": "westworld.jpg",
      "Presupuesto": 80000000
    },
    {
      "ID": 10,
      "Nombre": "The Marvelous Mrs. Maisel",
      "Descripcion": "Comedia-drama",
      "Plataforma": "Amazon",
      "Fecha_estreno": "2017-03-17",
      "Imagen_portada": "marvelous_maisel.jpg",
      "Presupuesto": 35000000
    }
  ]
};




const dataTabla = document.getElementById("tbody")

$('#cargarDatos').on("click", function() {
  series.seriesData.forEach(function (serie) {
    let row = document.createElement("tr");
    row.innerHTML = `
      <td dataTabla='Id'>${serie.ID}</td>
      <td dataTabla='Nombre'>${serie.Nombre}</td>
      <td dataTabla='Descripcion'>${serie.Descripcion}</td>
      <td dataTabla='Plataforma'>${serie.Plataforma}</td>
      <td dataTabla='Fecha_estreno'>${serie.Fecha_estreno}</td>
      <td dataTabla='Imagen_portada'>${serie.Imagen_portada}</td>
      <td dataTabla='Presupuesto'>$${serie.Presupuesto}</td>
    `;
    dataTabla.appendChild(row);
  });
});


$('#vaciarDatos').on("click", function() {
  $('#tbody').empty()
  console.log("click")
})



const Plataformas = '{"plataformas": ' +
'[' +
'{"Plataforma":"Netflix"},' +
'{"Plataforma":"Disney"},' +
'{"Plataforma":"HBO"},' +
'{"Plataforma":"Amazon"},' +
']' +
'}';

const plataformasSeries = JSON.parse(Plataformas)

const opcionesPlataforma= () => {
    plataformasSeries.plataformas.forEach(function(argValor, argIndice) {
        const objOpcion = document.createElement("option")
        objOpcion.setAttribute("className", "elementoOptionSelect")
        objOpcion.setAttribute("value", argValor.Plataforma)
        objOpcion.innerHTML = argValor.Plataforma
        document.getElementById("plataforma").appendChild(objOpcion)
    })
}

$(document).ready(function (){
    opcionesPlataforma()
})