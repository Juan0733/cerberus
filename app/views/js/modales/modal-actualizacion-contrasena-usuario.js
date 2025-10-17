import { consultarModalActualizarContrasena } from '../fetchs/modales-fetch.js';
import { actualizarContrasenaUsuario } from '../fetchs/usuarios-fetch.js';

let contenedorModales;
let modalesExistentes;
let inputContrasena;
let funcionCallback;
let urlBase;

function modalActualizacionContrasenaUsuario(url, callback) {
    consultarModalActualizarContrasena(url).then(respuesta=>{
        if(respuesta.tipo == 'OK'){
            const contenidoModal = respuesta.modal;
            const modal = document.createElement('div');
                
            modal.classList.add('contenedor-ppal-modal');
            modal.id = 'modal_actualizar_contrasena';
            modal.innerHTML = contenidoModal;
            contenedorModales = document.getElementById('contenedor_modales');
            modalesExistentes = contenedorModales.getElementsByClassName('contenedor-ppal-modal');
            
            contenedorModales.appendChild(modal);

            inputContrasena = document.getElementById('contrasena');

            urlBase = url;
            funcionCallback = callback;

            validarConfirmacionContrasena();
            eventoActualizarContrasena();

            modalesExistentes = contenedorModales.getElementsByClassName('contenedor-ppal-modal');
            if(modalesExistentes.length > 1){
                modalesExistentes[modalesExistentes.length-2].style.display = 'none';

            }else{
                contenedorModales.classList.add('mostrar');
            }

            setTimeout(()=>{
                inputContrasena.focus();
            }, 250);

        }else if(respuesta.tipo == 'ERROR'){
            alertaError(respuesta);
        }
    })
}
export { modalActualizacionContrasenaUsuario };

function eventoCerrarModal(){
    modalesExistentes[modalesExistentes.length-1].remove();
    if(modalesExistentes.length > 0) {
        modalesExistentes[modalesExistentes.length-1].style.display = 'block';
    }else{
        contenedorModales.classList.remove('mostrar');
    }
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

function eventoActualizarContrasena(){
    let formularioActualizarContrasena = document.getElementById('formulario_actualizar_contrasena');
    formularioActualizarContrasena.addEventListener('submit', (e)=>{
        e.preventDefault();

        let formData = new FormData(formularioActualizarContrasena);
        formData.append('operacion', 'actualizar_contrasena_usuario');

        actualizarContrasenaUsuario(formData, urlBase).then(respuesta=>{
            if(respuesta.tipo == "OK" ){
                alertaExito(respuesta);
                eventoCerrarModal();
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