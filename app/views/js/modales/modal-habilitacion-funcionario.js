import {habilitarFuncionario} from '../fetchs/funcionarios-fetch.js';

let contenedorModales;
let modalesExistentes;
let botonCerrarModal;
let documentoFuncionario;
let inputContrasena;
let inputConfirmacion;
let funcionCallback;
let urlBase;

const contenedorSpinner = document.getElementById('contenedor_spinner');

async function modalHabilitacionFuncionario(documento, callback, url) {
    try {
        contenedorSpinner.classList.add("mostrar_spinner");
        const response = await fetch(url+'app/views/inc/modales/modal-habilitar-usuario.php');

        if(!response.ok) throw new Error('Hubo un error en la solicitud');

        const contenidoModal = await response.text();
        const modal = document.createElement('div');
            
        modal.classList.add('contenedor-ppal-modal');
        modal.id = 'modal_habilitar_usuario';
        modal.innerHTML = contenidoModal;
        contenedorModales = document.getElementById('contenedor_modales');

        modalesExistentes = contenedorModales.getElementsByClassName('contenedor-ppal-modal');
        if(modalesExistentes.length > 0){
           for (let i = 0; i < modalesExistentes.length; i++) {
                modalesExistentes[i].remove();
            }
        }

        contenedorModales.appendChild(modal);

        inputContrasena = document.getElementById('contrasena');
        inputConfirmacion = document.getElementById('confirmacion_contrasena');

        documentoFuncionario = documento;
        funcionCallback = callback;
        urlBase = url;

        eventoCerrarModal();
        validarConfirmacionContrasena();
        eventoHabilitar();

        contenedorSpinner.classList.remove("mostrar_spinner");
        contenedorModales.classList.add('mostrar');

        setTimeout(()=>{
           inputContrasena.focus();
        }, 250);

    } catch (error) {
        contenedorSpinner.classList.remove("mostrar_spinner");

        if(botonCerrarModal){
            botonCerrarModal.click();
        }

       console.error('Hubo un error:', error);
        alertaError({
            titulo: 'Error Modal',
            mensaje: 'Error al cargar modal habilitacion usuario.'
        });
    }
}
export { modalHabilitacionFuncionario };

function eventoCerrarModal(){
    botonCerrarModal = document.getElementById('cerrar_modal_habilitar_usuario');

    botonCerrarModal.addEventListener('click', ()=>{
        modalesExistentes[modalesExistentes.length-1].remove();
        contenedorModales.classList.remove('mostrar');
    });

    document.getElementById('btn_cancelar_habilitacion').addEventListener('click', ()=>{
        botonCerrarModal.click();
    });
}

function validarConfirmacionContrasena(){
    let temporizador;
    let primeraValidacion = true;

    inputConfirmacion.addEventListener('keyup', ()=>{
        clearTimeout(temporizador);
        temporizador = setTimeout(()=>{
            if (inputContrasena.value != inputConfirmacion.value){
                if(primeraValidacion){
                    inputConfirmacion.setCustomValidity("Las contraseña no coinciden");
                    inputConfirmacion.reportValidity();
                    primeraValidacion = false;
                }

            }else {
                inputConfirmacion.setCustomValidity(""); 
                primeraValidacion = true;
            }
        }, 1000);
    })
}

function eventoHabilitar(){
    let formularioHabilitarUsuario = document.getElementById('formulario_habilitar_usuario');
    formularioHabilitarUsuario.addEventListener('submit', (e)=>{
        e.preventDefault();

        let formData = new FormData(formularioHabilitarUsuario);
        formData.append('operacion', 'habilitar_funcionario');
        formData.append('numero_documento', documentoFuncionario);

        habilitarFuncionario(formData, urlBase).then(respuesta=>{
            if(respuesta.tipo == "OK" ){
                alertaExito(respuesta);
                botonCerrarModal.click();
                funcionCallback();
                
            }else if(respuesta.tipo == "ERROR"){
                if(respuesta.titulo == 'Sesión Expirada'){
                    window.location.replace(urlBase+'sesion-expirada');

                }else{
                    alertaError(respuesta);
                }
            }
        });
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
