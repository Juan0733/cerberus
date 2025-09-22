import { consultarModalDetalleVisitante } from '../fetchs/modal-fetch.js';
import { consultarVisitante } from '../fetchs/visitantes-fetch.js';

let contenedorModales;
let modalesExistentes;
let documentoVisitante;
let botonCerrarModal;
let urlBase;

function modalDetalleVisitante(visitante, url) {
    consultarModalDetalleVisitante(url).then(respuesta=>{
        if(respuesta.tipo == 'OK'){
            const contenidoModal = respuesta.modal;
            const modal = document.createElement('div');
                
            modal.classList.add('contenedor-ppal-modal');
            modal.id = 'modal_detalle_visitante';
            modal.innerHTML = contenidoModal;
            contenedorModales = document.getElementById('contenedor_modales');
            
            modalesExistentes = contenedorModales.getElementsByClassName('contenedor-ppal-modal');
            if(modalesExistentes.length > 0){
            for (let i = 0; i < modalesExistentes.length; i++) {
                    modalesExistentes[i].remove();
                }
            }

            contenedorModales.appendChild(modal);

            documentoVisitante = visitante;
            urlBase = url;
            
            eventoCerrarModal();
            dibujarVisitante();
        
        }else if(respuesta.tipo == 'ERROR'){
            alertaError(respuesta);
        }
    })
}
export{modalDetalleVisitante}

function eventoCerrarModal(){
    botonCerrarModal = document.getElementById('cerrar_modal_detalle_visitante');

    botonCerrarModal.addEventListener('click', ()=>{
        modalesExistentes[modalesExistentes.length-1].remove();
        contenedorModales.classList.remove('mostrar');
    });
}

function dibujarVisitante() {
    consultarVisitante(documentoVisitante, urlBase).then(respuesta=>{
        if(respuesta.tipo == 'OK'){
            const datosVisitante = respuesta.datos_visitante;
            document.getElementById('tipo_documento').textContent = datosVisitante.tipo_documento
            document.getElementById('numero_documento').textContent = datosVisitante.numero_documento;
            document.getElementById('nombres').textContent = datosVisitante.nombres;
            document.getElementById('apellidos').textContent = datosVisitante.apellidos;
            document.getElementById('telefono').textContent = formatearNumeroTelefono(datosVisitante.telefono);
            document.getElementById('correo_electronico').textContent = datosVisitante.correo_electronico;
            document.getElementById('motivo_ingreso').textContent = datosVisitante.motivo_ingreso;

            if(datosVisitante.nombres_responsable != 'N/A'){
                document.getElementById('responsable_registro').textContent = formatearString(datosVisitante.rol_responsable)+' -  '+datosVisitante.nombres_responsable+' '+datosVisitante.apellidos_responsable;

            }else{
                document.getElementById('caja_responsable_registro').style.display = 'none';
            }

            contenedorModales.classList.add('mostrar');

        }else if(respuesta.tipo == 'ERROR'){
            if(respuesta.titulo == 'Sesión Expirada'){
                window.location.replace(urlBase+'sesion-expirada');

            }else{
                botonCerrarModal.click();
                alertaError(respuesta);
                
            }
        }
    })
}

function formatearNumeroTelefono(numeroTelefono){
    let telefonoFormateado = '';

    for (let i = 0; i < numeroTelefono.length; i++) {
        telefonoFormateado += numeroTelefono[i];
        if(i == 2 || i == 5 || i == 7 ){
            telefonoFormateado += '-';
        }
    }

    return telefonoFormateado;
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

