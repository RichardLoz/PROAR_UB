const nombre = document.getElementById('nombre');
const apellido = document.getElementById('apellido');
const numero = document.getElementById('numero');
const alta = document.getElementById('alta');
const baja = document.getElementById('baja');
const modificar = document.getElementById('modificar');

window.onload=()=>{
    alta.disabled=true;
    baja.disabled=true;
    modificar.disabled=true;
}
const habilitado = () => {
    if((nombre.value && apellido.value && numero.value) !== ""){
        alta.disabled=false;
        baja.disabled=false;
        modificar.disabled=false;
    }
}