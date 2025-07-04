import {registrarAgenda} from '../fetchs/agenda-fetch.js'
import {modalRegistroVehiculo} from './modal-registro-vehiculo.js'

let tipoAgenda;
let contenedorModales;
let modalesExistentes;
let botonCerrarModal;
let modal;
let contenedorCajas;
let seccionPrincipal;
let seccionIndividual;
let seccionIndividual01;
let seccionIndividual02;
let seccionGrupal;
let botonAtras;
let selectTipoDocumento;
let inputTitulo;
let textAreaMotivo;
let inputCorreo;
let inputPlantillaExcel;
let botonSiguiente;
let botonRegistrar;
let botonCancelar;
let funcioCallback;
let urlBase;

const contenedorSpinner = document.getElementById('contenedor_spinner');

async function modalRegistroAgenda(url, callback) {
    try {
        contenedorSpinner.classList.add("mostrar_spinner");
        const response = await fetch(url+'app/views/inc/modales/modal-agenda.php');

        if(!response.ok) throw new Error('Hubo un error en la solicitud');

        const contenidoModal = await response.text();
       
        modal = document.createElement('div');
            
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

        contenedorCajas = document.getElementById('contenedor_cajas_agenda');
        seccionPrincipal = document.getElementsByClassName('seccion-principal');
        seccionIndividual = document.getElementsByClassName('seccion-individual');
        seccionIndividual01 = document.getElementsByClassName('seccion-individual-01');
        seccionIndividual02 = document.getElementsByClassName('seccion-individual-02');
        seccionGrupal = document.getElementsByClassName('seccion-grupal');
        selectTipoDocumento = document.getElementById('tipo_documento_agendado');
        inputTitulo = document.getElementById('titulo_agenda');
        textAreaMotivo = document.getElementById('motivo');
        inputCorreo = document.getElementById('correo_electronico_agendado');
        inputPlantillaExcel = document.getElementById('plantilla_excel');
        botonAtras = document.getElementById('btn_atras_agenda');
        botonCancelar = document.getElementById('btn_cancelar_agenda');
        botonSiguiente = document.getElementById('btn_siguiente_agenda');
        botonRegistrar = document.getElementById('btn_registrar_agenda');
       
        tipoAgenda = '';
        funcioCallback = callback;
        urlBase = url;
        
        eventoCerrarModal();
        eventoTipoAgenda();
        eventoMostrarCampos();
        eventoVolverCampos();
        eventoAgregarVehiculo();
        eventoInputFile();
        eventoTextArea();
        eventoRegistrarAgenda();

        contenedorSpinner.classList.remove("mostrar_spinner");
        contenedorModales.classList.add('mostrar');

        setTimeout(()=>{
           inputTitulo.focus();
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
export{modalRegistroAgenda}

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

function eventoRegistrarAgenda(){
    document.getElementById('formulario_agenda').addEventListener('submit', (e)=>{
        e.preventDefault();

        const formData = new FormData();

        formData.append('titulo', inputTitulo.value);
        formData.append('fecha_agenda', document.getElementById('fecha_agenda').value);
        formData.append('motivo', textAreaMotivo.value);

        if(tipoAgenda == 'individual'){
            formData.append('operacion', 'registrar_agenda_individual');
            formData.append('tipo_documento', inputTipoDocumento.value);
            formData.append('numero_documento', document.getElementById('documento_agendado').value);
            formData.append('nombres', document.getElementById('nombres_agendado').value);
            formData.append('apellidos', document.getElementById('apellidos_agendado').value);
            formData.append('correo_electronico', inputCorreo.value);
            formData.append('telefono', document.getElementById('telefono_agendado').value);

        }else if(tipoAgenda == 'grupal'){
            formData.append('operacion', 'registrar_agenda_grupal');
            formData.append('plantilla_excel', inputPlantillaExcel.files[0])
        }

        registrarAgenda(formData, urlBase).then(respuesta=>{
            if(respuesta.tipo == 'OK'){
                botonCerrarModal.click();
                alertaExito(respuesta);
                funcioCallback();

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
            let patron = /^[A-Za-zñÑáéíóúÁÉÍÓÚüÜ0-9., ]{5,150}$/;
    
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

function eventoTipoAgenda() {
    const inputsCheckbox = document.querySelectorAll('.checkbox');

    inputsCheckbox.forEach(checkbox => {
        checkbox.addEventListener('change', ()=>{
            if (checkbox.checked){
                tipoAgenda = checkbox.value;
                inputsCheckbox.forEach(input => {
                    if(input != checkbox){
                        input.checked = false;
                    }
                });

            }else{
                tipoAgenda = '';
            }
        })
    });
}

function eventoAgregarVehiculo(){
    const botonAgregarVehiculo = document.getElementById('btn_agregar_vehiculo');
    botonAgregarVehiculo.addEventListener('click', ()=>{
        modalRegistroVehiculo(urlBase, '', '');
    })
}

function eventoMostrarCampos(){
    const inputsSeccionPrincipal = document.getElementsByClassName('campo-principal');
    const inputsSeccionIndividual = document.getElementsByClassName('campo-individual');
    const inputsSeccionIndividual01 = document.getElementsByClassName('campo-individual-01');

    botonSiguiente.addEventListener('click', ()=>{
        if(seccionPrincipal[0].style.display != 'none'){
            let validos = true;

            for(const input of inputsSeccionPrincipal) {
                if(!input.checkValidity()){
                    input.reportValidity();
                    validos = false;
                    break;
                }
            };

            if(validos && tipoAgenda){
                if(!textAreaMotivo.reportValidity()){
                    return;
                }

                if(tipoAgenda == 'individual'){
                    for(const caja of seccionPrincipal){
                        caja.style.display = 'none';
                    }

                    for(const input of inputsSeccionIndividual){
                        input.required = true;
                    }

                    inputPlantillaExcel.required = false;

                    if(window.innerWidth > 768){
                        for(const caja of seccionIndividual){
                            if(caja.id == 'btn_agregar_vehiculo'){
                                caja.style.display = 'flex';
                                continue;
                            }

                            caja.style.display = 'block'
                        }

                        botonSiguiente.style.display = 'none';
                        botonRegistrar.style.display = 'flex';
                        modal.style.width = 'clamp(550px, 50%, 980px)';
                        contenedorCajas.style.gridTemplateColumns = 'repeat(2, 1fr)';

                    }else{
                        for(const caja of seccionIndividual01){
                            caja.style.display = 'block'
                        }
                    }

                    botonCancelar.style.display = 'none';
                    botonAtras.style.display = 'flex';

                    selectTipoDocumento.focus();
                
                }else if(tipoAgenda == 'grupal'){
                    for(const caja of seccionPrincipal){
                        caja.style.display = 'none';
                    }

                    for(const input of inputsSeccionIndividual){
                        input.required = false;
                    }

                    inputPlantillaExcel.required = true;
                    
                    for(const caja of seccionGrupal){
                        caja.style.display = 'flex';
                    }
                   
                    botonSiguiente.style.display = 'none';
                    botonRegistrar.style.display = 'flex';
                    botonCancelar.style.display = 'none';
                    botonAtras.style.display = 'flex';

                    inputPlantillaExcel.focus();
                }
            }

        }else if(seccionIndividual01[0].style.display == 'block' && seccionIndividual02[0].style.display != 'block'){
            let validos = true;

            for(const input of inputsSeccionIndividual01) {
                if(!input.checkValidity()){
                    input.reportValidity();
                    validos = false;
                    break;
                }
            };

            if(validos){
                for(const caja of seccionIndividual01){
                    caja.style.display = 'none';
                }

                for(const caja of seccionIndividual02){
                    if(caja.id == 'btn_agregar_vehiculo'){
                        caja.style.display = 'flex';
                        continue;
                    }

                    caja.style.display = 'block';
                }

                botonSiguiente.style.display = 'none';
                botonRegistrar.style.display = 'flex';

                inputCorreo.focus();
            }
        }
    })
}

function eventoVolverCampos(){
    botonAtras.addEventListener('click', ()=>{
        if(seccionGrupal[0].style.display == 'flex'){
            for(const caja of seccionGrupal){
                caja.style.display = 'none';
            }

            for(const caja of seccionPrincipal){
                if(caja.id == 'contenedor_checkbox'){
                    caja.style.display = 'flex';
                    continue;
                }

                caja.style.display = 'block';
            }

            botonAtras.style.display = 'none';
            botonRegistrar.style.display = 'none';
            botonCancelar.style.display = 'flex';
            botonSiguiente.style.display = 'flex';

            inputTitulo.focus();

        }else if(seccionIndividual01[0].style.display == 'block'){
            if(window.innerWidth > 768){
                for(const caja of seccionIndividual){
                    caja.style.display = 'none';
                }

                modal.style.width = 'clamp(350px, 32%, 600px)';
                contenedorCajas.style.gridTemplateColumns = 'repeat(1, 1fr)';

            }else{
                for(const caja of seccionIndividual01){
                    caja.style.display = 'none';
                }
            }

             for(const caja of seccionPrincipal){
                if(caja.id == 'contenedor_checkbox'){
                    caja.style.display = 'flex';
                    continue;
                }
                
                caja.style.display = 'block';
            }
        
            botonAtras.style.display = 'none';
            botonRegistrar.style.display = 'none';
            botonCancelar.style.display = 'flex';
            botonSiguiente.style.display = 'flex';

            inputTitulo.focus();

        }else if(seccionIndividual01[0].style.display == 'none' && seccionIndividual02[0].style.display == 'block'){
            for(const caja of seccionIndividual02){
                caja.style.display = 'none';
            }

            for(const caja of seccionIndividual01){
                caja.style.display = 'block';
            }

            botonRegistrar.style.display = 'none';
            botonSiguiente.style.display = 'flex';

            selectTipoDocumento.focus();
        }
    })
}

function eventoInputFile(){
    const nombreArchivo = document.getElementById('nombre_archivo');

    inputPlantillaExcel.addEventListener('change', ()=>{
        if(inputPlantillaExcel.files.length > 0){
            nombreArchivo.textContent = inputPlantillaExcel.files[0].name;
        }else{
            nombreArchivo.textContent = "Seleccionar archivo"
        }
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
            popup: 'alerta-contenedor',
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



