import {registrarVisitante} from '../fetchs/visitantes-fetch.js';
import { consultarMotivosIngreso } from '../fetchs/motivos-ingreso.js';

let contenedorModales;
let modalesExistentes;
let botonCerrarModal;
let funcionCallback;
let urlBase;
let inputTipoDocumento;
let seccion01;
let seccion02;
let botonCancelar;
let botonAtras;
let botonSiguiente;
let botonRegistrar;

const contenedorSpinner = document.getElementById('contenedor_spinner');

async function modalRegistroVisitante(url, documento=false, callback=false) {
    try {
        contenedorSpinner.classList.add("mostrar_spinner");
        const response = await fetch(url+'app/views/inc/modales/modal-visitante.php');

        if(!response.ok) throw new Error('Hubo un error en la solicitud');

        const contenidoModal = await response.text();
        const modal = document.createElement('div');
            
        modal.classList.add('contenedor-ppal-modal');
        modal.id = 'modal_visitante';
        modal.innerHTML = contenidoModal;
        contenedorModales = document.getElementById('contenedor_modales');
        contenedorModales.appendChild(modal);

        if(documento){
            const inputDocumento = document.getElementById('documento_visitante'); 
            inputDocumento.value = documento;
            inputDocumento.readOnly = true;
        }

        if(callback){
            funcionCallback = callback;
        }

        inputTipoDocumento = document.getElementById('tipo_documento');
        seccion01 = document.getElementsByClassName('seccion-01');
        seccion02 = document.getElementsByClassName('seccion-02');
        botonCancelar = document.getElementById('btn_cancelar_visitante');
        botonAtras = document.getElementById('btn_atras_visitante');
        botonSiguiente = document.getElementById('btn_siguiente_visitante');
        botonRegistrar = document.getElementById('btn_registrar_visitante');
        urlBase = url;
        
        eventoCerrarModal();
        dibujarMotivosIngreso();
        eventoRegistrarVisitante();
        motrarCampos();
        volverCampos();
 
    } catch (error) {
        contenedorSpinner.classList.remove("mostrar_spinner");

        if(botonCerrarModal){
            botonCerrarModal.click();
        }

        console.error('Hubo un error:', error);
        alertaError({
            titulo: 'Error Modal',
            mensaje: 'Error al cargar modal visitante.'
        });
    }
    
}
export { modalRegistroVisitante };

function eventoCerrarModal(){
    botonCerrarModal = document.getElementById('cerrar_modal_visitante');

    botonCerrarModal.addEventListener('click', ()=>{
        modalesExistentes[modalesExistentes.length-1].remove();
        if(modalesExistentes.length > 0) {
            modalesExistentes[modalesExistentes.length-1].style.display = 'block';
        }else{
            contenedorModales.classList.remove('mostrar');
        }
    });

    document.getElementById('btn_cancelar_visitante').addEventListener('click', ()=>{
        botonCerrarModal.click();
    });
}

function dibujarMotivosIngreso(){
    const dataListMotivos = document.getElementById('lista_motivos');

    consultarMotivosIngreso(urlBase).then(respuesta=>{
        if(respuesta.tipo == 'OK' || (respuesta.tipo == 'ERROR' && respuesta.titulo == 'Datos No Encontrados')){
            const motivos = respuesta.motivos_ingreso ?? [];

            motivos.forEach(motivo => {
                dataListMotivos.innerHTML += `
                    <option value="${motivo.motivo}">${motivo.motivo}</option>`;
            });

            contenedorSpinner.classList.remove("mostrar_spinner");
            modalesExistentes = contenedorModales.getElementsByClassName('contenedor-ppal-modal');
            if (modalesExistentes.length > 1) {
                modalesExistentes[modalesExistentes.length-2].style.display = 'none';
            }else{
                contenedorModales.classList.add('mostrar');
            } 

            setTimeout(()=>{
                inputTipoDocumento.focus();
            }, 250)

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

function eventoRegistrarVisitante(){
    const formularioVisitante = document.getElementById('formulario_visitante');
    formularioVisitante.addEventListener('submit', (e)=>{
        e.preventDefault();
        let formData = new FormData(formularioVisitante);
        formData.append('operacion', 'registrar_visitante');

        registrarVisitante(formData, urlBase).then(respuesta=>{
            if(respuesta.tipo == "OK"){
                alertaExito(respuesta);
                botonCerrarModal.click();

                if(funcionCallback){
                    funcionCallback(respuesta);
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

function motrarCampos() {
    const inputsSeccion01 = document.getElementsByClassName('campo-seccion-01');
    const inputCorreo = document.getElementById('correo_electronico');

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

            botonSiguiente.style.display = 'none';
            botonCancelar.style.display = 'none';
        
            botonRegistrar.style.display = 'flex';
            botonAtras.style.display = 'flex';
        }
    })
}

function volverCampos() {
    botonAtras.addEventListener('click', ()=>{
        for(const caja of seccion02){
            caja.style.display = 'none';
        }

        for(const caja of seccion01){
            caja.style.display = 'block';
        }

        inputTipoDocumento.focus();

        botonAtras.style.display = 'none';
        botonRegistrar.style.display = 'none'
        botonSiguiente.style.display = 'flex';
        botonCancelar.style.display = 'flex';
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

