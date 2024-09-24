const FormModal = document.querySelector(".modal")
const BtnAbrir = document.querySelector(".btn_abrir")
const BtnCerrar = document.querySelector(".btn_cerrar")

BtnAbrir.addEventListener("click", ()=>{
    FormModal.showModal();
})
BtnCerrar.addEventListener("click", ()=>{
    FormModal.close();
});