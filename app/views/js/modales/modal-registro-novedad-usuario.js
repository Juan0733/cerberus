import {registrarNovedadUsuario} from '../fetchs/novedades-usuarios-fetch.js';

let contenedorModales;
let modalesExistentes;
let botonCerrarModal;
let funcionCallback;
let urlBase;

const contenedorSpinner = document.getElementById('contenedor_spinner');

async function modalRegistroNovedadUsuario(url, novedad, documento, callback=false) {
    try {
        contenedorSpinner.classList.add("mostrar_spinner");
        const response = await fetch(url+'app/views/inc/modales/modal-novedad-usuario.php');

        if(!response.ok) throw new Error('Hubo un error en la solicitud');

        const contenidoModal = await response.text();
        const modal = document.createElement('div');
            
        modal.classList.add('contenedor-ppal-modal');
        modal.id = 'modal_novedad_usuario';
        modal.innerHTML = contenidoModal;
        contenedorModales = document.getElementById('contenedor_modales');
        contenedorModales.appendChild(modal);

        const inputDocumento = document.getElementById('documento_involucrado'); 
        const inputTipoNovedad = document.getElementById('tipo_novedad');

        inputDocumento.value = documento;
        inputDocumento.readOnly = true;
        inputTipoNovedad.value = novedad;
        inputTipoNovedad.readOnly = true;

        if(callback){
            funcionCallback = callback;
        }

        urlBase = url;

        eventoCerrarModal();
        eventoTextArea();
        eventoRegistrarNovedadUsuario();

        contenedorSpinner.classList.remove("mostrar_spinner");
        modalesExistentes = contenedorModales.getElementsByClassName('contenedor-ppal-modal');
        if(modalesExistentes.length > 1){
            modalesExistentes[modalesExistentes.length-2].style.display = 'none';
        }else{
            contenedorModales.classList.add('mostrar');
        }

        setTimeout(()=>{
            document.getElementById('fecha_suceso').focus();
        }, 250)

    } catch (error) {
        contenedorSpinner.classList.remove("mostrar_spinner");

        if(botonCerrarModal){
            botonCerrarModal.click();
        }

       console.error('Hubo un error:', error);
        alertaError({
            titulo: 'Error Modal',
            mensaje: 'Error al cargar modal registro novedad usuario.'
        });
    }
    
}
export { modalRegistroNovedadUsuario };

function eventoCerrarModal(){
    botonCerrarModal = document.getElementById('cerrar_modal_novedad_usuario');

    botonCerrarModal.addEventListener('click', ()=>{
        modalesExistentes[modalesExistentes.length-1].remove();
        if(modalesExistentes.length > 0) {
            modalesExistentes[modalesExistentes.length-1].style.display = 'block';
        }else{
            contenedorModales.classList.remove('mostrar');
        }
    });

    document.getElementById('btn_cancelar_novedad_usuario').addEventListener('click', ()=>{
        botonCerrarModal.click();
    });
}

function eventoRegistrarNovedadUsuario(){
    let formularioNovedad = document.getElementById('formulario_novedad_usuario');
    formularioNovedad.addEventListener('submit', (e)=>{
        e.preventDefault();

        let formData = new FormData(formularioNovedad);
        formData.append('operacion', 'registrar_novedad_usuario');

        registrarNovedadUsuario(formData, urlBase).then(respuesta=>{
            if(respuesta.tipo == "OK" ){
                alertaExito(respuesta);
                botonCerrarModal.click();
                if(funcionCallback){
                    funcionCallback();
                }
                
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
            let patron = /^[A-Za-zñÑáéíóúÁÉÍÓÚüÜ0-9 ]{5,100}$/;
    
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



