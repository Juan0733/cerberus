import {consultarAgenda, actualizarAgenda} from '../fetchs/agendas-fetch.js';
import { consultarModalAgenda } from '../fetchs/modales-fetch.js';

let contenedorModales;
let modalesExistentes;
let codigoAgenda;
let botonCerrarModal;
let inputTitulo;
let inputFechAgenda;
let textAreaMotivo;
let checkIndividual;
let checkCargaMasiva;
let funcionCallback;
let urlBase;


function modalActualizarAgenda(codigo, callback, url) {
    consultarModalAgenda(url).then(respuesta=>{
        if(respuesta.tipo == 'OK'){
            const contenidoModal = respuesta.modal
            const modal = document.createElement('div');
            
            modal.classList.add('contenedor-ppal-modal');
            modal.id = 'modal_agenda';
            modal.innerHTML = contenidoModal;
            contenedorModales = document.getElementById('contenedor_modales');

            modalesExistentes = contenedorModales.getElementsByClassName('contenedor-ppal-modal');
            if(modalesExistentes.length > 0){
            for (let i = 0; i < modalesExistentes.length; i++) {
                    modalesExistentes[i].remove();
                }
            }

            contenedorModales.appendChild(modal);

            const btnRegistrar = document.getElementById('btn_registrar_agenda');
            btnRegistrar.textContent = 'Actualizar';
            btnRegistrar.style.display = 'flex';

            document.getElementById('btn_siguiente_agenda').style.display = 'none';
            document.getElementById('titulo_modal_agenda').textContent = 'Actualizar Agenda';

            inputTitulo =  document.getElementById('titulo_agenda');
            inputFechAgenda = document.getElementById('fecha_agenda');
            textAreaMotivo = document.getElementById('motivo');
            checkIndividual = document.getElementById('individual');
            checkCargaMasiva = document.getElementById('carga_masiva');
        
            codigoAgenda = codigo;
            funcionCallback = callback;
            urlBase = url;

            eventoCerrarModal();
            eventoTextArea();
            eventoActualizarAgenda();
            dibujarAgenda();
            
            setTimeout(()=>{
                inputTitulo.focus();
            }, 250)

        }else if(respuesta.tipo == 'ERROR'){
            alertaError(respuesta);
        }
    })
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
            inputTitulo.value = respuesta.datos_agenda.titulo;
            inputFechAgenda.value = respuesta.datos_agenda.fecha_agenda;
            textAreaMotivo.value = respuesta.datos_agenda.motivo;
            inputFechAgenda.min = respuesta.datos_agenda.fecha_agenda;
            checkIndividual.disabled = true;
            checkCargaMasiva.disabled = true;

            if(respuesta.datos_agenda.agendados.length > 1){
                checkCargaMasiva.checked = true;
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

        formData.append('operacion', 'actualizar_agenda');
        formData.append('codigo_agenda', codigoAgenda)
        formData.append('titulo', inputTitulo.value);
        formData.append('fecha_agenda', inputFechAgenda.value);
        formData.append('motivo', textAreaMotivo.value);

        actualizarAgenda(formData, urlBase).then(respuesta=>{
            if(respuesta.tipo == 'OK'){
                alertaExito(respuesta);
                funcionCallback();
                botonCerrarModal.click();

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

function eventoTextArea(){
    const patron = /^[A-Za-zñÑáéíóúÁÉÍÓÚüÜ0-9., ]{5,100}$/;

    textAreaMotivo.addEventListener('keyup', ()=>{    
        textAreaMotivo.setCustomValidity("");

        if (!patron.test(textAreaMotivo.value)){
            textAreaMotivo.setCustomValidity("Debes digitar solo números y/o letras, mínimo 5 y máximo 100 caracteres");
            textAreaMotivo.reportValidity();
        }
    })
}

function alertaExito(respuesta){
    Swal.fire({
        toast: true, 
        position: 'bottom-end', 
        icon: 'success',
        iconColor: "#2db910",
        color: '#F3F4F4',
        background: '#001629',
        timer: 5000,
        timerProgressBar: true,
        title: respuesta.mensaje,
        showConfirmButton: false,   
        customClass: {
            popup: 'alerta-contenedor exito',
        },
        didOpen: (toast) => {
            toast.addEventListener('click', () => {
                Swal.close();
            });
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