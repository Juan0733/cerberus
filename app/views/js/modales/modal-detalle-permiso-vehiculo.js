import { consultarModalDetallePermisoVehiculo } from '../fetchs/modal-fetch.js';
import { consultarPermisoVehiculo } from '../fetchs/permisos-vehiculos-fetch.js';

let contenedorModales;
let modalesExistentes;
let codigoPermiso;
let botonCerrarModal;
let urlBase;

function modalDetallePermisoVehiculo(permiso, url) {
    consultarModalDetallePermisoVehiculo(url).then(respuesta=>{
        if(respuesta.tipo == 'OK'){
            const contenidoModal = respuesta.modal;
            const modal = document.createElement('div');
                
            modal.classList.add('contenedor-ppal-modal');
            modal.id = 'modal_detalle_permiso_vehiculo';
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
            alertaError(respuesta)
        }
    }) 
}
export{modalDetallePermisoVehiculo}

function eventoCerrarModal(){
    botonCerrarModal = document.getElementById('cerrar_modal_detalle_permiso_vehiculo');

    botonCerrarModal.addEventListener('click', ()=>{
        modalesExistentes[modalesExistentes.length-1].remove();
        contenedorModales.classList.remove('mostrar');
    });
}

function dibujarPermiso() {
    consultarPermisoVehiculo(codigoPermiso, urlBase).then(respuesta=>{
        if(respuesta.tipo == 'OK'){
            const datosPermiso = respuesta.datos_permiso;

            document.getElementById('tipo_permiso').textContent = formatearString(datosPermiso.tipo_permiso);
            document.getElementById('responsable_registro').textContent = formatearString(datosPermiso.rol_registro)+' - '+datosPermiso.nombres_registro+' '+datosPermiso.apellidos_registro;
            document.getElementById('tipo_vehiculo').textContent = formatearString(datosPermiso.tipo_vehiculo);
            document.getElementById('numero_placa').textContent = datosPermiso.fk_vehiculo;
            document.getElementById('propietario').textContent = formatearString(datosPermiso.tipo_propietario)+' - '+datosPermiso.nombres_propietario+' '+datosPermiso.apellidos_propietario;
            document.getElementById('fecha_registro').textContent = formatearFecha(datosPermiso.fecha_registro);
            document.getElementById('estado_permiso').textContent = formatearString(datosPermiso.estado_permiso);
            document.getElementById('fecha_fin_permiso').textContent = formatearFecha(datosPermiso.fecha_fin_permiso);
            document.getElementById('descripcion').textContent = datosPermiso.descripcion;
            
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

