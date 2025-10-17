import { consultarModalVigilante } from '../fetchs/modales-fetch.js';
import {actualizarVigilante, consultarVigilante} from '../fetchs/vigilantes-fetch.js';

let contenedorModales;
let modalesExistentes;
let botonCerrarModal;
let modal;
let contenedorCajas;
let seccionIndividual01;
let seccionIndividual02;
let documentoVigilante;
let selectTipoDocumento;
let inputDocumento;
let inputNombres;
let inputApellidos;
let inputTelefono;
let inputCorreo;
let selectRol;
let inputContrasena;
let inputConfirmacion;
let botonAtras;
let botonCancelar;
let botonRegistrar;
let botonSiguiente;
let funcionCallback;
let urlBase;

function modalActualizacionVigilante(vigilante, callback, url) {
    consultarModalVigilante(url).then(respuesta=>{
        if(respuesta.tipo == 'OK'){
            const contenidoModal = respuesta.modal;
            modal = document.createElement('div');
                
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

            contenedorCajas = document.getElementById('contenedor_cajas_vigilante');
            seccionIndividual01 = document.getElementsByClassName('seccion-individual-01');
            seccionIndividual02 = document.getElementsByClassName('seccion-individual-02');
            selectTipoDocumento = document.getElementById('tipo_documento');
            inputDocumento = document.getElementById('numero_documento');
            inputNombres =  document.getElementById('nombres');
            inputApellidos = document.getElementById('apellidos');
            inputTelefono = document.getElementById('telefono');
            inputCorreo =  document.getElementById('correo_electronico');
            selectRol = document.getElementById('rol');
            inputContrasena = document.getElementById('contrasena');
            inputConfirmacion = document.getElementById('confirmacion_contrasena');
            botonCancelar = document.getElementById('btn_cancelar_vigilante');
            botonAtras = document.getElementById('btn_atras_vigilante');
            botonSiguiente = document.getElementById('btn_siguiente_vigilante');
            botonRegistrar = document.getElementById('btn_registrar_vigilante');

            document.getElementById('titulo_modal_vigilante').textContent = 'Actualizar Vigilante';
            botonRegistrar.textContent = 'Actualizar';
            
            documentoVigilante = vigilante;
            funcionCallback = callback;
            urlBase = url;

            eventoCerrarModal();
            mostrarSeccionIndividual();
            validarConfirmacionContrasena();
            eventoInputContrasena();
            mostrarCampos();
            volverCampos();
            eventoActualizarVigilante();
            dibujarVigilante();

            setTimeout(()=>{
            selectTipoDocumento.focus();
            }, 250)

        }else if(respuesta.tipo == 'ERROR'){
            alertaError(respuesta);
        }
    })
}
export { modalActualizacionVigilante };

function eventoCerrarModal(){
    botonCerrarModal = document.getElementById('cerrar_modal_vigilante');

    botonCerrarModal.addEventListener('click', ()=>{
        modalesExistentes[modalesExistentes.length-1].remove();
        contenedorModales.classList.remove('mostrar');
        
    });

    botonCancelar.addEventListener('click', ()=>{
        botonCerrarModal.click();
    });
}

function mostrarSeccionIndividual(){
    const seccionPrincipal = document.getElementsByClassName('seccion-principal');
    const seccionIndividual = document.getElementsByClassName('seccion-individual');
    const inputsSeccionIndividual = document.getElementsByClassName('campo-individual');

    for(const caja of seccionPrincipal){
        caja.style.display = 'none';
    };

    if(window.innerWidth >= 768){
        for(const caja of seccionIndividual){
            caja.style.display = 'block';
        };

        modal.style.width = 'clamp(550px, 50%, 980px)';
        contenedorCajas.style.gridTemplateColumns = 'repeat(2, 1fr)';

        botonSiguiente.style.display = 'none';
        botonRegistrar.style.display = 'flex';

    }else if(window.innerWidth <= 767){
        for(const caja of seccionIndividual01){
            caja.style.display = 'block';
        };
    }

    for(const input of inputsSeccionIndividual){
        input.required = true;
    };

    inputContrasena.required = false;
    inputConfirmacion.required = false;
}

function dibujarVigilante(){
    consultarVigilante(documentoVigilante, urlBase).then(respuesta=>{
        if(respuesta.tipo == 'OK'){
            const datosVigilante = respuesta.datos_vigilante;
            selectTipoDocumento.value = datosVigilante.tipo_documento;
            selectTipoDocumento.disabled = true;
            inputDocumento.value = datosVigilante.numero_documento;
            inputDocumento.readOnly = true;
            inputNombres.value = datosVigilante.nombres;
            inputApellidos.value = datosVigilante.apellidos;
            inputTelefono.value = datosVigilante.telefono;
            inputCorreo.value = datosVigilante.correo_electronico;
            selectRol.value = datosVigilante.rol;

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

function eventoActualizarVigilante(){
    let formularioVigilante = document.getElementById('formulario_vigilante');
    formularioVigilante.addEventListener('submit', (e)=>{
        e.preventDefault();

        let formData = new FormData();
        formData.append('operacion', 'actualizar_vigilante');
        formData.append('numero_documento', inputDocumento.value);
        formData.append('nombres', inputNombres.value);
        formData.append('apellidos', inputApellidos.value);
        formData.append('telefono', inputTelefono.value);
        formData.append('correo_electronico', inputCorreo.value);
        formData.append('rol', selectRol.value);
        formData.append('contrasena', inputContrasena.value);

        actualizarVigilante(formData, urlBase).then(respuesta=>{
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

function validarConfirmacionContrasena(){
    inputConfirmacion.addEventListener('keyup', ()=>{
        inputConfirmacion.setCustomValidity("");

        if(inputConfirmacion.checkValidity()){
            if (inputContrasena.value != inputConfirmacion.value){
                inputConfirmacion.setCustomValidity("Las contraseña no coinciden");
                inputConfirmacion.reportValidity();
            }  
        }  
    })
}

function eventoInputContrasena(){
    inputContrasena.addEventListener('keyup', ()=>{
        if(inputContrasena.value.length > 7){
            inputConfirmacion.required = true;

        }else if(inputContrasena.value.length < 8){ 
            inputConfirmacion.required = false;
        }
    })
}

function mostrarCampos(){
    const inputsSeccionIndividual01 = document.getElementsByClassName('campo-individual-01');

    botonSiguiente.addEventListener('click', ()=>{
        let camposValidos = true;
        
        for(const input of inputsSeccionIndividual01) {
            if(!input.checkValidity()){
                input.reportValidity();
                camposValidos = false;
                break;
            }
        };

        if(camposValidos){
            for(const caja of seccionIndividual01){
                caja.style.display = 'none';
            }
        
            for(const caja of seccionIndividual02){
                caja.style.display = 'block';
            }

            botonCancelar.style.display = 'none';
            botonSiguiente.style.display = 'none';
            botonRegistrar.style.display = 'flex';
            botonAtras.style.display = 'flex';

            inputCorreo.focus();
        }
    })
}

function volverCampos(){
    botonAtras.addEventListener('click', ()=>{
        for(const caja of seccionIndividual02){
            caja.style.display = 'none';
        }
        
        for(const caja of seccionIndividual01){
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