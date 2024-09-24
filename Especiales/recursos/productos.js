const productos_motos ={
    motos: [
      {
        "cod": 10119,
        "marca": "Honda",
        "modelo": "CBR1000RR",
        "cilindrada": 999,
        "velocidad_maxima": 299,
        "inyeccion": true,
        "fecha_lanzamiento": "2021-05-01"
      },
      {
        "cod": 10128,
        "marca": "Yamaha",
        "modelo": "YZF-R6",
        "cilindrada": 599,
        "velocidad_maxima": 262,
        "inyeccion": true,
        "fecha_lanzamiento": "2020-03-15"
      },
      {
        "cod": 86119,
        "marca": "Kawasaki",
        "modelo": "Ninja ZX-10R",
        "cilindrada": 998,
        "velocidad_maxima": 299,
        "inyeccion": false,
        "fecha_lanzamiento": "2021-08-10"
      },
      {
        "cod": 12117,
        "marca": "Ducati",
        "modelo": "Panigale V4",
        "cilindrada": 1103,
        "velocidad_maxima": 300,
        "inyeccion": true,
        "fecha_lanzamiento": "2022-01-20"
      },
      {
        "cod": 56120,
        "marca": "Suzuki",
        "modelo": "GSX-R750",
        "cilindrada": 750,
        "velocidad_maxima": 280,
        "inyeccion": true,
        "fecha_lanzamiento": "2020-07-05"
      },
      {
        "cod": 56099,
        "marca": "BMW",
        "modelo": "S1000RR",
        "cilindrada": 999,
        "velocidad_maxima": 299,
        "inyeccion": true,
        "fecha_lanzamiento": "2021-11-28"
      },
      {
        "cod": 40119,
        "marca": "Triumph",
        "modelo": "Daytona 675",
        "cilindrada": 675,
        "velocidad_maxima": 248,
        "inyeccion": true,
        "fecha_lanzamiento": "2019-12-12"
      },
      {
        "cod": 30115,
        "marca": "Aprilia",
        "modelo": "RSV4",
        "cilindrada": 1077,
        "velocidad_maxima": 286,
        "inyeccion": true,
        "fecha_lanzamiento": "2020-09-30"
      },
      {
        "cod": 15154,
        "marca": "KTM",
        "modelo": "RC 390",
        "cilindrada": 373,
        "velocidad_maxima": 179,
        "inyeccion": true,
        "fecha_lanzamiento": "2019-04-17"
      },
      {
        "cod": 30229,
        "marca": "MV Agusta",
        "modelo": "F4",
        "cilindrada": 998,
        "velocidad_maxima": 298,
        "inyeccion": true,
        "fecha_lanzamiento": "2022-03-15"
      }
    ]
  }
  

const dataTabla = document.getElementById("tbody")

$('#cargarDatos').on("click", function() {
  productos_motos.motos.forEach(function (motos) {
    let row = document.createElement("tr")
    row.innerHTML = `
    <td dataTabla = 'cod'>${motos.cod}</td>
    <td dataTabla = 'marca'>${motos.marca}</td>
    <td dataTabla = 'modelo'>${motos.modelo}</td>
    <td dataTabla = 'cilindrada'>${motos.cilindrada}cc</td>
    <td dataTabla = 'velocidad_maxima'>${motos.velocidad_maxima} km/h</td>
    <td dataTabla = 'inyeccion'>${motos.inyeccion}</td>
    <td dataTabla = 'fecha_lanzamiento'>${motos.fecha_lanzamiento}</td>
    `
    dataTabla.appendChild(row)
  })
})

$('#vaciarDatos').on("click", function() {
  $('#tbody').empty()
  console.log("click")
})

// Evento para cargar el formulario
$('#cargarFormulario').on("click", function() {
  window.location.href = '/Especiales/esp05FormVariableArregloDeObjetos/index.html';  
})