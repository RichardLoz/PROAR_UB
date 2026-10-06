// Referencias: el <dialog> y sus botones de abrir / cerrar.
const FormModal = document.querySelector(".modal")
const BtnAbrir = document.querySelector(".btn_abrir")
const BtnCerrar = document.querySelector(".btn_cerrar")

// showModal() muestra el <dialog> como ventana modal (bloquea el resto de la página).
BtnAbrir.addEventListener("click", ()=>{
    FormModal.showModal();
})
// close() cierra el <dialog>.
BtnCerrar.addEventListener("click", ()=>{
    FormModal.close();
});
