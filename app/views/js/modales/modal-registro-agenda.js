import {registrarAgenda} from '../fetchs/agenda-fetch.js'

let tipoAgenda;
let contenedorModales;
let modalesExistentes;
let botonCerrarModal;
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
let correoElectronico;
let plantillaExcel;
let funcioCallback;
let urlBase;

async function modalRegistroAgenda(url, callback) {
    try {
        const response = await fetch(url+'app/views/inc/modales/modal-agenda.php');

        if(!response.ok) throw new Error('Hubo un error en la solicitud');

        const contenidoModal = await response.text();
        const modal = document.createElement('div');
            
        modal.classList.add('contenedor-ppal-modal');
        modal.innerHTML = contenidoModal;
        contenedorModales = document.getElementById('contenedor-modales');
        contenedorModales.appendChild(modal);

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
        titulo =  document.getElementById('titulo');
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
        
        eventoTipoAgenda();
        eventoMostrarCampos();
        eventoVolverCampos();
        eventoInputFile();
        eventoRegistrarAgenda();
        eventoCerrarModal();
           
    } catch (error) {
        console.error('hubo un error:', error)
        let respuesta = {
            titulo: 'Error Modal',
            mensaje: 'Error al cargar modal agenda.'
        }
        alertaError(respuesta);
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
            if(respuesta.tipo == 'ERROR'){
                alertaError(respuesta);

            }else if(respuesta.tipo == 'OK'){
                alertaExito(respuesta);
                botonCerrarModal.click();
                funcioCallback();
            }
        })

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



