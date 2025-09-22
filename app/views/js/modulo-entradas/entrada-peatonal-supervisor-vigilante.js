import {registrarEntradaPeatonal} from '../fetchs/movimientos-fetch.js'
import {modalRegistroVisitante} from '../modales/modal-registro-visitante.js';
import {modalRegistroNovedadUsuario} from '../modales/modal-registro-novedad-usuario.js';
import {modalScanerQr} from '../modales/modal-scaner-qr.js';

let documentoPeaton;
let formularioPeatonal;
let urlBase;


function eventoRegistrarEntradaPeatonal() {
    formularioPeatonal.addEventListener('submit', (e)=>{
        e.preventDefault();

        let formData = new FormData(formularioPeatonal);
        formData.append('operacion', 'registrar_entrada_peatonal');

        registrarEntradaPeatonal(formData, urlBase).then(respuesta=>{
            if(respuesta.tipo == "OK" ){
                alertaExito(respuesta);
                formularioPeatonal.reset();

                setTimeout(()=>{
                    documentoPeaton.focus();
                }, 1000)
                
            }else if(respuesta.tipo == "ERROR"){
                if(respuesta.titulo == "Salida No Registrada" || respuesta.titulo == "Usuario No Encontrado" || respuesta.titulo == 'Ficha Caducada' || respuesta.titulo == 'Contrato Caducado'){
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

function eventoManualFormularioPeatonal(){
    const evento = new Event("submit", { bubbles: true, cancelable: true });
    formularioPeatonal.dispatchEvent(evento);
}

function eventoScanerQrPeaton(){
    document.getElementById('btn_scaner_qr_peaton').addEventListener('click', ()=>{
        modalScanerQr(urlBase, documentoPeaton, eventoManualFormularioPeatonal);
    })
}

function eventoTextArea(){
    const observacion = document.getElementById('observacion_peatonal');
    const patron = /^[A-Za-zñÑáéíóúÁÉÍÓÚüÜ0-9., ]{0,150}$/;

    observacion.addEventListener('keyup', ()=>{
        observacion.setCustomValidity("");
            
        if (!patron.test(observacion.value)){
            observacion.setCustomValidity("Debes digitar solo números y letras, máximo 100 caracteres");
            observacion.reportValidity();
                
        }
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
            if(respuesta.titulo == "Salida No Registrada"){
                modalRegistroNovedadUsuario(urlBase, 'SALIDA NO REGISTRADA',  respuesta.documento, respuesta.callback);
                
            }else if(respuesta.titulo == "Usuario No Encontrado"){
                modalRegistroVisitante(urlBase, respuesta.documento, respuesta.callback);

            }else if(respuesta.titulo == 'Ficha Caducada' || respuesta.titulo == 'Contrato Caducado'){
                modalRegistroVisitante(urlBase, '', respuesta.callback, respuesta.datos_usuario)
            }
        } 
    });
}

document.addEventListener("DOMContentLoaded", function() {
    urlBase = document.getElementById("url_base").value;
    documentoPeaton = document.getElementById("documento_peaton");
    formularioPeatonal = document.getElementById("formulario_peatonal"); 
    
    eventoTextArea();
    eventoRegistrarEntradaPeatonal();
    eventoScanerQrPeaton();
});



