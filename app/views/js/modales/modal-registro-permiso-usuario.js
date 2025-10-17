import { consultarModalPermisoUsuario } from '../fetchs/modales-fetch.js';
import {registrarPermisoUsuario} from '../fetchs/permisos-usuarios-fetch.js';

let contenedorModales;
let modalesExistentes;
let botonCerrarModal;
let selectTipoPermiso;
let funcionCallback;
let urlBase;

function modalRegistroPermisoUsuario(url, permiso=false, documento=false, callback) {
    consultarModalPermisoUsuario(url).then(respuesta=>{
        if(respuesta.tipo == 'OK'){
            const contenidoModal = respuesta.modal;
            const modal = document.createElement('div');
                
            modal.classList.add('contenedor-ppal-modal');
            modal.id = 'modal_permiso_usuario';
            modal.innerHTML = contenidoModal;
            contenedorModales = document.getElementById('contenedor_modales');

            modalesExistentes = contenedorModales.getElementsByClassName('contenedor-ppal-modal');
            if(modalesExistentes.length > 0){
            for (let i = 0; i < modalesExistentes.length; i++) {
                    modalesExistentes[i].remove();
                }
            }

            contenedorModales.appendChild(modal);

            const inputDocumento = document.getElementById('documento_beneficiario');
            if(documento){ 
                inputDocumento.value = documento;
                inputDocumento.readOnly = true;
            }

            selectTipoPermiso = document.getElementById('tipo_permiso');
            if(permiso){
                selectTipoPermiso.value = permiso;
                selectTipoPermiso.disabled = true;
            }

            funcionCallback = callback;
            urlBase = url;

            eventoCerrarModal();
            eventoTextArea();
            eventoRegistrarPermisoUsuario();

            contenedorModales.classList.add('mostrar');
            
            setTimeout(()=>{
                if(permiso && documento){
                    document.getElementById('fecha_fin_permiso').focus();

                }else{
                    selectTipoPermiso.focus();
                }

            }, 250)

        }else if(respuesta.tipo == 'ERROR'){
            alertaError(respuesta);
        }
    }) 
}
export { modalRegistroPermisoUsuario };

function eventoCerrarModal(){
    botonCerrarModal = document.getElementById('cerrar_modal_permiso_usuario');

    botonCerrarModal.addEventListener('click', ()=>{
        modalesExistentes[modalesExistentes.length-1].remove();
        contenedorModales.classList.remove('mostrar');
        
    });

    document.getElementById('btn_cancelar_permiso_usuario').addEventListener('click', ()=>{
        botonCerrarModal.click();
    });
}

function eventoRegistrarPermisoUsuario(){
    let formularioPermisoUsuario = document.getElementById('formulario_permiso_usuario');
    formularioPermisoUsuario.addEventListener('submit', (e)=>{
        e.preventDefault();

        let formData = new FormData(formularioPermisoUsuario);
        formData.append('operacion', 'registrar_permiso_usuario');

        if(selectTipoPermiso.disabled == true){
            formData.append('tipo_permiso', selectTipoPermiso.value);
        }

        registrarPermisoUsuario(formData, urlBase).then(respuesta=>{
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

function eventoTextArea(){
    const textAreaDescripcion = document.getElementById('descripcion');
    const patron = /^[A-Za-zñÑáéíóúÁÉÍÓÚüÜ0-9., ]{5,150}$/;

    textAreaDescripcion.addEventListener('keyup', ()=>{
        textAreaDescripcion.setCustomValidity(""); 
        
        if (!patron.test(textAreaDescripcion.value)){
            textAreaDescripcion.setCustomValidity("Debes digitar solo números y/o letras, mínimo 5 y máximo 150 caracteres");
            textAreaDescripcion.reportValidity();
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