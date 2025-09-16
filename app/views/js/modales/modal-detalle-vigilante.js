import { consultarVigilante } from '../fetchs/vigilantes-fetch.js';

let contenedorModales;
let modalesExistentes;
let documentoVigilante;
let botonCerrarModal;
let urlBase;

const contenedorSpinner = document.getElementById('contenedor_spinner');

async function modalDetalleVigilante(vigilante, url) {
    try {
        contenedorSpinner.classList.add("mostrar_spinner");
        const response = await fetch(url+'app/views/inc/modales/modal-detalle-vigilante.php');

        if(!response.ok) throw new Error('Hubo un error en la solicitud');

        const contenidoModal = await response.text();
        const modal = document.createElement('div');
            
        modal.classList.add('contenedor-ppal-modal');
        modal.id = 'modal_detalle_vigilante';
        modal.innerHTML = contenidoModal;
        contenedorModales = document.getElementById('contenedor_modales');
        
        modalesExistentes = contenedorModales.getElementsByClassName('contenedor-ppal-modal');
        if(modalesExistentes.length > 0){
           for (let i = 0; i < modalesExistentes.length; i++) {
                modalesExistentes[i].remove();
            }
        }

        contenedorModales.appendChild(modal);

        documentoVigilante = vigilante;
        urlBase = url;
         
        eventoCerrarModal();
        dibujarVigilante();

    } catch (error) {
        contenedorSpinner.classList.remove("mostrar_spinner");
        
        if(botonCerrarModal){
            botonCerrarModal.click();
        }
        
        console.error('Hubo un error:', error);
        alertaError({
            titulo: 'Error Modal',
            mensaje: 'Error al cargar modal detalle vigilante.'
        });
    }
}
export{modalDetalleVigilante}

function eventoCerrarModal(){
    botonCerrarModal = document.getElementById('cerrar_modal_detalle_vigilante');

    botonCerrarModal.addEventListener('click', ()=>{
        modalesExistentes[modalesExistentes.length-1].remove();
        contenedorModales.classList.remove('mostrar');
    });
}

function dibujarVigilante() {
    consultarVigilante(documentoVigilante, urlBase).then(respuesta=>{
        if(respuesta.tipo == 'OK'){
            const datosVigilante = respuesta.datos_vigilante;
            document.getElementById('tipo_documento').textContent = datosVigilante.tipo_documento
            document.getElementById('numero_documento').textContent = datosVigilante.numero_documento;
            document.getElementById('nombres').textContent = datosVigilante.nombres;
            document.getElementById('apellidos').textContent = datosVigilante.apellidos;
            document.getElementById('telefono').textContent = formatearNumeroTelefono(datosVigilante.telefono);
            document.getElementById('correo_electronico').textContent = datosVigilante.correo_electronico;
            document.getElementById('rol').textContent = formatearString(datosVigilante.rol);

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

function formatearString(cadena) { 
    cadena = cadena.toLowerCase();
    cadena = cadena.charAt(0).toUpperCase() + cadena.slice(1);
    return cadena; 
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

