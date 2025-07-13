import {consultarAgenda, actualizarAgenda} from '../fetchs/agenda-fetch.js'

let contenedorModales;
let modalesExistentes;
let codigoAgenda;
let botonCerrarModal;
let inputTitulo;
let inputFechAgenda;
let textAreaMotivo;
let checkIndividual;
let checkGrupal;
let funcionCallback;
let urlBase;

const contenedorSpinner = document.getElementById('contenedor_spinner');

async function modalActualizarAgenda(codigo, callback, url) {
    try {
        contenedorSpinner.classList.add("mostrar_spinner");
        const response = await fetch(url+'app/views/inc/modales/modal-agenda.php');

        if(!response.ok) throw new Error('Hubo un error en la solicitud');

        const contenidoModal = await response.text();
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

        document.getElementById('btn_siguiente_agenda').style.display = 'none';
        document.getElementById('btn_actualizar_agenda').style.display = 'flex';
        document.getElementById('titulo_modal_agenda').textContent = 'Actualizar Agenda'

        inputTitulo =  document.getElementById('titulo_agenda');
        inputFechAgenda = document.getElementById('fecha_agenda');
        textAreaMotivo = document.getElementById('motivo');
        checkIndividual = document.getElementById('individual');
        checkGrupal = document.getElementById('grupal');
    
        codigoAgenda = codigo;
        funcionCallback = callback;
        urlBase = url;

        eventoCerrarModal();
        dibujarAgenda();
        eventoTextArea();
        eventoActualizarAgenda();
           
        setTimeout(()=>{
           titulo.focus();
        }, 250)
        
    } catch (error) {
        contenedorSpinner.classList.remove("mostrar_spinner");
        
        if(botonCerrarModal){
            botonCerrarModal.click();
        }
        console.error('Hubo un error:', error);
        alertaError({
            titulo: 'Error Modal',
            mensaje: 'Error al cargar modal agenda.'
        });
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
            inputTitulo.value = respuesta.datos_agenda.titulo;
            inputFechAgenda.value = respuesta.datos_agenda.fecha_agenda;
            textAreaMotivo.value = respuesta.datos_agenda.motivo;
            inputFechAgenda.min = respuesta.datos_agenda.fecha_agenda;
            checkIndividual.disabled = true;
            checkGrupal.disabled = true;

            if(respuesta.datos_agenda.agendados.length > 1){
                checkGrupal.checked = true;
            }else{
                checkIndividual.checked = true;
            }

            contenedorSpinner.classList.remove("mostrar_spinner");
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

        if(!motivo.reportValidity()){
            return;
        }

        const formData = new FormData();

        formData.append('operacion', 'actualizar_agenda');
        formData.append('codigo_agenda', codigoAgenda)
        formData.append('titulo', inputTitulo.value);
        formData.append('fecha_agenda', inputFechAgenda.value);
        formData.append('motivo', textAreaMotivo.value);

        actualizarAgenda(formData, urlBase).then(respuesta=>{
            if(respuesta.tipo == 'OK'){
                botonCerrarModal.click();
                alertaExito(respuesta);
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

function eventoTextArea(){
    let temporizador;
    let primeraValidacion = true;

    textAreaMotivo.addEventListener('keyup', ()=>{
        clearTimeout(temporizador);
        temporizador = setTimeout(()=>{
            let patron = /^[A-Za-zñÑáéíóúÁÉÍÓÚüÜ0-9., ]{5,100}$/;
    
            if (!patron.test(textAreaMotivo.value)){

                if(primeraValidacion){
                    textAreaMotivo.setCustomValidity("Debes digitar solo números y letras, mínimo 5 y máximo 100 caracteres");
                    textAreaMotivo.reportValidity();
                    primeraValidacion = false;
                }

            }else {
                textAreaMotivo.setCustomValidity(""); 
                primeraValidacion = true;
            }
        }, 1000);
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