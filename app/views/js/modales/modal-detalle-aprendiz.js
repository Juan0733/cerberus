import { consultarAprendiz } from '../fetchs/aprendices-fetch.js';

let contenedorModales;
let modalesExistentes;
let documentoAprendiz;
let botonCerrarModal;
let urlBase;

const contenedorSpinner = document.getElementById('contenedor_spinner');

async function modalDetalleAprendiz(aprendiz, url) {
    try {
        contenedorSpinner.classList.add("mostrar_spinner");
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
        contenedorSpinner.classList.remove("mostrar_spinner");
        
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
            const datosAprendiz = respuesta.datos_aprendiz;
            document.getElementById('tipo_documento').textContent = datosAprendiz.tipo_documento
            document.getElementById('numero_documento').textContent = datosAprendiz.numero_documento;
            document.getElementById('nombres').textContent = datosAprendiz.nombres;
            document.getElementById('apellidos').textContent = datosAprendiz.apellidos;
            document.getElementById('telefono').textContent = formatearNumeroTelefono(datosAprendiz.telefono);
            document.getElementById('correo_electronico').textContent = datosAprendiz.correo_electronico;
            document.getElementById('numero_ficha').textContent = datosAprendiz.numero_ficha;
            document.getElementById('nombre_programa').textContent = datosAprendiz.nombre_programa;
            document.getElementById('fecha_fin_ficha').textContent = formatearFecha(datosAprendiz.fecha_fin_ficha);

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

function formatearFecha(fecha){
    const fechaDividida = fecha.split('-');
    const objetoFecha = new Date(parseInt(fechaDividida[0]), parseInt(fechaDividida[1]) - 1, parseInt(fechaDividida[2]));

    const opciones = { day: 'numeric', month: 'long', year: 'numeric' }
    const fechaEspañol = objetoFecha.toLocaleDateString('es-CO', opciones);

    return fechaEspañol;
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

