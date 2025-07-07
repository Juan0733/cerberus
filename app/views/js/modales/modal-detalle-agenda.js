import {consultarAgenda} from '../fetchs/agenda-fetch.js';

let contenedorModales;
let modalesExistentes;
let codigoAgenda;
let botonCerrarModal;
let urlBase;

const contenedorSpinner = document.getElementById('contenedor_spinner');

async function modalDetalleAgenda(codigo, url) {
    try {
        contenedorSpinner.classList.add("mostrar_spinner");
        const response = await fetch(url+'app/views/inc/modales/modal-detalle-agenda.php');

        if(!response.ok) throw new Error('Hubo un error en la solicitud');

        const contenidoModal = await response.text();
        const modal = document.createElement('div');
            
        modal.classList.add('contenedor-ppal-modal');
        modal.id = 'modal_detalle_agenda';
        modal.innerHTML = contenidoModal;
        contenedorModales = document.getElementById('contenedor_modales');

        modalesExistentes = contenedorModales.getElementsByClassName('contenedor-ppal-modal');
        if(modalesExistentes.length > 0){
           for (let i = 0; i < modalesExistentes.length; i++) {
                modalesExistentes[i].remove();
            }
        }

        contenedorModales.appendChild(modal);

        codigoAgenda = codigo;
        urlBase = url;
         
        eventoCerrarModal();
        dibujarAgenda(codigo);

    } catch (error) {
        contenedorSpinner.classList.remove("mostrar_spinner");
        
        if(botonCerrarModal){
            botonCerrarModal.click();
        }
        
        console.error('Hubo un error:', error);
        alertaError({
            titulo: 'Error Modal',
            mensaje: 'Error al cargar modal  detalle agenda.'
        });
    }
}
export{modalDetalleAgenda}

function eventoCerrarModal(){
    botonCerrarModal = document.getElementById('cerrar_modal_detalle_agenda');
    
    botonCerrarModal.addEventListener('click', ()=>{
        modalesExistentes[modalesExistentes.length-1].remove();
        contenedorModales.classList.remove('mostrar');
    });
}

function dibujarAgenda() {
    consultarAgenda(codigoAgenda, urlBase).then(respuesta=>{
        if(respuesta.tipo == 'OK'){
            const datosAgenda = respuesta.datos_agenda;
            document.getElementById('titulo').textContent = datosAgenda.titulo;
            
            const cuerpoTablaAgendados = document.getElementById('cuerpo_tabla_agendados');
        
            datosAgenda.agendados.forEach((agendado, indice) => {
                cuerpoTablaAgendados.innerHTML += `
                    <tr>
                        <td>${indice+1}</td>
                        <td>${agendado.nombres}</td>
                        <td>${agendado.apellidos}</td>
                    </tr>`
            });

            const fecha = formatearFecha(datosAgenda.fecha_agenda);

            document.getElementById('responsable').textContent = datosAgenda.nombres_responsable+' '+datosAgenda.apellidos_responsable;
            document.getElementById('fecha_agenda').textContent = fecha.fecha_español;
            document.getElementById('hora').textContent = fecha.hora_español;
            document.getElementById('motivo').textContent = datosAgenda.motivo;

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

function formatearFecha(fecha){
    const objetoFecha = new Date(fecha.replace(' ', 'T'));

    let opciones = { day: 'numeric', month: 'long' }
    const fechaEspañol = objetoFecha.toLocaleDateString('es-CO', opciones);

    opciones = { hour: 'numeric', minute: '2-digit', hour12: true };
    const horaEspañol = objetoFecha.toLocaleTimeString('es-CO', opciones);

    return {fecha_español: fechaEspañol, hora_español: horaEspañol};
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

