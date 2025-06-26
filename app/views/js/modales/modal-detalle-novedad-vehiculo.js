import { consultarNovedadVehiculo} from '../fetchs/novedades-vehiculos-fetch.js';

let contenedorModales;
let modalesExistentes;
let codigoNovedad;
let botonCerrarModal;
let urlBase;

async function modalDetalleNovedadVehiculo(novedad, url) {
    try {
        const response = await fetch(url+'app/views/inc/modales/modal-detalle-novedad-vehiculo.php');

        if(!response.ok) throw new Error('Hubo un error en la solicitud');

        const contenidoModal = await response.text();
        const modal = document.createElement('div');
            
        modal.classList.add('contenedor-ppal-modal');
        modal.id = 'modal_detalle_novedad_vehiculo';
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
        if(botonCerrarModal){
            botonCerrarModal.click();
        }
        
        console.error('Hubo un error:', error);
        alertaError({
            titulo: 'Error Modal',
            mensaje: 'Error al cargar modal detalle novedad vehiculo.'
        });
    }
}
export{modalDetalleNovedadVehiculo}

function eventoCerrarModal(){
    botonCerrarModal = document.getElementById('cerrar_modal_detalle_novedad_vehiculo');

    botonCerrarModal.addEventListener('click', ()=>{
        modalesExistentes[modalesExistentes.length-1].remove();
        contenedorModales.classList.remove('mostrar');
    });
}

function dibujarNovedad() {
    consultarNovedadVehiculo(codigoNovedad, urlBase).then(respuesta=>{
        if(respuesta.tipo == 'OK'){
            const datosNovedad = respuesta.datos_novedad;
            console.log(datosNovedad);
            
            document.getElementById('tipo_novedad').textContent = formatearString(datosNovedad.tipo_novedad);
            document.getElementById('tipo_vehiculo').textContent = formatearString(datosNovedad.tipo_vehiculo);
            document.getElementById('placa_vehiculo').textContent = datosNovedad.fk_vehiculo;
            document.getElementById('involucrado').textContent = datosNovedad.nombres_involucrado+' '+datosNovedad.apellidos_involucrado;
            document.getElementById('propietario_autorizador').textContent = datosNovedad.nombres_autorizador+' '+datosNovedad.apellidos_autorizador;
            document.getElementById('puerta_registro').textContent = formatearString(datosNovedad.puerta_registro);
            document.getElementById('responsable').textContent = datosNovedad.nombres_responsable+' '+datosNovedad.apellidos_responsable;
            document.getElementById('fecha_registro').textContent = formatearFecha(datosNovedad.fecha_registro);
            document.getElementById('descripcion').textContent = datosNovedad.descripcion;
            
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
    const fechaDividida = fecha.split('-');
    const objetoFecha = new Date(parseInt(fechaDividida[0]), parseInt(fechaDividida[1]) - 1, parseInt(fechaDividida[2]));

    const opciones = { day: 'numeric', month: 'long', year: 'numeric' }
    const fechaEspañol = objetoFecha.toLocaleDateString('es-CO', opciones);

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

