import {registrarPermisoUsuario} from '../fetchs/permisos-usuarios-fetch.js';

let contenedorModales;
let modalesExistentes;
let botonCerrarModal;
let selectTipoPermiso;
let funcionCallback;
let urlBase;

const contenedorSpinner = document.getElementById('contenedor_spinner');

async function modalRegistroPermisoUsuario(url, permiso=false, documento=false, callback) {
    try {
        contenedorSpinner.classList.add("mostrar_spinner");
        const response = await fetch(url+'app/views/inc/modales/modal-permiso-usuario.php');

        if(!response.ok) throw new Error('Hubo un error en la solicitud');

        const contenidoModal = await response.text();
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

        if(documento){
            const inputDocumento = document.getElementById('documento_beneficiario'); 
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

        contenedorSpinner.classList.remove("mostrar_spinner");
        contenedorModales.classList.add('mostrar');
        
        setTimeout(()=>{
            document.getElementById('fecha_fin_permiso').focus();
        }, 250)

    } catch (error) {
        contenedorSpinner.classList.remove("mostrar_spinner");

        if(botonCerrarModal){
            botonCerrarModal.click();
        }

       console.error('Hubo un error:', error);
        alertaError({
            titulo: 'Error Modal',
            mensaje: 'Error al cargar modal registro permiso permanencia usuario.'
        });
    }
    
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
        formData.append('tipo_permiso', selectTipoPermiso.value);

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
    let temporizador;
    let primeraValidacion = true;

    textAreaDescripcion.addEventListener('keyup', ()=>{
        clearTimeout(temporizador);
        temporizador = setTimeout(()=>{
            let patron = /^[A-Za-zñÑáéíóúÁÉÍÓÚüÜ0-9., ]{5,150}$/;
    
            if (!patron.test(textAreaDescripcion.value)){

                if(primeraValidacion){
                    textAreaDescripcion.setCustomValidity("Debes digitar solo números y letras, mínimo 1 y máximo 100 caracteres");
                    textAreaDescripcion.reportValidity();
                    primeraValidacion = false;
                }

            }else {
                textAreaDescripcion.setCustomValidity(""); 
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