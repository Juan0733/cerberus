import {registrarAgenda} from '../fetchs/agenda-fetch.js'
import {modalRegistroVehiculo} from './modal-registro-vehiculo.js'

let tipoAgenda;
let contenedorModales;
let modalesExistentes;
let botonCerrarModal;
let modal;
let caja01;
let caja02;
let caja03;
let caja04;
let caja05;
let caja06;
let botonSiguiente;
let botonRegistrar;
let botonCancelar;
let botonAtras;
let tipoDocumento;
let titulo;
let motivo;
let correoElectronico;
let plantillaExcel;
let funcioCallback;
let urlBase;

async function modalRegistroAgenda(url, callback) {
    try {
        const response = await fetch(url+'app/views/inc/modales/modal-agenda.php');

        if(!response.ok) throw new Error('Hubo un error en la solicitud');

        const contenidoModal = await response.text();
        modal = document.createElement('div');
            
        modal.classList.add('contenedor-ppal-modal');
        modal.id = 'modal_agenda';
        modal.innerHTML = contenidoModal;
        contenedorModales = document.getElementById('contenedor_modales');
        contenedorModales.appendChild(modal);

        botonCerrarModal = document.getElementById('cerrar_modal_agenda');
        caja01 = document.getElementById('caja_01');
        caja02 = document.getElementById('caja_02');
        caja03 = document.getElementById('caja_03');
        caja04 = document.getElementById('caja_04');
        caja05 = document.getElementById('caja_05');
        caja06 = document.getElementById('caja_06');
        botonAtras = document.getElementById('btn_atras_agenda');
        botonCancelar = document.getElementById('btn_cancelar_agenda');
        botonSiguiente = document.getElementById('btn_siguiente_agenda');
        botonRegistrar = document.getElementById('btn_registrar_agenda');
        titulo = document.getElementById('titulo_agenda');
        motivo = document.getElementById('motivo');
        tipoDocumento = document.getElementById('tipo_documento');
        correoElectronico = document.getElementById('correo_electronico');
        plantillaExcel = document.getElementById('plantilla_excel');
        modalesExistentes = contenedorModales.getElementsByClassName('contenedor-ppal-modal');
        tipoAgenda = '';
        funcioCallback = callback;
        urlBase = url;

        contenedorModales.classList.add('mostrar');

        setTimeout(()=>{
           titulo.focus();
        }, 250)
        
        eventoCerrarModal();
        eventoTipoAgenda();
        eventoMostrarCampos();
        eventoVolverCampos();
        eventoAgregarVehiculo();
        eventoInputFile();
        eventoTextArea();
        eventoRegistrarAgenda();
           
    } catch (error) {
        if(botonCerrarModal){
            botonCerrarModal.click();
        }

        let respuesta = {
            titulo: 'Error Modal',
            mensaje: 'Error al cargar modal agenda.'
        }
        alertaError(respuesta);
    }
}
export{modalRegistroAgenda}

