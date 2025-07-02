import { consultarPermisoVehiculo } from '../fetchs/permisos-vehiculos-fetch.js';

let contenedorModales;
let modalesExistentes;
let codigoPermiso;
let botonCerrarModal;
let urlBase;

async function modalDetallePermisoVehiculo(permiso, url) {
    try {
        const response = await fetch(url+'app/views/inc/modales/modal-detalle-permiso-vehiculo.php');

        if(!response.ok) throw new Error('Hubo un error en la solicitud');

        const contenidoModal = await response.text();
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
            console.log(datosPermiso);
            document.getElementById('tipo_permiso').textContent = formatearString(datosPermiso.tipo_permiso);
            document.getElementById('solicitante').textContent = datosPermiso.nombres_solicitante+' '+datosPermiso.apellidos_solicitante;
            document.getElementById('tipo_vehiculo').textContent = formatearString(datosPermiso.tipo_vehiculo);
            document.getElementById('numero_placa').textContent = datosPermiso.fk_vehiculo;
            document.getElementById('propietario').textContent = datosPermiso.nombres_propietario + datosPermiso.apellidos_propietario;
            document.getElementById('fecha_registro').textContent = formatearFecha(datosPermiso.fecha_registro);
            document.getElementById('estado_permiso').textContent = formatearString(datosPermiso.estado_permiso);
            
            document.getElementById('descripcion').textContent = datosPermiso.descripcion;

            if(datosPermiso.tipo_permiso == 'PERMANENCIA'){
                document.getElementById('fecha_fin_permiso').textContent = formatearFecha(datosPermiso.fecha_fin_permiso);
            }else{
                document.getElementById('caja_fecha_fin_permiso').style.display = 'none';
            }

            if(datosPermiso.estado_permiso == 'APROBADO'){
                document.getElementById('fecha_aprobacion').textContent = formatearFecha(datosPermiso.fecatencion);
                document.getElementById('responsable_aprobacion').textContent = datosPermiso.nombres_responsable+' '+datosPermiso.apellidos_responsable;
            }else{
                document.getElementById('caja_fecha_aprobacion').style.display = 'none';
                document.getElementById('caja_responsable_aprobacion').style.display = 'none';
            }
            
            if(datosPermiso.estado_permiso == 'DESAPROBADO'){
                document.getElementById('fecha_desaprobacion').textContent = formatearFecha(datosPermiso.fecha_atencion);
                document.getElementById('responsable_desaprobacion').textContent = datosPermiso.nombres_responsable+' '+datosPermiso.apellidos_responsable;
            }else{
                document.getElementById('caja_fecha_desaprobacion').style.display = 'none';
                document.getElementById('caja_responsable_desaprobacion').style.display = 'none';
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

