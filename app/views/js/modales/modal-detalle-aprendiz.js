import { consultarAprendiz } from '../fetchs/aprendices-fetch.js';

let contenedorModales;
let modalesExistentes;
let documentoAprendiz;
let botonCerrarModal;
let urlBase;

async function modalDetalleAprendiz(aprendiz, url) {
    try {
        const response = await fetch(url+'app/views/inc/modales/modal-detalle-aprendiz.php');

        if(!response.ok) throw new Error('Hubo un error en la solicitud');

        const contenidoModal = await response.text();
        const modal = document.createElement('div');
            
        modal.classList.add('contenedor-ppal-modal');
        modal.id = 'modal_detalle_aprendiz';
        modal.innerHTML = contenidoModal;
        contenedorModales = document.getElementById('contenedor_modales');
        
        modalesExistentes = contenedorModales.getElementsByClassName('contenedor-ppal-modal');
        if(modalesExistentes.length > 0){
           for (let i = 0; i < modalesExistentes.length; i++) {
                modalesExistentes[i].remove();
            }
        }

        contenedorModales.appendChild(modal);

        documentoAprendiz = aprendiz;
        urlBase = url;
         
        eventoCerrarModal();
        dibujarAprendiz();

    } catch (error) {
        if(botonCerrarModal){
            botonCerrarModal.click();
        }
        
        console.error('Hubo un error:', error);
        alertaError({
            titulo: 'Error Modal',
            mensaje: 'Error al cargar modal detalle aprendiz.'
        });
    }
}
export{modalDetalleAprendiz}

function eventoCerrarModal(){
    botonCerrarModal = document.getElementById('cerrar_modal_detalle_aprendiz');

    botonCerrarModal.addEventListener('click', ()=>{
        modalesExistentes[modalesExistentes.length-1].remove();
        contenedorModales.classList.remove('mostrar');
    });
}

function dibujarAprendiz() {
    consultarAprendiz(documentoAprendiz, urlBase).then(respuesta=>{
        if(respuesta.tipo == 'OK'){
            document.getElementById('tipo_documento').textContent = respuesta.datos_aprendiz.tipo_documento
            document.getElementById('numero_documento').textContent = respuesta.datos_aprendiz.numero_documento;
            document.getElementById('nombres').textContent = respuesta.datos_aprendiz.nombres;
            document.getElementById('apellidos').textContent = respuesta.datos_aprendiz.apellidos;
            document.getElementById('telefono').textContent = respuesta.datos_aprendiz.telefono;
            document.getElementById('correo_electronico').textContent = respuesta.datos_aprendiz.correo_electronico;
            document.getElementById('numero_ficha').textContent = respuesta.datos_aprendiz.numero_ficha;
            document.getElementById('nombre_programa').textContent = respuesta.datos_aprendiz.nombre_programa;
            document.getElementById('fecha_fin_ficha').textContent = respuesta.datos_aprendiz.fecha_fin_ficha_formateada;

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

