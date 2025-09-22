import {registrarAgenda} from '../fetchs/agenda-fetch.js'
import { consultarModalAgenda } from '../fetchs/modal-fetch.js';
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
let seccionCargaMasiva;
let selectTipoDocumento;
let inputTitulo;
let textAreaMotivo;
let inputCorreo;
let inputPlantillaExcel;
let botonSiguiente;
let botonRegistrar;
let botonCancelar;
let botonAtras;
let funcioCallback;
let urlBase;

function modalRegistroAgenda(url, callback) {
    consultarModalAgenda(url).then(respuesta=>{
        if(respuesta.tipo == 'OK'){
            const contenidoModal = respuesta.modal;
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
            seccionCargaMasiva = document.getElementsByClassName('seccion-carga-masiva');
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
            mostrarCampos();
            volverCampos();
            eventoAgregarVehiculo();
            eventoInputFile();
            eventoTextArea();
            eventoRegistrarAgenda();

            contenedorModales.classList.add('mostrar');

            setTimeout(()=>{
            inputTitulo.focus();
            }, 250)

        }else if(respuesta.tipo == 'ERROR'){
            alertaError(respuesta);
        }
    })
}
export{modalRegistroAgenda}

function eventoCerrarModal(){
    botonCerrarModal = document.getElementById('cerrar_modal_agenda');
    
    botonCerrarModal.addEventListener('click', ()=>{
        modalesExistentes[modalesExistentes.length-1].remove();
        contenedorModales.classList.remove('mostrar');
    });

    botonCancelar.addEventListener('click', ()=>{
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
            formData.append('tipo_documento', selectTipoDocumento.value);
            formData.append('numero_documento', document.getElementById('documento_agendado').value);
            formData.append('nombres', document.getElementById('nombres_agendado').value);
            formData.append('apellidos', document.getElementById('apellidos_agendado').value);
            formData.append('correo_electronico', inputCorreo.value);
            formData.append('telefono', document.getElementById('telefono_agendado').value);

        }else if(tipoAgenda == 'carga_masiva'){
            formData.append('operacion', 'registrar_agenda_carga_masiva');
            formData.append('plantilla_excel', inputPlantillaExcel.files[0])
        }

        registrarAgenda(formData, urlBase).then(respuesta=>{
            if(respuesta.tipo == 'OK'){
                alertaExito(respuesta);
                funcioCallback();
                botonCerrarModal.click();

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
    const patron = /^[A-Za-zñÑáéíóúÁÉÍÓÚüÜ0-9., ]{5,100}$/;

    textAreaMotivo.addEventListener('keyup', ()=>{    
        textAreaMotivo.setCustomValidity("");

        if (!patron.test(textAreaMotivo.value)){
            textAreaMotivo.setCustomValidity("Debes digitar solo números y/o letras, mínimo 5 y máximo 100 caracteres");
            textAreaMotivo.reportValidity();
        }
    })
}

function eventoTipoAgenda() {
    const inputsCheckbox = document.querySelectorAll('.checkbox');
    const iconosTipoAgenda = document.querySelectorAll('.icono-tipo-agenda');

    inputsCheckbox.forEach(checkbox => {
        checkbox.addEventListener('change', ()=>{
            iconosTipoAgenda.forEach(icono => {
                icono.removeAttribute('style');
            });

            if (checkbox.checked){
                tipoAgenda = checkbox.value;
                for(const icono of iconosTipoAgenda){
                    if(icono.id == 'icono_'+tipoAgenda){
                        icono.style.color = 'var(--color-secundario)';
                        break;
                    }
                }

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

function mostrarCampos(){
    const inputsSeccionPrincipal = document.getElementsByClassName('campo-principal');
    const inputsSeccionIndividual = document.getElementsByClassName('campo-individual');
    const inputsSeccionIndividual01 = document.getElementsByClassName('campo-individual-01');

    botonSiguiente.addEventListener('click', ()=>{
        if(seccionPrincipal[0].style.display != 'none'){
            let camposValidos = true;
            for(const input of inputsSeccionPrincipal) {
                if(!input.checkValidity()){
                    input.reportValidity();
                    camposValidos = false;
                    break;
                }
            };

            if(camposValidos && tipoAgenda){
                if(!textAreaMotivo.reportValidity()){
                    return;
                }

                for(const caja of seccionPrincipal){
                    caja.style.display = 'none';
                }

                if(tipoAgenda == 'individual'){
                    if(window.innerWidth >= 768){
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

                    }else if(window.innerWidth < 768){
                        for(const caja of seccionIndividual01){
                            caja.style.display = 'block'
                        }
                    }

                    for(const input of inputsSeccionIndividual){
                        input.required = true;
                    }
                    inputPlantillaExcel.required = false;

                    botonCancelar.style.display = 'none';
                    botonAtras.style.display = 'flex';

                    selectTipoDocumento.focus();
                
                }else if(tipoAgenda == 'carga_masiva'){
                    for(const caja of seccionCargaMasiva){
                        caja.style.display = 'flex';
                    }

                    for(const input of inputsSeccionIndividual){
                        input.required = false;
                    }
                    inputPlantillaExcel.required = true;
                   
                    botonSiguiente.style.display = 'none';
                    botonRegistrar.style.display = 'flex';
                    botonCancelar.style.display = 'none';
                    botonAtras.style.display = 'flex';

                    inputPlantillaExcel.focus();
                }
            }

        }else if(seccionIndividual01[0].style.display == 'block' && seccionIndividual02[0].style.display != 'block'){
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

function volverCampos(){
    botonAtras.addEventListener('click', ()=>{
        if(seccionCargaMasiva[0].style.display == 'flex'){
            for(const caja of seccionCargaMasiva){
                caja.style.display = 'none';
            }

            for(const caja of seccionPrincipal){
                if(caja.classList.contains('caja-checkbox')){
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
            if(window.innerWidth >= 768){
                for(const caja of seccionIndividual){
                    caja.style.display = 'none';
                }

                modal.style.width = 'clamp(350px, 32%, 600px)';
                contenedorCajas.style.gridTemplateColumns = 'repeat(1, 1fr)';

            }else if(window.innerWidth <= 767){
                for(const caja of seccionIndividual01){
                    caja.style.display = 'none';
                }
            }

            for(const caja of seccionPrincipal){
                if(caja.classList.contains('caja-checkbox')){
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



