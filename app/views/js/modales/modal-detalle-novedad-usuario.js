import { consultarNovedadUsuario } from '../fetchs/novedades-usuarios-fetch.js';

let contenedorModales;
let modalesExistentes;
let codigoNovedad;
let botonCerrarModal;
let urlBase;

const contenedorSpinner = document.getElementById('contenedor_spinner');

async function modalDetalleNovedadUsuario(novedad, url) {
    try {
        contenedorSpinner.classList.add("mostrar_spinner");
        const response = await fetch(url+'app/views/inc/modales/modal-detalle-novedad-usuario.php');

        if(!response.ok) throw new Error('Hubo un error en la solicitud');

        const contenidoModal = await response.text();
        const modal = document.createElement('div');
            
        modal.classList.add('contenedor-ppal-modal');
        modal.id = 'modal_detalle_novedad_usuario';
        modal.innerHTML = contenidoModal;
        contenedorModales = document.getElementById('contenedor_modales');
        
        modalesExistentes = contenedorModales.getElementsByClassName('contenedor-ppal-modal');
        if(modalesExistentes.length > 0){
           for (let i = 0; i < modalesExistentes.length; i++) {
                modalesExistentes[i].remove();
            }
        }

        contenedorModales.appendChild(modal);

        codigoNovedad = novedad;
        urlBase = url;
         
        eventoCerrarModal();
        dibujarNovedad();

    } catch (error) {
        contenedorSpinner.classList.remove("mostrar_spinner");
        
        if(botonCerrarModal){
            botonCerrarModal.click();
        }
        
        console.error('Hubo un error:', error);
        alertaError({
            titulo: 'Error Modal',
            mensaje: 'Error al cargar modal detalle novedad usuario.'
        });
    }
}
export{modalDetalleNovedadUsuario}

function eventoCerrarModal(){
    botonCerrarModal = document.getElementById('cerrar_modal_detalle_novedad_usuario');

    botonCerrarModal.addEventListener('click', ()=>{
        modalesExistentes[modalesExistentes.length-1].remove();
        contenedorModales.classList.remove('mostrar');
    });
}

function dibujarNovedad() {
    consultarNovedadUsuario(codigoNovedad, urlBase).then(respuesta=>{
        if(respuesta.tipo == 'OK'){
            const datosNovedad = respuesta.datos_novedad;
            console.log(datosNovedad);
            
            document.getElementById('tipo_novedad').textContent = formatearString(datosNovedad.tipo_novedad);
            document.getElementById('puerta_suceso').textContent = formatearString(datosNovedad.puerta_suceso);
            document.getElementById('puerta_registro').textContent = formatearString(datosNovedad.puerta_registro);
            document.getElementById('involucrado').textContent = datosNovedad.nombres_involucrado+' '+datosNovedad.apellidos_involucrado;
            document.getElementById('responsable').textContent = datosNovedad.nombres_responsable+' '+datosNovedad.apellidos_responsable;
            document.getElementById('fecha_suceso').textContent = formatearFecha(datosNovedad.fecha_suceso);
            document.getElementById('fecha_registro').textContent = formatearFecha(datosNovedad.fecha_registro);
            document.getElementById('descripcion').textContent = datosNovedad.descripcion;
            
            contenedorSpinner.classList.remove("mostrar_spinner");
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

function formatearFecha(fecha){
    const objetoFecha = new Date(fecha);

    const opciones = { day: 'numeric', month: 'long', year: 'numeric', hour: 'numeric', minute: '2-digit', hour12: true };
    const fechaEspañol = objetoFecha.toLocaleTimeString('es-CO', opciones);

    return fechaEspañol;
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

