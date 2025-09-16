import { consultarMovimiento } from '../fetchs/movimientos-fetch.js';

let contenedorModales;
let modalesExistentes;
let codigoMovimiento;
let botonCerrarModal;
let urlBase;

const contenedorSpinner = document.getElementById('contenedor_spinner');

async function modalDetalleMovimiento(movimiento, url) {
    try {
        contenedorSpinner.classList.add("mostrar_spinner");
        const response = await fetch(url+'app/views/inc/modales/modal-detalle-movimiento.php');

        if(!response.ok) throw new Error('Hubo un error en la solicitud');

        const contenidoModal = await response.text();
        const modal = document.createElement('div');
            
        modal.classList.add('contenedor-ppal-modal');
        modal.id = 'modal_detalle_movimiento';
        modal.innerHTML = contenidoModal;
        contenedorModales = document.getElementById('contenedor_modales');
        
        modalesExistentes = contenedorModales.getElementsByClassName('contenedor-ppal-modal');
        if(modalesExistentes.length > 0){
           for (let i = 0; i < modalesExistentes.length; i++) {
                modalesExistentes[i].remove();
            }
        }

        contenedorModales.appendChild(modal);

        codigoMovimiento = movimiento;
        urlBase = url;
         
        eventoCerrarModal();
        dibujarMovimiento();

    } catch (error) {
        contenedorSpinner.classList.remove("mostrar_spinner");
        
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
export{modalDetalleMovimiento}

function eventoCerrarModal(){
    botonCerrarModal = document.getElementById('cerrar_modal_detalle_movimiento');

    botonCerrarModal.addEventListener('click', ()=>{
        modalesExistentes[modalesExistentes.length-1].remove();
        contenedorModales.classList.remove('mostrar');
    });
}

function dibujarMovimiento() {
    consultarMovimiento(codigoMovimiento, urlBase).then(respuesta=>{
        if(respuesta.tipo == 'OK'){
            const datosMovimiento = respuesta.datos_movimiento;

            document.getElementById('tipo_movimiento').textContent = formatearString(datosMovimiento.tipo_movimiento);
            document.getElementById('fecha_registro').textContent = formatearFecha(datosMovimiento.fecha_registro);
            document.getElementById('usuario').textContent = datosMovimiento.nombres+' '+datosMovimiento.apellidos;
            document.getElementById('tipo_usuario').textContent = formatearString(datosMovimiento.tipo_usuario);
            document.getElementById('puerta_registro').textContent = formatearString(datosMovimiento.puerta_registro);
            document.getElementById('responsable').textContent = formatearString(datosMovimiento.rol_responsable)+' - '+datosMovimiento.nombres_responsable+' '+datosMovimiento.apellidos_responsable;

            if(datosMovimiento.fk_vehiculo != 'N/A'){
                document.getElementById('tipo_vehiculo').textContent = formatearString(datosMovimiento.tipo_vehiculo);
                document.getElementById('placa_vehiculo').textContent = datosMovimiento.fk_vehiculo;
                document.getElementById('relacion_vehiculo').textContent = formatearString(datosMovimiento.relacion_vehiculo);

            }else{
                document.getElementById('caja_tipo_vehiculo').style.display = 'none';
                document.getElementById('caja_placa_vehiculo').style.display = 'none';
                document.getElementById('caja_relacion_vehiculo').style.display = 'none';
            }

            if(datosMovimiento.observacion != 'N/A'){
                document.getElementById('observacion').textContent = datosMovimiento.observacion;
        
            }else{
                document.getElementById('caja_observacion').style.display = 'none';
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