// Objeto con los datos. "renglones" es un arreglo de objetos: cada objeto es una fila de la tabla.
const orden_compra = {
    renglones: [
      { "nro_orden": 1001, "codigo_producto": "PRD-001", "descripcion": "Aceite de girasol", "cantidad": 20, "unidad_medida": "Litro", "precio_unitario": 1850.50, "pdf_comprobante": "OC-1001.pdf" },
      { "nro_orden": 1001, "codigo_producto": "PRD-002", "descripcion": "Harina 000", "cantidad": 50, "unidad_medida": "Kg", "precio_unitario": 920.00, "pdf_comprobante": "OC-1001.pdf" },
      { "nro_orden": 1001, "codigo_producto": "PRD-003", "descripcion": "Tomate triturado", "cantidad": 40, "unidad_medida": "Lata", "precio_unitario": 780.25, "pdf_comprobante": "OC-1001.pdf" },
      { "nro_orden": 1002, "codigo_producto": "PRD-004", "descripcion": "Fideos secos", "cantidad": 12, "unidad_medida": "Caja", "precio_unitario": 14500.00, "pdf_comprobante": "OC-1002.pdf" },
      { "nro_orden": 1002, "codigo_producto": "PRD-005", "descripcion": "Azúcar", "cantidad": 30, "unidad_medida": "Kg", "precio_unitario": 1100.00, "pdf_comprobante": "OC-1002.pdf" },
      { "nro_orden": 1003, "codigo_producto": "PRD-006", "descripcion": "Bolsa de residuos", "cantidad": 100, "unidad_medida": "Uni", "precio_unitario": 350.75, "pdf_comprobante": "OC-1003.pdf" },
      { "nro_orden": 1003, "codigo_producto": "PRD-007", "descripcion": "Lavandina", "cantidad": 25, "unidad_medida": "Litro", "precio_unitario": 890.00, "pdf_comprobante": "OC-1003.pdf" },
      { "nro_orden": 1004, "codigo_producto": "PRD-008", "descripcion": "Arvejas en conserva", "cantidad": 60, "unidad_medida": "Lata", "precio_unitario": 640.90, "pdf_comprobante": "OC-1004.pdf" }
    ]
  }


// Referencia al <tbody> donde se van a agregar las filas.
const dataTabla = document.getElementById("tbody")

// Formatea un número como moneda (pesos argentinos).
const formatoMoneda = (valor) => valor.toLocaleString("es-AR", { style: "currency", currency: "ARS" })

// Al hacer click en "Cargar Datos" (jQuery)...
$('#cargarDatos').on("click", function() {
  // Recorro el arreglo: cada vuelta trabaja con un renglón.
  orden_compra.renglones.forEach(function (renglon) {
    // Creo una fila <tr> en memoria.
    let row = document.createElement("tr")
    // El importe del renglón no se guarda: se calcula (cantidad x precio unitario).
    const importe = renglon.cantidad * renglon.precio_unitario
    // Armo las celdas <td> con los datos del objeto, usando template literals (${...}).
    row.innerHTML = `
    <td dataTabla = 'nro_orden'>${renglon.nro_orden}</td>
    <td dataTabla = 'codigo_producto'>${renglon.codigo_producto}</td>
    <td dataTabla = 'descripcion'>${renglon.descripcion}</td>
    <td dataTabla = 'cantidad'>${renglon.cantidad}</td>
    <td dataTabla = 'unidad_medida'>${renglon.unidad_medida}</td>
    <td dataTabla = 'precio_unitario'>${formatoMoneda(renglon.precio_unitario)}</td>
    <td dataTabla = 'importe_renglon'>${formatoMoneda(importe)}</td>
    <td dataTabla = 'pdf_comprobante'>${renglon.pdf_comprobante}</td>
    `
    // Cuelgo la fila en el <tbody> y recién ahí se ve en pantalla.
    dataTabla.appendChild(row)
  })
})

// Al hacer click en "Vaciar Datos": borro todas las filas del <tbody>.
$('#vaciarDatos').on("click", function() {
  $('#tbody').empty()
  console.log("click")
})

// Al hacer click en "Cargar Formulario": abro el formulario de alta de renglones (esp05) en un modal.
$('#cargarFormulario').on("click", function() {
  $('.modal')[0].showModal()
})

// Al hacer click en la "X": cierro el modal.
$('.btn_cerrar').on("click", function() {
  $('.modal')[0].close()
})
