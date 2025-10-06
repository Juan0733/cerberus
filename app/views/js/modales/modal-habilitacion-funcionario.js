import {habilitarFuncionario} from '../fetchs/funcionarios-fetch.js';
import { consultarModalActualizarContrasena } from '../fetchs/modal-fetch.js';

let contenedorModales;
let modalesExistentes;
let botonCerrarModal;
let documentoFuncionario;
let inputContrasena;
let funcionCallback;
let urlBase;

function modalHabilitacionFuncionario(documento, callback, url) {
    consultarModalActualizarContrasena(url).then(respuesta=>{
        if(respuesta.tipo == 'OK'){
            const contenidoModal = respuesta.modal;
            const modal = document.createElement('div');
                
            modal.classList.add('contenedor-ppal-modal');
            modal.id = 'modal_actualizar_contrasena';
            modal.innerHTML = contenidoModal;
            contenedorModales = document.getElementById('contenedor_modales');

            modalesExistentes = contenedorModales.getElementsByClassName('contenedor-ppal-modal');
            if(modalesExistentes.length > 0){
            for (let i = 0; i < modalesExistentes.length; i++) {
                    modalesExistentes[i].remove();
                }
            }

            contenedorModales.appendChild(modal);

            document.getElementById('btn_actualizar').textContent = 'Habilitar';
            document.getElementById('titulo_modal_actualizar_contrasena').textContent = 'Habilitar Funcionario';

            inputContrasena = document.getElementById('contrasena');

            documentoFuncionario = documento;
            funcionCallback = callback;
            urlBase = url;

            eventoCerrarModal();
            validarConfirmacionContrasena();
            eventoHabilitar();

            contenedorModales.classList.add('mostrar');

            setTimeout(()=>{
            inputContrasena.focus();
            }, 250);

        }else if(respuesta.tipo == 'ERROR'){
            alertaError(respuesta);
        }
    })
}
export { modalHabilitacionFuncionario };

function eventoCerrarModal(){
    botonCerrarModal = document.getElementById('cerrar_modal_actualizar_contrasena');

    botonCerrarModal.addEventListener('click', ()=>{
        modalesExistentes[modalesExistentes.length-1].remove();
        contenedorModales.classList.remove('mostrar');
    });

    document.getElementById('btn_cancelar_actualizacion').addEventListener('click', ()=>{
        botonCerrarModal.click();
    });
}

function validarConfirmacionContrasena(){
    const inputConfirmacion = document.getElementById('confirmacion_contrasena');
    
    inputConfirmacion.addEventListener('keyup', ()=>{
        inputConfirmacion.setCustomValidity("");
        
        if(inputConfirmacion.checkValidity()){
            if (inputContrasena.value != inputConfirmacion.value){
                inputConfirmacion.setCustomValidity("Las contraseñas no coinciden");
                inputConfirmacion.reportValidity();
            }
        }
    })
}

function eventoHabilitar(){
    let formularioHabilitarUsuario = document.getElementById('formulario_actualizar_contrasena');
    formularioHabilitarUsuario.addEventListener('submit', (e)=>{
        e.preventDefault();

        let formData = new FormData(formularioHabilitarUsuario);
        formData.append('operacion', 'habilitar_funcionario');
        formData.append('numero_documento', documentoFuncionario);

        habilitarFuncionario(formData, urlBase).then(respuesta=>{
            if(respuesta.tipo == "OK" ){
                alertaExito(respuesta);
                funcionCallback();
                botonCerrarModal.click();
                
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
