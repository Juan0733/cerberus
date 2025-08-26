import {registrarSalidaPeatonal} from '../fetchs/movimientos-fetch.js'
import {modalRegistroVisitante} from '../modales/modal-registro-visitante.js';
import {modalRegistroNovedadUsuario} from '../modales/modal-registro-novedad-usuario.js';
import { modalScanerQr } from '../modales/modal-scaner-qr.js';
import { modalSeleccionPuerta } from '../modales/modal-seleccion-puerta.js';

let documentoPeaton;
let formularioPeatonal;
let observacion;
let urlBase;

function eventoAbrirFormularioPeatonal(){
    const formularioVehicular = document.getElementById('formulario_vehicular');
    const contenedorBotonVolver = document.getElementById('contenedor_btn_volver');
    const botonPeatonal = document.getElementById("btn_peatonal");
    const botonVehicular = document.getElementById("btn_vehicular");

    botonPeatonal.addEventListener("click", ()=>{
        formularioPeatonal.reset();

        if(window.innerWidth > 1023){
            if (formularioVehicular.style.display == "flex") {
                formularioVehicular.style.display = "none"
                botonVehicular.style.display = 'flex';
            }

            botonPeatonal.style.display = "none"
            formularioPeatonal.style.display = "flex"
            documentoPeaton.focus();

        }else{
            botonVehicular.style.display = "none";
            botonPeatonal.style.display = "none";
            contenedorBotonVolver.style.display = 'flex';
            formularioPeatonal.style.display = "flex"
            documentoPeaton.focus();
        }
    })
    
}

function eventoRegistrarSalidaPeatonal() {
    formularioPeatonal.addEventListener('submit', (e)=>{
        e.preventDefault();

        if(!observacion.reportValidity()){
            return;
        }

        let formData = new FormData(formularioPeatonal);
        formData.append('operacion', 'registrar_salida_peatonal');

        registrarSalidaPeatonal(formData, urlBase).then(respuesta=>{
            if(respuesta.tipo == "OK"){
                alertaExito(respuesta);
                formularioPeatonal.reset();

                setTimeout(()=>{
                    documentoPeaton.focus();
                }, 1000)
                
            }else if(respuesta.tipo == "ERROR"){
                if(respuesta.titulo == "Entrada No Registrada" || respuesta.titulo == "Usuario No Encontrado"){
                    respuesta.documento = documentoPeaton.value;
                    respuesta.callback = eventoManualFormularioPeatonal;
                    alertaAdvertencia(respuesta);

                }else if(respuesta.titulo == 'Sesión Expirada'){
                    window.location.replace(urlBase+'sesion-expirada');

                }else{
                    alertaError(respuesta);
                }
            }
        });
    })
}

function eventoTextArea(){
    let temporizador;
    let primeraValidacion = true;

    observacion.addEventListener('keyup', ()=>{
        clearTimeout(temporizador);
        temporizador = setTimeout(()=>{
            let patron = /^[A-Za-zñÑáéíóúÁÉÍÓÚüÜ0-9., ]{0,100}$/;
    
            if (!patron.test(observacion.value)){

                if(primeraValidacion){
                    observacion.setCustomValidity("Debes digitar solo números y letras, máximo 100 caracteres");
                    observacion.reportValidity();
                    primeraValidacion = false;
                }

            } else {
                observacion.setCustomValidity(""); 
                primeraValidacion = true;
            }
        }, 1000);
    })
}

function eventoManualFormularioPeatonal(){
    const evento = new Event("submit", { bubbles: true, cancelable: true });
    formularioPeatonal.dispatchEvent(evento);
}

function eventoScanerQrPeaton(){
    document.getElementById('btn_scaner_qr_peaton').addEventListener('click', ()=>{
        modalScanerQr(urlBase, documentoPeaton, eventoManualFormularioPeatonal);
    })
}

function alertaExito(respuesta){
    Swal.fire({
        toast: true, 
        position: 'bottom-end', 
        icon: 'success',
        iconColor: "#2db910",
        color: '#F3F4F4',
        background: '#001629',
        timer: 5000,
        timerProgressBar: true,
        title: respuesta.mensaje,
        showConfirmButton: false,   
        customClass: {
            popup: 'alerta-contenedor exito',
        },
        didOpen: (toast) => {
            toast.addEventListener('click', () => {
                Swal.close();
            });
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
            if(respuesta.titulo == "Entrada No Registrada"){
                modalRegistroNovedadUsuario(urlBase, 'ENTRADA NO REGISTRADA',  respuesta.documento, respuesta.callback);
                
            }else if(respuesta.titulo == "Usuario No Encontrado"){
                modalRegistroVisitante(urlBase, respuesta.documento, respuesta.callback);
            }
        } 
    });
}

document.addEventListener("DOMContentLoaded", function() {
    urlBase = document.getElementById("url_base").value;
    documentoPeaton = document.getElementById("documento_peaton");
    formularioPeatonal = document.getElementById("formulario_peatonal"); 
    observacion = document.getElementById('observacion_peatonal');

    eventoAbrirFormularioPeatonal();
    eventoTextArea();
    eventoRegistrarSalidaPeatonal();
    eventoScanerQrPeaton();

    if(document.getElementById('puerta')){
        modalSeleccionPuerta(urlBase);
    }
});



