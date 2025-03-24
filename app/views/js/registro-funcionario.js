function mostrarCampoCredenciales() {
    var cargo = document.getElementById("cargo_funcionario").value;
    var credencialesContainer = document.getElementById("credenciales_funcionario");

    
    if (cargo === "SB" || cargo === "CO") {
        credencialesContainer.removeAttribute('readonly');
        credencialesContainer.setAttribute('required', true);
    } else {
        credencialesContainer.removeAttribute('required');
        credencialesContainer.setAttribute('readonly', true);
        credencialesContainer.value=""
    }

}
function mostrarCampoFecha() {

    var tipo_contrato_funcionario = document.getElementById("tipo_contrato_funcionario").value;
    var fecha_finalizacion_contrato = document.getElementById("fecha_finalizacion_contrato");

    if (tipo_contrato_funcionario === "CT") {
        fecha_finalizacion_contrato.removeAttribute('readonly');
        fecha_finalizacion_contrato.setAttribute('required', true);
    } else {
        fecha_finalizacion_contrato.removeAttribute('required');
        fecha_finalizacion_contrato.setAttribute('readonly', true);
        fecha_finalizacion_contrato.value=""
        }
}

// Funciones para el registro de funcionario cambie a movil.
document.addEventListener('DOMContentLoaded', ()=> {
    let btn_continuar = document.getElementById('btn_continuar_1')
    let btn_continuar_2 = document.getElementById('btn_continuar_2')
    let grupo_1 = document.getElementById('grupo_1')
    let grupo_2 = document.getElementById('grupo_2')
    let grupo_3  = document.getElementById('grupo_3')
    let btn_anterior = document.getElementById('btn_anterior')
    let btn_anterior_2 = document.getElementById('btn_anterior_2')

    btn_continuar.addEventListener('click', ()=>{
        const inputs = grupo_1.querySelectorAll('input, select');
        let valido = true;
        inputs.forEach(input => {
            if (!input.checkValidity()) { // verificamos que los campos no esten vacios
                input.reportValidity(); // aqui reportamos cual es el campos que hqce falta por llenar
                valido = false
            }
        });
        if (valido) {
            grupo_1.style.display = "none";
            grupo_2.style.display = "block";
            grupo_3.style.display = "none";
        }
    })

    btn_continuar_2.addEventListener('click', ()=>{
        const inputs = grupo_2.querySelectorAll('input, select');
        let valido = true;
        inputs.forEach(input => {
            if (!input.checkValidity()) { // verificamos que los campos no esten vacios
                input.reportValidity(); // aqui reportamos cual es el campos que hqce falta por llenar
                valido = false
            }
        });
        if (valido) {
            grupo_2.style.display = "none";
            grupo_3.style.display = "block";
        }
    })

    btn_anterior.addEventListener('click', ()=>{
        grupo_2.style.display = "none";
        grupo_1.style.display = "block";
        grupo_3.style.display = "none";
        
    })

    btn_anterior_2.addEventListener('click', ()=>{
        grupo_3.style.display = "none";
        grupo_2.style.display = "block";
    })

    window.addEventListener('resize', function() {
        if (this.window.innerWidth > 767) {
            grupo_1.style.display = "block";
            grupo_2.style.display = "block";
            grupo_3.style.display = "block";
        } else {
            grupo_1.style.display = "block";
            grupo_2.style.display = "none";
            grupo_3.style.display = "none";
        }
    })
})

// document.addEventListener("DOMContentLoaded", function () {
//     let pasoActual = 1; // controlamos el paso en el que vamos a iniciar 
//     const totalPasos = document.querySelectorAll(".paso").length; // comenzamos a contar el paso a paso para cambiar de vista
//     const isMobile = window.innerWidth <= 500; //  con este vamos a verificar que si sea movil la vista en que se este presentando

//     function actualizarPasos() {
//         document.querySelectorAll(".paso").forEach((paso, index) => {
//             paso.classList.remove("activo"); // aqui quitamos el activo a los campos si es web 

//             if (!isMobile) { 
//                 // aqui comenzamos a mostrar los pasos y activarlos
//                 paso.style.display = "block";
//                 paso.classList.add("activo");
//             } else {
//                 // aqui si es movil solo s emuestra y activa los pasos para que funcione el formulario
//                 if (index + 1 === pasoActual) {
//                     paso.classList.add("activo");
//                     paso.style.display = "block";
//                 } else {
//                     paso.style.display = "none";
//                 }
//             }
//         });
//         // con este document vamos a manejar la visualizacion de los botnes para la vista
//         document.querySelectorAll(".siguiente, .anterior").forEach(boton => {
//             boton.style.display = isMobile ? "inline-block" : "none";
//         });
//     }


//     actualizarPasos();

    
//     if (isMobile) {
//         // aqui esta el boton siguiente para el paso del registro 
//         document.querySelectorAll(".siguiente").forEach(boton => {
//             boton.addEventListener("click", function () {
//                 if (pasoActual < totalPasos) {
//                     pasoActual++;
//                     actualizarPasos();
//                 }
//             });
//         });
//         // aqui esta el boton anterior
//         document.querySelectorAll(".anterior").forEach(boton => {
//             boton.addEventListener("click", function () {
//                 if (pasoActual > 1) {
//                     pasoActual--;
//                     actualizarPasos();
//                 }
//             });
//         });
//     }

//     // con este miramos si cambiamos de movil a web y va a recargar el formulario
//     window.addEventListener('resize', function() {
//         const newIsMobile = window.innerWidth <= 500;
//         if (newIsMobile !== isMobile) {
//             location.reload();
//         }
//     });
// });