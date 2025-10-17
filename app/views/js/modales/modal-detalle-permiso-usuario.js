import { consultarModalDetallePermisoUsuario } from '../fetchs/modales-fetch.js';
import { consultarPermisoUsuario } from '../fetchs/permisos-usuarios-fetch.js';

let contenedorModales;
let modalesExistentes;
let codigoPermiso;
let botonCerrarModal;
let urlBase;

function modalDetallePermisoUsuario(permiso, url) {
    consultarModalDetallePermisoUsuario(url).then(respuesta=>{
        if(respuesta.tipo == 'OK'){
            const contenidoModal = respuesta.modal;
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

        }else if(respuesta.tipo == 'ERROR'){
            alertaError(respuesta);
        }
    }) 
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

            if(datosPermiso.tipo_permiso == 'PERMANENCIA' ){
                document.getElementById('responsable_registro').textContent = formatearString(datosPermiso.rol_registro)+' - '+datosPermiso.nombres_registro+' '+datosPermiso.apellidos_registro;
                document.getElementById('fecha_registro').textContent = formatearFecha(datosPermiso.fecha_registro);

            }else if(datosPermiso.tipo_permiso == 'SALIDA'){
                document.getElementById('caja_responsable_registro').style.display = 'none';
                document.getElementById('caja_fecha_registro').style.display = 'none';
            }

            document.getElementById('tipo_permiso').textContent = formatearString(datosPermiso.tipo_permiso);
            document.getElementById('autorizado').textContent = formatearString(datosPermiso.tipo_autorizado)+' - '+datosPermiso.nombres_autorizado+' '+datosPermiso.apellidos_autorizado;
            document.getElementById('estado_permiso').textContent = formatearString(datosPermiso.estado_permiso);
            document.getElementById('descripcion').textContent = datosPermiso.descripcion;
            document.getElementById('fecha_fin_permiso').textContent = formatearFecha(datosPermiso.fecha_fin_permiso);

            if(datosPermiso.fecha_autorizacion == 'N/A'){
                document.getElementById('fecha_autorizacion').textContent = datosPermiso.fecha_autorizacion;
                document.getElementById('responsable_autorizacion').textContent = datosPermiso.nombres_autorizacion;

            }else{
                document.getElementById('fecha_autorizacion').textContent = formatearFecha(datosPermiso.fecha_autorizacion);
                document.getElementById('responsable_autorizacion').textContent = formatearString(datosPermiso.rol_autorizacion)+' - '+datosPermiso.nombres_autorizacion+' '+datosPermiso.apellidos_autorizacion;
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

