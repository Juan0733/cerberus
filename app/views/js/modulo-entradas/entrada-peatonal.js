import {registrarEntradaPeatonal} from '../fetchs/movimientos-fetch.js'
import {modalRegistroVisitante} from '../modales/modal-registro-visitante.js';
import {modalRegistroNovedadUsuario} from '../modales/modal-registro-novedad-usuario.js';

let documentoPeaton;
let botonPeatonal;
let botonVehicular;
let formularioPeatonal;
let formularioVehicular;
let botonVolver;
let urlBase;

function eventoAbrirFormularioPeatonal(){
    botonPeatonal.addEventListener("click", ()=>{
        formularioPeatonal.reset();
        if (botonVehicular.style.display == "none") {
            if (window.innerWidth >= 780) {
                botonVehicular.style.display = "flex";
            }
            
            botonPeatonal.style.display = "none";
            formularioPeatonal.style.display = "flex";
            formularioVehicular.style.display = "none";
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
    })
    
}

function eventoInputPeaton() {
    documentoPeaton.addEventListener('change', function() {
        if (documentoPeaton.value.length>15) {
            let documentoFormateado = documentoPeaton.value.replace(/\D/g, '').slice(0, 10);
            documentoPeaton.value = documentoFormateado;
        }
    });
}


function eventoRegistrarEntradaPeatonal() {
    formularioPeatonal.addEventListener('submit', (e)=>{
        e.preventDefault();

        let formData = new FormData(formularioPeatonal);
        formData.append('operacion', 'registrar_entrada_peatonal');

        registrarEntradaPeatonal(formData, urlBase).then(respuesta=>{
            if(respuesta.tipo == "OK" ){
                alertaExito(respuesta);
                formularioPeatonal.reset();
                documentoPeaton.focus();
                
            }else if(respuesta.tipo == "ERROR"){
                if(respuesta.titulo == "Salida No Registrada" || respuesta.titulo == "Usuario No Encontrado"){
                    respuesta.documento = documentoPeaton.value;
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

function eventoCerrarFormularioPeatonal(){
    botonVolver.addEventListener('click', ()=>{
        formularioPeatonal.style.display = 'none';
        formularioVehicular.style.display = 'none';
        botonVolver.style.display = 'none';
        botonPeatonal.style = 'flex';
        botonVehicular.style = 'flex';
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
                modalRegistroNovedadUsuario(urlBase, 'Salida no registrada',  respuesta.documento);
                
            }else if(respuesta.titulo == "Usuario No Encontrado"){
                modalRegistroVisitante(urlBase, respuesta.documento);
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
    formularioVehicular = document.getElementById('formulario_vehicular');
    botonVolver = document.getElementById('btn_volver_peatonal_vehicular');
    eventoAbrirFormularioPeatonal();
    eventoInputPeaton();
    eventoRegistrarEntradaPeatonal();
    eventoCerrarFormularioPeatonal();
});



