import {consultarAgenda} from '../fetchs/agenda-fetch.js';
import { consultarModalDetalleAgenda } from '../fetchs/modal-fetch.js';

let contenedorModales;
let modalesExistentes;
let codigoAgenda;
let botonCerrarModal;
let urlBase;

function modalDetalleAgenda(codigo, url) {
    consultarModalDetalleAgenda(url).then(respuesta=>{
        if(respuesta.tipo == 'OK'){
            const contenidoModal = respuesta.modal;
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

        }else if(respuesta.tipo == 'ERROR'){
            alertaError(respuesta);
        }
    })
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
            
            document.getElementById('responsable_registro').textContent = formatearString(datosAgenda.rol_responsable)+' - '+datosAgenda.nombres_responsable+' '+datosAgenda.apellidos_responsable;
            document.getElementById('fecha_agenda').textContent = formatearFecha(datosAgenda.fecha_agenda);
            document.getElementById('motivo').textContent = datosAgenda.motivo;

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

