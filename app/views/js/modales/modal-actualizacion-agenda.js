import {consultarAgenda, actualizarAgenda} from '../fetchs/agenda-fetch.js'

let contenedorModales;
let modalesExistentes;
let codigoAgenda;
let agendados;
let botonCerrarModal;
let titulo;
let fechAgenda;
let motivo;
let checkIndividual;
let checkGrupal;
let funcionCallback;
let urlBase;

async function modalActualizarAgenda(codigo, callback, url) {
    try {
        const response = await fetch(url+'app/views/inc/modales/modal-agenda.php');

        if(!response.ok) throw new Error('Hubo un error en la solicitud');

        const contenidoModal = await response.text();
        const modal = document.createElement('div');
            
        modal.classList.add('contenedor-ppal-modal');
        modal.id = 'modal_agenda';
        modal.innerHTML = contenidoModal;
        contenedorModales = document.getElementById('contenedor_modales');
        contenedorModales.appendChild(modal);

        document.getElementById('btn_siguiente_agenda').style.display = 'none';
        document.getElementById('btn_actualizar_agenda').style.display = 'flex';
        document.getElementById('titulo_modal').textContent = 'Actualizar Agenda'

        titulo =  document.getElementById('titulo_agenda');
        fechAgenda = document.getElementById('fecha_agenda');
        motivo = document.getElementById('motivo');
        checkIndividual = document.getElementById('individual');
        checkGrupal = document.getElementById('grupal');
        
        modalesExistentes = contenedorModales.getElementsByClassName('contenedor-ppal-modal');
    
        codigoAgenda = codigo;
        funcionCallback = callback;
        urlBase = url;

        setTimeout(()=>{
           titulo.focus();
        }, 250)
        
        eventoCerrarModal();
        dibujarAgenda();
        eventoActualizarAgenda();
           
    } catch (error) {
        if(botonCerrarModal){
            botonCerrarModal.click();
        }
        
        let respuesta = {
            titulo: 'Error Modal',
            mensaje: 'Error al cargar modal agenda.'
        }
        alertaError(respuesta);
    }
}
export{modalActualizarAgenda}

function eventoCerrarModal(){
    botonCerrarModal = document.getElementById('cerrar_modal_agenda');

    botonCerrarModal.addEventListener('click', ()=>{
        modalesExistentes[modalesExistentes.length-1].remove();
        contenedorModales.classList.remove('mostrar');
    });

    document.getElementById('btn_cancelar_agenda').addEventListener('click', ()=>{
        botonCerrarModal.click();
    });
}

function dibujarAgenda(){
    consultarAgenda(codigoAgenda, urlBase).then(respuesta=>{
        if(respuesta.tipo == 'OK'){
            titulo.value = respuesta.datos_agenda.titulo;
            fechAgenda.value = respuesta.datos_agenda.fecha_agenda;
            motivo.value = respuesta.datos_agenda.motivo;
            agendados = respuesta.datos_agenda.agendados;
            fechAgenda.min = respuesta.datos_agenda.fecha_agenda;

            checkIndividual.disabled = true;
            checkGrupal.disabled = true;

            if(agendados.length > 1){
                checkGrupal.checked = true;
            }else{
                checkIndividual.checked = true;
            }

            contenedorModales.classList.add('mostrar');

        }else if(respuesta.tipo == 'ERROR'){
            if(respuesta.titulo == 'Sesión Expirada'){
                window.location.replace(urlBase+'sesion-expirada');
                
            }else{
                botonCerrarModal.click();
                alertaError (respuesta);
                
            } 
        }
    })
}

function eventoActualizarAgenda(){
    document.getElementById('formulario_agenda').addEventListener('submit', (e)=>{
        e.preventDefault();
        const formData = new FormData();
        const agendadosJson = JSON.stringify(agendados);

        formData.append('operacion', 'actualizar_agenda');
        formData.append('codigo_agenda', codigoAgenda)
        formData.append('titulo', titulo.value);
        formData.append('fecha_agenda', fechAgenda.value);
        formData.append('motivo', motivo.value);
        formData.append('agendados', agendadosJson);

        actualizarAgenda(formData, urlBase).then(respuesta=>{
            if(respuesta.tipo == 'OK'){
                alertaExito(respuesta);
                botonCerrarModal.click();
                funcionCallback();

            }else if(respuesta.tipo == 'ERROR'){
                if(respuesta.titulo == 'Sesión Expirada'){
                    window.location.replace(urlBase+'sesion-expirada');
                }else{
                    alertaError(respuesta);
                }
            }
        })

    })
}

function alertaExito(respuesta){
    Swal.fire({
        toast: true, 
        position: 'top-end', 
        icon: 'success',
        iconColor: "#2db910",
        color: '#F3F4F4',
        background: '#001629',
        timer: 5000,
        timerProgressBar: true,
        title: respuesta.mensaje,
        showConfirmButton: false,   
        customClass: {
            popup: 'alerta-contenedor',
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