function eventoCerrarModal(){
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

        if(!motivo.reportValidity()){
            return;
        }

        const formData = new FormData();

        formData.append('titulo', titulo.value);
        formData.append('fecha_agenda', document.getElementById('fecha_agenda').value);
        formData.append('motivo', document.getElementById('motivo').value);

        if(tipoAgenda == 'individual'){
            formData.append('operacion', 'registrar_agenda_individual');
            formData.append('tipo_documento', tipoDocumento.value);
            formData.append('numero_documento', document.getElementById('documento_visitante').value);
            formData.append('nombres', document.getElementById('nombres').value);
            formData.append('apellidos', document.getElementById('apellidos').value);
            formData.append('correo_electronico', correoElectronico.value);
            formData.append('telefono', document.getElementById('telefono').value);

        }else if(tipoAgenda == 'grupal'){
            formData.append('operacion', 'registrar_agenda_grupal');
            formData.append('plantilla_excel', plantillaExcel.files[0])
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

    motivo.addEventListener('keyup', ()=>{
        clearTimeout(temporizador);
        temporizador = setTimeout(()=>{
            let patron = /^[A-Za-zñÑáéíóúÁÉÍÓÚüÜ0-9 ]{5,100}$/;
    
            if (!patron.test(motivo.value)){

                if(primeraValidacion){
                    motivo.setCustomValidity("Debes digitar solo números y letras, mínimo 5 y máximo 100 caracteres");
                    motivo.reportValidity();
                    primeraValidacion = false;
                }

            }else {
                motivo.setCustomValidity(""); 
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
    const botonAgregarVehiculo = document.getElementById('btn_agregar_vehiculo_individual');
    botonAgregarVehiculo.addEventListener('click', ()=>{
        modalRegistroVehiculo(urlBase, '', '', 'agendas');
    })

    document.getElementById('btn_agregar_vehiculo_grupal').addEventListener('click', ()=>{
        botonAgregarVehiculo.click();
    })
}

function eventoMostrarCampos(){
    botonSiguiente.addEventListener('click', ()=>{
        if(caja01.style.display != 'none'){
            const inputsSeccion01 = document.querySelectorAll('.campo-seccion-01');
            let validos = true;

            for(const input of inputsSeccion01) {
                if(!input.checkValidity()){
                    input.reportValidity();
                    validos = false;
                    break;
                }
            };

            if(validos && tipoAgenda){

                if(!motivo.reportValidity()){
                    return;
                }

                caja01.style.display = 'none';
                botonCancelar.style.display = 'none';
                botonAtras.style.display = 'flex';

                if(tipoAgenda == 'individual'){
                    const inputsVisitante = document.querySelectorAll('.campo-visitante');
                    inputsVisitante.forEach(input => {
                        input.setAttribute('required', '');
                    });

                    plantillaExcel.removeAttribute('required');

                    caja03.style.display = 'flex';
                    caja04.style.display = 'flex';
                    tipoDocumento.focus();

                    if(window.innerWidth > 768){
                        caja05.style.display = 'flex';
                        caja06.style.display = 'flex';
                        botonSiguiente.style.display = 'none';
                        botonRegistrar.style.display = 'flex';
                        modal.style.width = 'auto';
                    }
                
                }else if(tipoAgenda == 'grupal'){
                    const inputsVisitante = document.querySelectorAll('.campo-visitante');
                    inputsVisitante.forEach(input => {
                        input.removeAttribute('required');
                    });

                    plantillaExcel.setAttribute('required', '')
                    
                    caja02.style.display = 'flex';
                    botonSiguiente.style.display = 'none';
                    botonRegistrar.style.display = 'flex';
                }
            }

        }else{
            const inputsSeccion02 = document.querySelectorAll('.campo-seccion-02');
            let validos = true;

            for(const input of inputsSeccion02) {
                if(!input.checkValidity()){
                    input.reportValidity();
                    validos = false;
                    break;
                }
            };

            if(validos){
                caja03.style.display = 'none';
                caja04.style.display = 'none';
                caja05.style.display = 'flex';
                caja06.style.display = 'flex';
                botonSiguiente.style.display = 'none';
                botonRegistrar.style.display = 'flex';

                correoElectronico.focus();
            }
        }
    })
}

function eventoVolverCampos(){
    botonAtras.addEventListener('click', ()=>{
        if(caja02.style.display == 'flex'){
            caja02.style.display = 'none';
            botonAtras.style.display = 'none';
            botonRegistrar.style.display = 'none';
            caja01.style.display = 'flex';
            botonCancelar.style.display = 'flex';
            botonSiguiente.style.display = 'flex';

            titulo.focus();

        }else if(caja03.style.display == 'flex'){
            caja03.style.display = 'none';
            caja04.style.display = 'none';
            botonAtras.style.display = 'none';
            botonRegistrar.style.display = 'none';
            caja01.style.display = 'flex';
            botonCancelar.style.display = 'flex';
            botonSiguiente.style.display = 'flex';

            if(caja05.style.display == 'flex'){
                caja05.style.display = 'none';
                caja06.style.display = 'none';
                modal.style.width = 'clamp(350px, 32%, 600px)';
            }

            titulo.focus();

        }else if(caja03.style.display == 'none' && caja05.style.display == 'flex'){
            caja05.style.display = 'none';
            caja06.style.display = 'none';
            botonRegistrar.style.display = 'none';
            caja03.style.display = 'flex';
            caja04.style.display = 'flex';
            botonSiguiente.style.display = 'flex';

            tipoDocumento.focus();
        }
    })
}

function eventoInputFile(){
    const nombreArchivo = document.getElementById('nombre_archivo');

    plantillaExcel.addEventListener('change', ()=>{
        if(plantillaExcel.files.length > 0){
            nombreArchivo.textContent = plantillaExcel.files[0].name;
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



