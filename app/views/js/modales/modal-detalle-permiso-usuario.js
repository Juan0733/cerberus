import { consultarPermisoUsuario } from '../fetchs/permisos-usuarios-fetch.js';

let contenedorModales;
let modalesExistentes;
let codigoPermiso;
let botonCerrarModal;
let urlBase;

async function modalDetallePermisoUsuario(permiso, url) {
    try {
        const response = await fetch(url+'app/views/inc/modales/modal-detalle-permiso-usuario.php');

        if(!response.ok) throw new Error('Hubo un error en la solicitud');

        const contenidoModal = await response.text();
        const modal = document.createElement('div');
            
        modal.classList.add('contenedor-ppal-modal');
        modal.id = 'modal_detalle_permiso_usuario';
        modal.innerHTML = contenidoModal;
        contenedorModales = document.getElementById('contenedor_modales');
        
        modalesExistentes = contenedorModales.getElementsByClassName('contenedor-ppal-modal');
        if(modalesExistentes.length > 0){
           for (let i = 0; i < modalesExistentes.length; i++) {
                modalesExistentes[i].remove();
            }
        }

        contenedorModales.appendChild(modal);

        codigoPermiso = permiso;
        urlBase = url;
         
        eventoCerrarModal();
        dibujarPermiso();

    } catch (error) {
        if(botonCerrarModal){
            botonCerrarModal.click();
        }
        
        console.error('Hubo un error:', error);
        alertaError({
            titulo: 'Error Modal',
            mensaje: 'Error al cargar modal detalle permiso usuario.'
        });
    }
}
export{modalDetallePermisoUsuario}

function eventoCerrarModal(){
    botonCerrarModal = document.getElementById('cerrar_modal_detalle_permiso_usuario');

    botonCerrarModal.addEventListener('click', ()=>{
        modalesExistentes[modalesExistentes.length-1].remove();
        contenedorModales.classList.remove('mostrar');
    });
}

function dibujarPermiso() {
    consultarPermisoUsuario(codigoPermiso, urlBase).then(respuesta=>{
        if(respuesta.tipo == 'OK'){
            const datosPermiso = respuesta.datos_permiso;

            document.getElementById('tipo_permiso').textContent = formatearString(datosPermiso.tipo_permiso);
            document.getElementById('solicitante').textContent = datosPermiso.nombres_solicitante+' '+datosPermiso.apellidos_solicitante;
            document.getElementById('fecha_registro').textContent = formatearFecha(datosPermiso.fecha_registro);
            document.getElementById('fecha_fin_permiso').textContent = datosPermiso.tipo_permiso == 'PERMANENCIA' ? formatearFecha(datosPermiso.fecha_fin_permiso) : datosPermiso.fecha_fin_permiso;
            document.getElementById('fecha_aprobacion').textContent = datosPermiso.fecha_aprobacion != 'N/A' ? formatearFecha(datosPermiso.fecha_aprobacion) : datosPermiso.fecha_aprobacion;
            document.getElementById('fecha_desaprobacion').textContent = datosPermiso.fecha_desaprobacion != 'N/A' ? formatearFecha(datosPermiso.fecha_desaprobacion) : datosPermiso.fecha_desaprobacion;
            document.getElementById('estado_permiso').textContent = formatearString(datosPermiso.estado_permiso);
            document.getElementById('responsable').textContent = datosPermiso.nombres_responsable+' '+datosPermiso.apellidos_responsable;
            document.getElementById('descripcion').textContent = datosPermiso.descripcion;
            
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
    const objetoFecha = new Date(fecha.replace(' ', 'T'));

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

