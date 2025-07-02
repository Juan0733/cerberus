import { consultarPuerta, guardarPuerta } from "../fetchs/vigilantes-fetch.js";

let contenedorModales;
let modalesExistentes;
let puertaActual;
let puertaNueva;
let botonCerrarModal;
let urlBase;

async function modalSeleccionPuerta(url) {
    try {
        const response = await fetch(url+'app/views/inc/modales/modal-seleccion-puerta.php');

        if(!response.ok) throw new Error('Hubo un error en la solicitud');

        const contenidoModal = await response.text();
        const modal = document.createElement('div');
            
        modal.classList.add('contenedor-ppal-modal');
        modal.id = 'modal_puerta';
        modal.innerHTML = contenidoModal;
        contenedorModales = document.getElementById('contenedor_modales');
        
        modalesExistentes = contenedorModales.getElementsByClassName('contenedor-ppal-modal');
        if(modalesExistentes.length > 0){
           for (let i = 0; i < modalesExistentes.length; i++) {
                modalesExistentes[i].remove();
            }
        }

        contenedorModales.appendChild(modal);

        urlBase = url;

        eventoCerrarModal();
        consultarPuertaActual();
        eventoSeleccionarPuerta();
        eventoGuardarPuerta();
         
    } catch (error) {
        if(botonCerrarModal){
            botonCerrarModal.click();
        }
        
        console.error('Hubo un error:', error);
        alertaError({
            titulo: 'Error Modal',
            mensaje: 'Error al cargar modal seleccion puerta.'
        });
    }
}
export{modalSeleccionPuerta}

function eventoCerrarModal(){
    botonCerrarModal = document.getElementById('cerrar_modal_puerta');

        botonCerrarModal.addEventListener('click', ()=>{
            if(puertaActual){
                modalesExistentes[modalesExistentes.length-1].remove();
                contenedorModales.classList.remove('mostrar');
            }
        });
    
    document.getElementById('btn_cancelar_puerta').addEventListener('click', ()=>{
        botonCerrarModal.click();
    });
}

function  consultarPuertaActual() {
    consultarPuerta(urlBase).then(respuesta=>{
        if(respuesta['tipo'] == 'OK'){
            puertaActual = respuesta.puerta_actual;
            puertaNueva = respuesta.puerta_actual;
            document.getElementById(puertaActual.toLowerCase()).checked = true;
            document.getElementById('icono_puerta_'+puertaActual.toLowerCase()).style.color = 'var(--color-secundario)';
    
        }else if(respuesta.tipo == 'ERROR' && respuesta.titulo == 'Puerta No Encontrada'){
            puertaActual = '';
            puertaNueva = '';
        }

        contenedorModales.classList.add('mostrar');
    })
}

function eventoSeleccionarPuerta() {
    const inputsCheckbox = document.querySelectorAll('.checkbox-puerta');
    const iconosPuerta = document.querySelectorAll('.icono-puerta');

    inputsCheckbox.forEach(checkbox => {
        checkbox.addEventListener('change', ()=>{
            iconosPuerta.forEach(icono => {
                icono.removeAttribute('style');
            });

            if (checkbox.checked){
                puertaNueva = checkbox.value;
                document.getElementById('icono_puerta_'+puertaNueva.toLowerCase()).style.color = 'var(--color-secundario)';
                inputsCheckbox.forEach(input => {
                    if(input != checkbox){
                        input.checked = false;
                    }
                });

            }else{
                puertaNueva = '';
            }
        })
    });
}

function eventoGuardarPuerta(){
    const formulario = document.getElementById('formulario_puerta');

    formulario.addEventListener('submit', (e)=>{
        e.preventDefault();

        if(!puertaNueva){
            return;
        }
        
        const formData = new FormData();

        formData.append('operacion', 'guardar_puerta');
        formData.append('puerta', puertaNueva);

        guardarPuerta(formData, urlBase).then(respuesta=>{
            if(respuesta.tipo == 'OK'){
                alertaExito(respuesta);
                puertaActual = puertaNueva;
                botonCerrarModal.click();
            }
        })
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

