document.addEventListener("DOMContentLoaded", function () {
    const diaInput = document.getElementById("dia");
    const mesInput = document.getElementById("mes");

    diaInput.addEventListener("keyup", function () {
        const valorDia = parseInt(diaInput.value);
        if (isNaN(valorDia) || valorDia < 1 || valorDia > 31) {
            alert("El día debe ser un valor entre 1 y 31.");
            diaInput.value = "";
        }
    });

    mesInput.addEventListener("keyup", function () {
        const valorMes = parseInt(mesInput.value);
        if (isNaN(valorMes) || valorMes < 1 || valorMes > 12) {
            alert("El mes debe ser un valor entre 1 y 12.");
            mesInput.value = "";
        }
    });

    limpiarButton.addEventListener("click", function () {
        diaInput = ""
        mesInput= ""
    });
});

