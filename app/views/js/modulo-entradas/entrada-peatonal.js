import {registrarEntradaPeatonal} from '../fetchs/movimientos-fetch.js'
import {modalRegistroVisitante} from '../modales/modal-registro-visitante.js';
import {modalRegistroNovedad} from '../modales/modal-registro-novedad.js';

let documentoPeaton;
let formularioPeatonal;
let botonPeatonal;
let botonVehicular;
let urlBase;

function mostrarFormularioPeatonal(){
    if (botonVehicular.style.display == "none") {
        if (window.innerWidth >= 780) {
            botonVehicular.style.display = "flex";
        }
        
        botonPeatonal.style.display = "none";
        formularioPeatonal.style.display = "flex";
        document.getElementById('formulario_vehicular').style.display = "none";
        documentoPeaton.focus();

    }else{
        if (window.innerWidth <= 779) {
            botonVehicular.style.display = "none";
            document.querySelector('.cont-btn-volver').style.display = 'flex';
        }
        
        botonVehicular.style.background = 'red !important';
        botonPeatonal.style.display = "none";
        formularioPeatonal.style.display = "flex";
        documentoPeaton.focus();
    }
}

function eventoBotonPeatonal() {
    botonPeatonal.addEventListener('click', function() {
        mostrarFormularioPeatonal();
    });
}

function eventoInputDocumento() {
    documentoPeaton.addEventListener('change', function() {
        if (documentoPeaton.value.length>15) {
            let documentoFormateado = documentoPeaton.value.replace(/\D/g, '').slice(0, 10);
            documentoPeaton.value = documentoFormateado;
        }
    });
}

function limpiarFormularioPeatonal(){ 
    formularioPeatonal.reset();
    documentoPeaton.focus();
}

function eventoFormularioPeatonal() {
    formularioPeatonal.addEventListener('submit', (e)=>{
        e.preventDefault();

        let formData = new FormData(formularioPeatonal);
        formData.append('operacion', 'registrar_entrada_peatonal');

        registrarEntradaPeatonal(formData, urlBase).then(respuesta=>{
            if(respuesta.tipo == "ERROR" ){
                if(respuesta.titulo == "Salida No Registrada" || respuesta.titulo == "Usuario No Encontrado"){
                    alertaAdvertencia(respuesta);
                }else{
                    alertaError(respuesta);
                }
            }else if(respuesta.tipo == "OK"){
                alertaExito(respuesta);
                limpiarFormularioPeatonal();
            }
        });
    })
}

function alertaExito(respuesta){
    Swal.fire({
        toast: true, 
        position: 'top-end', 
        icon: 'success',
        iconColor: "#2db910",
        color: '#F3F4F4',
        background: '#001629',
        timer: 5000,
        timerProgressBar: true,
        title: respuesta.mensaje,
        showConfirmButton: false,   
        customClass: {
            popup: 'alerta-contenedor',
        }
    })
}

function alertaError(respuesta){
    Swal.fire({
        icon: "error",
        iconColor: "#fe0c0c",
        title: respuesta.titulo,
        text: respuesta.mensaje,
        confirmButtonText: 'Aceptar',
        customClass: {
            popup: 'alerta-contenedor',
            confirmButton: 'btn-confirmar'
        }
    });
}

function alertaAdvertencia(respuesta){
    Swal.fire({
        icon: "warning",
        iconColor: "#feb211",
        title: respuesta.titulo,
        text: respuesta.mensaje,
        showCancelButton: true,
        confirmButtonText: 'Aceptar',
        cancelButtonText: 'Cancelar',
        customClass: {
            popup: 'alerta-contenedor',
            confirmButton: 'btn-confirmar',
            cancelButton: 'btn-cancelar' 
        }
    }).then((result) => {
        if (result.isConfirmed) {
            if(respuesta.titulo == "Salida No Registrada"){
                modalRegistroNovedad('Salida no registrada',  documentoPeaton.value, urlBase);
                
            }else if(respuesta.titulo == "Usuario No Encontrado"){
                modalRegistroVisitante(urlBase, documentoPeaton.value);
            }
        } 
    });
}

document.addEventListener("DOMContentLoaded", function() {
    urlBase = document.getElementById("url_base").value;
    documentoPeaton = document.getElementById("documento_peaton");
    botonPeatonal = document.getElementById("btn_peatonal");
    botonVehicular = document.getElementById("btn_vehicular");
    formularioPeatonal = document.getElementById("formulario_peatonal"); 
    eventoBotonPeatonal();
    eventoFormularioPeatonal();
    eventoInputDocumento();
});



