import { consultarPuerta, establecerPuerta } from "../fetchs/vigilantes-fetch.js";

let contenedorModales;
let modalesExistentes;
let codigoNovedad;
let botonCerrarModal;
let urlBase;

async function modalSeleccionPuerta(url) {
    try {
        const response = await fetch(url+'app/views/inc/modales/modal-seleccion-puerta.php');

        if(!response.ok) throw new Error('Hubo un error en la solicitud');

        const contenidoModal = await response.text();
        const modal = document.createElement('div');
            
        modal.classList.add('contenedor-ppal-modal');
        modal.id = 'modal_seleccion_puerta';
        modal.innerHTML = contenidoModal;
        contenedorModales = document.getElementById('contenedor_modales');
        
        modalesExistentes = contenedorModales.getElementsByClassName('contenedor-ppal-modal');
        if(modalesExistentes.length > 0){
           for (let i = 0; i < modalesExistentes.length; i++) {
                modalesExistentes[i].remove();
            }
        }

        contenedorModales.appendChild(modal);
        urlBase = url;

        consultarPuertaActual();
         
        contenedorModales.classList.add('mostrar');
    } catch (error) {
        if(botonCerrarModal){
            botonCerrarModal.click();
        }
        
        console.error('Hubo un error:', error);
        alertaError({
            titulo: 'Error Modal',
            mensaje: 'Error al cargar modal seleccion puerta.'
        });
    }
}
export{modalSeleccionPuerta}

function  consultarPuertaActual(params) {
    consultarPuerta(urlBase).then(respuesta=>{
        if(respuesta['tipo'] == 'OK'){
            document.getElementById(respuesta.puerta.toLower()).checked = true;
        }
    })
}

function eventoGuardarPuerta(){
    const formulario = document.getElementById('formulario_puerta');

    formulario.addEventListener('submit', (e)=>{
        e.preventDefault();

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

