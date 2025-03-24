function mostrarCampoCredenciales() {
    var cargo = document.getElementById("cargo_funcionario").value;
    var credencialesContainer = document.getElementById("credencial");

    
    if (cargo === "JV" ) {
        credencialesContainer.removeAttribute('readonly');
        credencialesContainer.setAttribute('required', true);
    } else {
        credencialesContainer.removeAttribute('required');
        credencialesContainer.setAttribute('readonly', true);
        credencialesContainer.value=""
    }
}

document.addEventListener("DOMContentLoaded", function () {
    let pasoActual = 1; // controlamos el paso en el que vamos a iniciar 
    const totalPasos = document.querySelectorAll(".paso").length; // comenzamos a contar el paso a paso para cambiar de vista
    const isMobile = window.innerWidth <= 500; //  con este vamos a verificar que si sea movil la vista en que se este presentando

    function actualizarPasos() {
        document.querySelectorAll(".paso").forEach((paso, index) => {
            paso.classList.remove("activo"); // aqui quitamos el activo a los campos si es web 

            if (!isMobile) { 
                // aqui comenzamos a mostrar los pasos y activarlos
                paso.style.display = "block";
                paso.classList.add("activo");
            } else {
                // aqui si es movil solo s emuestra y activa los pasos para que funcione el formulario
                if (index + 1 === pasoActual) {
                    paso.classList.add("activo");
                    paso.style.display = "block";
                } else {
                    paso.style.display = "none";
                }
            }
        });
        // con este document vamos a manejar la visualizacion de los botnes para la vista
        document.querySelectorAll(".siguiente, .anterior").forEach(boton => {
            boton.style.display = isMobile ? "inline-block" : "none";
        });
    }


    actualizarPasos();

    
    if (isMobile) {
        // aqui esta el boton siguiente para el paso del registro 
        document.querySelectorAll(".siguiente").forEach(boton => {
            boton.addEventListener("click", function () {
                if (pasoActual < totalPasos) {
                    pasoActual++;
                    actualizarPasos();
                }
            });
        });
        // aqui esta el boton anterior
        document.querySelectorAll(".anterior").forEach(boton => {
            boton.addEventListener("click", function () {
                if (pasoActual > 1) {
                    pasoActual--;
                    actualizarPasos();
                }
            });
        });
    }

    // con este miramos si cambiamos de movil a web y va a recargar el formulario
    window.addEventListener('resize', function() {
        const newIsMobile = window.innerWidth <= 500;
        if (newIsMobile !== isMobile) {
            location.reload();
        }
    });
});