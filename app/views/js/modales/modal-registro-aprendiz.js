import {registrarAprendiz} from '../fetchs/aprendices-fetch.js';
import {consultarFicha, consultarFichas} from '../fetchs/fichas-fetch.js';
import { consultarModalAprendiz } from '../fetchs/modal-fetch.js';

let tipoRegistro;
let contenedorModales;
let modalesExistentes;
let botonCerrarModal;
let modal;
let contenedorCajas;
let seccionPrincipal;
let seccionIndividual;
let seccionIndividual01;
let seccionIndividual02;
let seccionMasiva;
let selectTipoDocumento;
let inputCorreo;
let inputPlantillaExcel;
let botonAtras;
let botonCancelar;
let botonRegistrar;
let botonSiguiente;
let funcionCallback;
let urlBase;

function modalRegistroAprendiz(callback, url) {
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
            seccionPrincipal = document.getElementsByClassName('seccion-principal');
            seccionIndividual = document.getElementsByClassName('seccion-individual');
            seccionIndividual01 = document.getElementsByClassName('seccion-individual-01');
            seccionIndividual02 = document.getElementsByClassName('seccion-individual-02');
            seccionMasiva = document.getElementsByClassName('seccion-masiva');
            selectTipoDocumento = document.getElementById('tipo_documento');
            inputCorreo = document.getElementById('correo_electronico');
            inputPlantillaExcel = document.getElementById('plantilla_excel');
            botonCancelar = document.getElementById('btn_cancelar_aprendiz');
            botonAtras = document.getElementById('btn_atras_aprendiz');
            botonSiguiente = document.getElementById('btn_siguiente_aprendiz');
            botonRegistrar = document.getElementById('btn_registrar_aprendiz');

            funcionCallback = callback;
            urlBase = url;

            eventoCerrarModal();
            eventoTipoRegistro();
            eventoInputFicha();
            eventoInputFile();
            mostrarCampos();
            volverCampos();
            eventoRegistrarAprendiz();

            contenedorModales.classList.add('mostrar');

            setTimeout(()=>{
                selectTipoDocumento.focus();
            }, 250)

        }else if(respuesta.tipo == 'ERROR'){
            alertaError(respuesta);
        }
    })
}
export { modalRegistroAprendiz };

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

function eventoTipoRegistro() {
    const inputsCheckbox = document.querySelectorAll('.checkbox');
    const iconosTipoRegistro = document.querySelectorAll('.icono-tipo-registro');

    inputsCheckbox.forEach(checkbox => {
        checkbox.addEventListener('change', ()=>{
            iconosTipoRegistro.forEach(icono => {
                icono.removeAttribute('style');
            });

            if (checkbox.checked){
                tipoRegistro = checkbox.value;
                for(const icono of iconosTipoRegistro){
                    if(icono.id == 'icono_'+tipoRegistro){
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
                tipoRegistro = '';
            }
        })
    });
}

function dibujarFichas(){
    const dataListFichas = document.getElementById('lista_fichas');
    consultarFichas(urlBase).then(respuesta=>{
        if(respuesta.tipo == 'OK' || (respuesta.tipo == 'ERROR' && respuesta.titulo == 'Datos No Encontrados')){
            const fichas = respuesta.fichas ?? [];

            fichas.forEach(ficha => {
                dataListFichas.innerHTML += `
                    <option value="${ficha.numero_ficha}">
                    `;
            });

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

function eventoInputFicha(){
    const inputFicha = document.getElementById('numero_ficha');
    const inputPrograma = document.getElementById('nombre_programa');
    const inputFechaFicha = document.getElementById('fecha_fin_ficha');

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

function eventoRegistrarAprendiz(){
    let formularioAprendiz = document.getElementById('formulario_aprendiz');
    formularioAprendiz.addEventListener('submit', (e)=>{
        e.preventDefault();

        let formData = new FormData(formularioAprendiz);

        if(tipoRegistro == 'individual'){
            formData.append('operacion', 'registrar_aprendiz_individual');
            formData.append('tipo_documento', selectTipoDocumento.value);
            formData.append('numero_documento', document.getElementById('numero_documento').value);
            formData.append('nombres', document.getElementById('nombres').value);
            formData.append('apellidos', document.getElementById('apellidos').value);
            formData.append('correo_electronico', inputCorreo.value);
            formData.append('telefono', document.getElementById('telefono').value);
            formData.append('numero_ficha', document.getElementById('numero_ficha').value);
            formData.append('nombre_programa', document.getElementById('nombre_programa').value);
            formData.append('fecha_fin_ficha', document.getElementById('fecha_fin_ficha').value);

        }else if(tipoRegistro == 'carga_masiva'){
            formData.append('operacion', 'registrar_aprendiz_carga_masiva');
            formData.append('plantilla_excel', inputPlantillaExcel.files[0]);
        }
       
        registrarAprendiz(formData, urlBase).then(respuesta=>{
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
    const inputsSeccionIndividual = document.getElementsByClassName('campo-individual');
    const inputsSeccionIndividual01 = document.getElementsByClassName('campo-individual-01');

    botonSiguiente.addEventListener('click', ()=>{
        if(seccionPrincipal[0].style.display != 'none'){
            if(tipoRegistro){
                for(const caja of seccionPrincipal){
                    caja.style.display = 'none';
                }

                if(tipoRegistro == 'individual'){
                    dibujarFichas();

                    if(window.innerWidth >= 768){
                        for(const caja of seccionIndividual){
                            caja.style.display = 'block'
                        }

                        botonSiguiente.style.display = 'none';
                        botonRegistrar.style.display = 'flex';
                        modal.style.width = 'clamp(550px, 50%, 980px)';
                        contenedorCajas.style.gridTemplateColumns = 'repeat(2, 1fr)';

                    }else if(window.innerWidth <= 767){
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
                
                }else if(tipoRegistro == 'carga_masiva'){
                    for(const caja of seccionMasiva){
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
        if(seccionMasiva[0].style.display == 'flex'){
            for(const caja of seccionMasiva){
                caja.style.display = 'none';
            }

            for(const caja of seccionPrincipal){
                caja.style.display = 'flex';
            }

            botonAtras.style.display = 'none';
            botonRegistrar.style.display = 'none';
            botonCancelar.style.display = 'flex';
            botonSiguiente.style.display = 'flex';

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
                caja.style.display = 'flex';
            }
        
            botonAtras.style.display = 'none';
            botonRegistrar.style.display = 'none';
            botonCancelar.style.display = 'flex';
            botonSiguiente.style.display = 'flex';

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