import {registrarVigilante} from '../fetchs/vigilantes-fetch.js';

let contenedorModales;
let modalesExistentes;
let botonCerrarModal;
let funcionCallback;
let selectTipoDocumento;
let inputCorreo;
let seccion01;
let seccion02;
let botonAtras;
let botonCancelar;
let botonRegistrar;
let botonSiguiente;
let urlBase;

const contenedorSpinner = document.getElementById('contenedor_spinner');

async function modalRegistroVigilante(callback, url) {
    try {
        contenedorSpinner.classList.add("mostrar_spinner");
        const response = await fetch(url+'app/views/inc/modales/modal-vigilante.php');

        if(!response.ok) throw new Error('Hubo un error en la solicitud');

        const contenidoModal = await response.text();
        const modal = document.createElement('div');
            
        modal.classList.add('contenedor-ppal-modal');
        modal.id = 'modal_vigilante';
        modal.innerHTML = contenidoModal;
        contenedorModales = document.getElementById('contenedor_modales');

        modalesExistentes = contenedorModales.getElementsByClassName('contenedor-ppal-modal');
        if(modalesExistentes.length > 0){
           for (let i = 0; i < modalesExistentes.length; i++) {
                modalesExistentes[i].remove();
            }
        }

        contenedorModales.appendChild(modal);

        selectTipoDocumento = document.getElementById('tipo_documento');
        inputCorreo = document.getElementById('correo_electronico');
        seccion01 = document.getElementsByClassName('seccion-01');
        seccion02 = document.getElementsByClassName('seccion-02');
        botonCancelar = document.getElementById('btn_cancelar_vigilante');
        botonAtras = document.getElementById('btn_atras_vigilante');
        botonSiguiente = document.getElementById('btn_siguiente_vigilante');
        botonRegistrar = document.getElementById('btn_registrar_vigilante');

        funcionCallback = callback;
        urlBase = url;

        eventoCerrarModal();
        validarConfirmacionContrasena();
        mostrarCampos();
        volverCampos();
        eventoRegistrarVigilante();

        contenedorSpinner.classList.remove("mostrar_spinner");
        contenedorModales.classList.add('mostrar');

        setTimeout(()=>{
           selectTipoDocumento.focus();
        }, 250)

    } catch (error) {
        contenedorSpinner.classList.remove("mostrar_spinner");

        if(botonCerrarModal){
            botonCerrarModal.click();
        }

       console.error('Hubo un error:', error);
        alertaError({
            titulo: 'Error Modal',
            mensaje: 'Error al cargar modal registro funcionario.'
        });
    }
    
}
export { modalRegistroVigilante };

function eventoCerrarModal(){
    botonCerrarModal = document.getElementById('cerrar_modal_vigilante');

    botonCerrarModal.addEventListener('click', ()=>{
        modalesExistentes[modalesExistentes.length-1].remove();
        contenedorModales.classList.remove('mostrar');
        
    });

    document.getElementById('btn_cancelar_vigilante').addEventListener('click', ()=>{
        botonCerrarModal.click();
    });
}

function eventoRegistrarVigilante(){
    let formularioVigilante = document.getElementById('formulario_vigilante');
    formularioVigilante.addEventListener('submit', (e)=>{
        e.preventDefault();

        let formData = new FormData(formularioVigilante);

        formData.append('operacion', 'registrar_vigilante');
       
        registrarVigilante(formData, urlBase).then(respuesta=>{
            if(respuesta.tipo == "OK" ){
                botonCerrarModal.click();
                alertaExito(respuesta);
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

function validarConfirmacionContrasena(){
    const inputContrasena = document.getElementById('contrasena');
    const inputConfirmacion = document.getElementById('confirmacion_contrasena');

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

function mostrarCampos(){
    const inputsSeccion01 = document.getElementsByClassName('campo-seccion-01');

    botonSiguiente.addEventListener('click', ()=>{
        let validos = true;
        
        for(const input of inputsSeccion01) {
            if(!input.checkValidity()){
                input.reportValidity();
                validos = false;
                break;
            }
        };

        if(validos){
            for(const caja of seccion01){
                caja.style.display = 'none';
            }
        
            for(const caja of seccion02){
                caja.style.display = 'block';
            }

            inputCorreo.focus();

            botonCancelar.style.display = 'none';
            botonSiguiente.style.display = 'none';
            botonRegistrar.style.display = 'flex';
            botonAtras.style.display = 'flex';
        }
    })
}

function volverCampos(){
    botonAtras.addEventListener('click', ()=>{
        for(const caja of seccion02){
            caja.style.display = 'none';
        }
        
        for(const caja of seccion01){
            caja.style.display = 'block';
        }
        
        botonAtras.style.display = 'none';
        botonRegistrar.style.display = 'none';
        botonCancelar.style.display = 'flex';
        botonSiguiente.style.display = 'flex';

        selectTipoDocumento.focus();
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