import {actualizarAprendiz, consultarAprendiz} from '../fetchs/aprendices-fetch.js';
import {consultarFicha, consultarFichas} from '../fetchs/fichas-fetch.js';
import { consultarModalAprendiz } from '../fetchs/modal-fetch.js';

let contenedorModales;
let modalesExistentes;
let botonCerrarModal;
let modal;
let contenedorCajas;
let seccionIndividual01;
let seccionIndividual02;
let documentoAprendiz;
let selectTipoDocumento;
let inputDocumento;
let inputNombres;
let inputApellidos;
let inputTelefono;
let inputCorreo;
let inputFicha;
let inputPrograma;
let inputFechaFicha;
let botonAtras;
let botonCancelar;
let botonRegistrar;
let botonSiguiente;
let funcionCallback;
let urlBase;

function modalActualizacionAprendiz(aprendiz, callback, url) {
    consultarModalAprendiz(url).then(respuesta=>{
        if(respuesta.tipo == 'OK'){
            const contenidoModal = respuesta.modal;
            modal = document.createElement('div');
                
            modal.classList.add('contenedor-ppal-modal');
            modal.id = 'modal_aprendiz';
            modal.innerHTML = contenidoModal;
            contenedorModales = document.getElementById('contenedor_modales');

            modalesExistentes = contenedorModales.getElementsByClassName('contenedor-ppal-modal');
            if(modalesExistentes.length > 0){
            for (let i = 0; i < modalesExistentes.length; i++) {
                    modalesExistentes[i].remove();
                }
            }

            contenedorModales.appendChild(modal);

            contenedorCajas = document.getElementById('contenedor_cajas_aprendiz');
            seccionIndividual01 = document.getElementsByClassName('seccion-individual-01');
            seccionIndividual02 = document.getElementsByClassName('seccion-individual-02');
            selectTipoDocumento = document.getElementById('tipo_documento');
            inputDocumento = document.getElementById('numero_documento');
            inputNombres =  document.getElementById('nombres');
            inputApellidos = document.getElementById('apellidos');
            inputTelefono = document.getElementById('telefono');
            inputCorreo =  document.getElementById('correo_electronico');
            inputFicha = document.getElementById('numero_ficha');
            inputPrograma = document.getElementById('nombre_programa');
            inputFechaFicha = document.getElementById('fecha_fin_ficha');
            botonCancelar = document.getElementById('btn_cancelar_aprendiz');
            botonAtras = document.getElementById('btn_atras_aprendiz');
            botonSiguiente = document.getElementById('btn_siguiente_aprendiz');
            botonRegistrar = document.getElementById('btn_registrar_aprendiz');

            botonRegistrar.textContent = 'Actualizar';
            document.getElementById('titulo_modal_aprendiz').textContent = 'Actualizar Aprendiz';
            
            documentoAprendiz = aprendiz;
            funcionCallback = callback;
            urlBase = url;

            eventoCerrarModal();
            mostrarSeccionIndividual();
            dibujarFichas();
            eventoInputFicha();
            mostrarCampos();
            volverCampos();
            eventoActualizarAprendiz();
            dibujarAprendiz();

            setTimeout(()=>{
            selectTipoDocumento.focus();
            }, 250)

        }else if(respuesta.tipo == 'ERROR'){
            alertaError(respuesta);
        }
    })
}
export { modalActualizacionAprendiz };

function eventoCerrarModal(){
    botonCerrarModal = document.getElementById('cerrar_modal_aprendiz');

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
}

function dibujarAprendiz(){
    consultarAprendiz(documentoAprendiz, urlBase).then(respuesta=>{
        if(respuesta.tipo == 'OK'){
            const datosAprendiz = respuesta.datos_aprendiz;
            selectTipoDocumento.value = datosAprendiz.tipo_documento;
            selectTipoDocumento.disabled = true;
            inputDocumento.value = datosAprendiz.numero_documento;
            inputDocumento.readOnly = true;
            inputNombres.value = datosAprendiz.nombres;
            inputApellidos.value = datosAprendiz.apellidos;
            inputTelefono.value = datosAprendiz.telefono;
            inputCorreo.value = datosAprendiz.correo_electronico;
            inputFicha.value = datosAprendiz.numero_ficha;
            inputPrograma.value = datosAprendiz.nombre_programa;
            inputFechaFicha.value = datosAprendiz.fecha_fin_ficha;

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

function dibujarFichas(){
    const dataListFichas = document.getElementById('lista_fichas');
    consultarFichas(urlBase).then(respuesta=>{
        if(respuesta.tipo == 'OK'){
            respuesta.fichas.forEach(ficha => {
                dataListFichas.innerHTML += `
                    <option value="${ficha.numero_ficha}">
                    `
            });

        }else if(respuesta.tipo == 'ERROR'){
            alertaError(respuesta);
        }
    })
}

function eventoInputFicha(){
    inputFicha.addEventListener('change', ()=>{
        if(inputFicha.checkValidity()){
            consultarFicha(inputFicha.value, urlBase).then(respuesta=>{
                if(respuesta.tipo == 'OK'){
                    inputPrograma.value = respuesta.datos_ficha.nombre_programa;
                    inputFechaFicha.value = respuesta.datos_ficha.fecha_fin_ficha;

                }else if(respuesta.tipo == 'ERROR'){
                    if(respuesta.titulo == 'Sesión Expirada'){
                        window.location.replace(urlBase+'sesion-expirada');
                        
                    }else if(respuesta.titulo == 'Ficha No Encontrada'){
                        inputPrograma.value = '';
                        inputFechaFicha.value = '';

                    }else{
                        alertaError(respuesta);
                    }
                }
            })

        }else{
            inputFicha.reportValidity();
        }
        
    })
}

function eventoActualizarAprendiz(){
    let formularioAprendiz = document.getElementById('formulario_aprendiz');
    formularioAprendiz.addEventListener('submit', (e)=>{
        e.preventDefault();

        let formData = new FormData();
        formData.append('operacion', 'actualizar_aprendiz');
        formData.append('numero_documento', inputDocumento.value);
        formData.append('nombres', inputNombres.value);
        formData.append('apellidos', inputApellidos.value);
        formData.append('telefono', inputTelefono.value);
        formData.append('correo_electronico', inputCorreo.value);
        formData.append('numero_ficha', inputFicha.value);
        formData.append('nombre_programa', inputPrograma.value);
        formData.append('fecha_fin_ficha', inputFechaFicha.value);

        actualizarAprendiz(formData, urlBase).then(respuesta=>{
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