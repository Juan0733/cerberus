import { consultarVisitante } from '../fetchs/visitantes-fetch.js';

let contenedorModales;
let modalesExistentes;
let documentoVisitante;
let botonCerrarModal;
let urlBase;

async function modalDetalleVisitante(visitante, url) {
    try {
        const response = await fetch(url+'app/views/inc/modales/modal-detalle-visitante.php');

        if(!response.ok) throw new Error('Hubo un error en la solicitud');

        const contenidoModal = await response.text();
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

    } catch (error) {
        if(botonCerrarModal){
            botonCerrarModal.click();
        }
        
        console.error('Hubo un error:', error);
        alertaError({
            titulo: 'Error Modal',
            mensaje: 'Error al cargar modal detalle visitante.'
        });
    }
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
            document.getElementById('tipo_documento').textContent = respuesta.datos_visitante.tipo_documento
            document.getElementById('numero_documento').textContent = respuesta.datos_visitante.numero_documento;
            document.getElementById('nombres').textContent = respuesta.datos_visitante.nombres;
            document.getElementById('apellidos').textContent = respuesta.datos_visitante.apellidos;
            document.getElementById('telefono').textContent = respuesta.datos_visitante.telefono;
            document.getElementById('correo_electronico').textContent = respuesta.datos_visitante.correo_electronico;
            document.getElementById('motivo_ingreso').textContent = respuesta.datos_visitante.motivo_ingreso;

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

