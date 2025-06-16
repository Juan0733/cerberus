import {registrarVisitante} from '../fetchs/visitantes-fetch.js';

let contenedorModales;
let modalesExistentes;
let botonCerrarModal;
let funcionCallback;
let urlBase;
let caja01;
let caja02;
let caja03;
let caja04;
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
        contenedorSpinner.classList.remove("mostrar_spinner");
        const modal = document.createElement('div');
            
        modal.classList.add('contenedor-ppal-modal');
        modal.id = 'modal_visitante';
        modal.innerHTML = contenidoModal;
        contenedorModales = document.getElementById('contenedor_modales');
        contenedorModales.appendChild(modal);

        if(documento){
            let documentoVisitante = document.getElementById('documento_visitante'); 
            documentoVisitante.value = documento;
            documentoVisitante.setAttribute('readonly', '');
        }

        if(callback){
            funcionCallback = callback;
        }

        caja01 = document.getElementById('caja_01');
        caja02 = document.getElementById('caja_02');
        caja03 = document.getElementById('caja_03');
        caja04 = document.getElementById('caja_04');
        botonCancelar = document.getElementById('btn_cancelar_visitante');
        botonAtras = document.getElementById('btn_atras_visitante');
        botonSiguiente = document.getElementById('btn_siguiente_visitante');
        botonRegistrar = document.getElementById('btn_registrar_visitante');
        urlBase = url;
        
        modalesExistentes = contenedorModales.getElementsByClassName('contenedor-ppal-modal');
        if (modalesExistentes.length > 1) {
            modalesExistentes[modalesExistentes.length-2].style.display = 'none';
        }else{
            contenedorModales.classList.add('mostrar');
        } 

        setTimeout(()=>{
            document.getElementById('nombres').focus();
        }, 250)
       
        eventoCerrarModal();
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
    botonSiguiente.addEventListener('click', ()=>{
        let inputs = document.querySelectorAll('.campo-seccion-01');
        let validos = true;

        for(const input of inputs) {
            if(!input.checkValidity()){
                input.reportValidity();
                validos = false;
                break;
            }
        };

        if(validos){
            caja01.style.display = 'none';
            caja02.style.display = 'none';
            botonSiguiente.style.display = 'none';
            botonCancelar.style.display = 'none';
            
            caja03.style.display = 'flex';
            caja04.style.display = 'flex';
            botonRegistrar.style.display = 'flex';
            botonAtras.style.display = 'flex';
        }
    })
}

function volverCampos() {
    botonAtras.addEventListener('click', ()=>{
        caja03.style.display = 'none';
        caja04.style.display = 'none';
        botonAtras.style.display = 'none';
        botonRegistrar.style.display = 'none'

        caja01.style.display = 'flex';
        caja02.style.display = 'flex';
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

