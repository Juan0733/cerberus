import {actualizarAprendiz, consultarAprendiz} from '../fetchs/aprendices-fetch.js';
import {consultarFicha, consultarFichas} from '../fetchs/fichas-fetch.js';

let contenedorModales;
let modalesExistentes;
let botonCerrarModal;
let funcionCallback;
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
let seccion01;
let seccion02;
let botonAtras;
let botonCancelar;
let botonRegistrar;
let botonSiguiente;
let urlBase;

const contenedorSpinner = document.getElementById('contenedor_spinner');

async function modalActualizacionAprendiz(aprendiz, callback, url) {
    try {
        contenedorSpinner.classList.add("mostrar_spinner");
        const response = await fetch(url+'app/views/inc/modales/modal-aprendiz.php');

        if(!response.ok) throw new Error('Hubo un error en la solicitud');

        const contenidoModal = await response.text();
        const modal = document.createElement('div');
            
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

        selectTipoDocumento = document.getElementById('tipo_documento');
        inputDocumento = document.getElementById('numero_documento');
        inputNombres =  document.getElementById('nombres');
        inputApellidos = document.getElementById('apellidos');
        inputTelefono = document.getElementById('telefono');
        inputCorreo =  document.getElementById('correo_electronico');
        inputFicha = document.getElementById('numero_ficha');
        inputPrograma = document.getElementById('nombre_programa');
        inputFechaFicha = document.getElementById('fecha_fin_ficha');
        seccion01 = document.getElementsByClassName('seccion-01');
        seccion02 = document.getElementsByClassName('seccion-02');
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
        dibujarFichas();
        eventoInputFicha();
        mostrarCampos();
        volverCampos();
        eventoActualizarAprendiz();
        dibujarAprendiz();

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
            mensaje: 'Error al cargar modal actualización aprendiz.'
        });
    }
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
                        
                    }else if(respuesta.titulo != 'Ficha No Encontrada'){
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