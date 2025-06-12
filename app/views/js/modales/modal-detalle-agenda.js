import {consultarAgenda} from '../fetchs/agenda-fetch.js';

let contenedorModales;
let modalesExistentes;
let codigoAgenda;
let botonCerrarModal;
let urlBase;

async function modalDetalleAgenda(codigo, url) {
    try {
        const response = await fetch(url+'app/views/inc/modales/modal-detalle-agenda.php');

        if(!response.ok) throw new Error('Hubo un error en la solicitud');

        const contenidoModal = await response.text();
        const modal = document.createElement('div');
            
        modal.classList.add('contenedor-ppal-modal');
        modal.id = 'modal_detalle_agenda';
        modal.innerHTML = contenidoModal;
        contenedorModales = document.getElementById('contenedor_modales');
        contenedorModales.appendChild(modal);

        botonCerrarModal = document.getElementById('cerrar_modal_detalle_agenda');
        modalesExistentes = contenedorModales.getElementsByClassName('contenedor-ppal-modal');
        codigoAgenda = codigo;
        urlBase = url;
         
        eventoCerrarModal();
        dibujarAgenda(codigo);

    } catch (error) {
        if(botonCerrarModal){
            botonCerrarModal.click();
        }
        
        let respuesta = {
            titulo: 'Error Modal',
            mensaje: 'Error al cargar modal detalla agenda.'
        }
        alertaError(respuesta);
    }
}
export{modalDetalleAgenda}

function eventoCerrarModal(){
    botonCerrarModal.addEventListener('click', ()=>{
        modalesExistentes[modalesExistentes.length-1].remove();
        contenedorModales.classList.remove('mostrar');
    });
}

function dibujarAgenda() {
    consultarAgenda(codigoAgenda, urlBase).then(respuesta=>{
        if(respuesta.tipo == 'OK'){
            document.getElementById('titulo').textContent = respuesta.datos_agenda.titulo;
            const cuerpoTablaAgendados = document.getElementById('cuerpo_tabla_agendados');
        
            respuesta.datos_agenda.agendados.forEach((agendado, indice) => {
                cuerpoTablaAgendados.innerHTML += `
                    <tr>
                        <td>${indice+1}</td>
                        <td>${agendado.nombres}</td>
                        <td>${agendado.apellidos}</td>
                    </tr>`
            });

            document.getElementById('responsable').textContent = respuesta.datos_agenda.nombres_responsable+' '+respuesta.datos_agenda.apellidos_responsable;
            document.getElementById('fecha_agenda').textContent = respuesta.datos_agenda.fecha;
            document.getElementById('hora').textContent = respuesta.datos_agenda.hora;
            document.getElementById('motivo').textContent = respuesta.datos_agenda.motivo;

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

