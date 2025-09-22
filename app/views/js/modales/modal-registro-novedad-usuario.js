import { consultarModalNovedadUsuario } from '../fetchs/modal-fetch.js';
import { consultarUltimoMovimientoUsuario } from '../fetchs/movimientos-fetch.js';
import {registrarNovedadUsuario} from '../fetchs/novedades-usuarios-fetch.js';
import { modalSeleccionPuerta } from './modal-seleccion-puerta.js';

let contenedorModales;
let modalesExistentes;
let botonCerrarModal;
let inputDocumento;
let selectTipoNovedad;
let funcionCallback;
let urlBase;

function modalRegistroNovedadUsuario(url, novedad, documento, callback) {
    consultarModalNovedadUsuario(url).then(respuesta=>{
        if(respuesta.tipo == 'OK'){
            const contenidoModal = respuesta.modal;
            const modal = document.createElement('div');
                
            modal.classList.add('contenedor-ppal-modal');
            modal.id = 'modal_novedad_usuario';
            modal.innerHTML = contenidoModal;
            contenedorModales = document.getElementById('contenedor_modales');
            contenedorModales.appendChild(modal);

            inputDocumento = document.getElementById('documento_involucrado'); 
            selectTipoNovedad = document.getElementById('tipo_novedad');

            inputDocumento.value = documento;
            inputDocumento.readOnly = true;
            selectTipoNovedad.value = novedad;
            selectTipoNovedad.disabled = true;
            
            funcionCallback = callback;
            urlBase = url;

            eventoCerrarModal();
            eventoTextArea();
            eventoRegistrarNovedadUsuario();
            establecerMinFechaSuceso();

        }else if(respuesta.tipo == 'ERROR'){
            alertaError(respuesta);
        }
    })
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

function establecerMinFechaSuceso(){
    const inputFechaSuceso = document.getElementById('fecha_suceso');
    consultarUltimoMovimientoUsuario(inputDocumento.value, urlBase).then(respuesta=>{
        if(respuesta.tipo == 'OK'){
            const fechaUltimoMovimiento = respuesta.datos_movimiento.fecha_registro;
            const fechaFormateada = fechaUltimoMovimiento.replace(" ", "T").slice(0, 16);

            inputFechaSuceso.min = fechaFormateada;

            modalesExistentes = contenedorModales.getElementsByClassName('contenedor-ppal-modal');
            if(modalesExistentes.length > 1){
                modalesExistentes[modalesExistentes.length-2].style.display = 'none';
            }else{
                contenedorModales.classList.add('mostrar');
            }

            setTimeout(()=>{
                inputFechaSuceso.focus();
            }, 250)

        }else if(respuesta.tipo == 'ERROR'){
            if(respuesta.titulo == 'Sesión Expirada'){
                window.location.replace(urlBase+'sesion-expirada');

            }else if(respuesta.titulo == 'Movimiento No Encontrado'){
                modalesExistentes = contenedorModales.getElementsByClassName('contenedor-ppal-modal');
                if(modalesExistentes.length > 1){
                    modalesExistentes[modalesExistentes.length-2].style.display = 'none';
                }else{
                    contenedorModales.classList.add('mostrar');
                }

                setTimeout(()=>{
                    inputFechaSuceso.focus();
                }, 250)
                
            }else{
                botonCerrarModal.click();
                alertaError(respuesta);
            }
        }
    })
}

function eventoRegistrarNovedadUsuario(){
    let formularioNovedad = document.getElementById('formulario_novedad_usuario');
    formularioNovedad.addEventListener('submit', (e)=>{
        e.preventDefault();

        let formData = new FormData(formularioNovedad);
        formData.append('operacion', 'registrar_novedad_usuario');
        formData.append('tipo_novedad', selectTipoNovedad.value);

        registrarNovedadUsuario(formData, urlBase).then(respuesta=>{
            if(respuesta.tipo == "OK" ){
                alertaExito(respuesta);
                funcionCallback();
                
                botonCerrarModal.click();
                
            }else if(respuesta.tipo == "ERROR"){
                if(respuesta.titulo == 'Sesión Expirada'){
                    window.location.replace(urlBase+'sesion-expirada');

                }else if(respuesta.titulo == 'Error Puerta Actual'){
                    alertaAdvertencia(respuesta);
                    
                }else{
                    alertaError(respuesta);
                }
            }
        });
    })
}

function eventoTextArea(){
    const textAreaDescripcion = document.getElementById('descripcion');
    const patron = /^[A-Za-zñÑáéíóúÁÉÍÓÚüÜ0-9., ]{5,150}$/;

    textAreaDescripcion.addEventListener('keyup', ()=>{
        textAreaDescripcion.setCustomValidity("");

        if (!patron.test(textAreaDescripcion.value)){
            textAreaDescripcion.setCustomValidity("Debes digitar solo números y/o letras, mínimo 5 y máximo 150 caracteres");
            textAreaDescripcion.reportValidity();
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

function alertaAdvertencia(respuesta){
    Swal.fire({
        icon: "warning",
        iconColor: "#feb211",
        title: respuesta.titulo,
        text: respuesta.mensaje,
        showCancelButton: true,
        confirmButtonText: 'Aceptar',
        cancelButtonText: 'Cancelar',
        customClass: {
            popup: 'alerta-contenedor',
            confirmButton: 'btn-confirmar',
            cancelButton: 'btn-cancelar' 
        }
    }).then((result) => {
        if (result.isConfirmed) {
            if(respuesta.titulo == "Error Puerta Actual"){
                modalSeleccionPuerta(urlBase);
            }
        } 
    });
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



