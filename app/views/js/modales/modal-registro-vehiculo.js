import {registrarVehiculo, consultarVehiculo} from '../fetchs/vehiculos-fetch.js';
import {modalRegistroVisitante} from './modal-registro-visitante.js'

let documentoPropietario;
let numeroPlaca;
let nombreModulo;
let contenedorModales;
let modalesExistentes;
let botonCerrarModal;
let funcionCallback;
let urlBase;

const contenedorSpinner = document.getElementById('contenedor_spinner');

async function modalRegistroVehiculo(url, placa=false, callback=false, modulo=false) {
    try {
        contenedorSpinner.classList.add("mostrar_spinner");
        const response = await fetch(url+'app/views/inc/modales/modal-vehiculo.php');

        if(!response.ok) throw new Error('Hubo un error en la solicitud');

        const contenidoModal = await response.text();
        contenedorSpinner.classList.remove("mostrar_spinner");
        const modal = document.createElement('div');
            
        modal.classList.add('contenedor-ppal-modal');
        modal.id = 'modal_vehiculo';
        modal.innerHTML = contenidoModal;
        contenedorModales = document.getElementById('contenedor_modales');
        contenedorModales.appendChild(modal);

        numeroPlaca = document.getElementById('numero_placa'); 
        if(placa){
            numeroPlaca.value = placa;
            numeroPlaca.setAttribute('readonly', '');
        }
        
        if(modulo){
            nombreModulo = modulo;
        }

        documentoPropietario = document.getElementById('propietario');
        funcionCallback = callback;
        urlBase = url;
 
        modalesExistentes = contenedorModales.getElementsByClassName('contenedor-ppal-modal');
        if (modalesExistentes.length > 1) {
            modalesExistentes[modalesExistentes.length-2].style.display = 'none';
        }else{
            contenedorModales.classList.add('mostrar');
        } 
    
        setTimeout(()=>{
            documentoPropietario.focus();
        }, 250)
        
        eventoCerrarModal();
        eventoRegistrarVehiculo();

           
    } catch (error) {
        contenedorSpinner.classList.remove("mostrar_spinner");

        if(botonCerrarModal){
            botonCerrarModal.click();
        }
        
        console.error('Hubo un error:', error);
        alertaError({
            titulo: 'Error Modal',
            mensaje: 'Error al cargar modal vehículo.'
        });
    }
    
}
export { modalRegistroVehiculo };

function eventoCerrarModal(){
    botonCerrarModal = document.getElementById('cerrar_modal_vehiculo');

    botonCerrarModal.addEventListener('click', ()=>{
        modalesExistentes[modalesExistentes.length-1].remove();
        if(modalesExistentes.length > 0) {
            modalesExistentes[modalesExistentes.length-1].style.display = 'block';
        }else{
            contenedorModales.classList.remove('mostrar');
        }
        
    });

    document.getElementById('btn_cancelar_vehiculo').addEventListener('click', ()=>{
        botonCerrarModal.click();
    });
}

function eventoRegistrarVehiculo(){
    let formularioVehiculo = document.getElementById('formulario_vehiculo');
    formularioVehiculo.addEventListener('submit', (e)=>{
        e.preventDefault();
        let formData = new FormData(formularioVehiculo);
        formData.append('operacion', 'registrar_vehiculo');

        if(nombreModulo == 'agendas'){
            consultarVehiculo(numeroPlaca.value, urlBase).then(respuesta=>{
                if(respuesta.tipo == 'OK'){
                    let mensaje = {
                        titulo: 'Vehículo Existente',
                        mensaje: 'No es necesario agregar este vehículo, porque ya se encuentra registrado.'
                    }
                    alertaAdvertencia(mensaje);

                }else if(respuesta.tipo == 'ERROR'){
                    if(respuesta.titulo == 'Vehículo No Encontrado'){
                        registrarVehiculo(formData, urlBase).then(respuesta=>{
                            if(respuesta.tipo == "OK" ){
                                alertaExito(respuesta);
                                botonCerrarModal.click();
                                funcionCallback();

                            }else if(respuesta.tipo == "ERROR"){
                                if(respuesta.titulo == "Usuario No Encontrado"){
                                    respuesta.documento = documentoPropietario.value
                                    alertaAdvertencia(respuesta);
                                }else{
                                    alertaError(respuesta);
                                }
                            }
                        });

                    }else if(respuesta.titulo == "Sesión Expirada"){
                        window.location.replace(urlBase+'sesion-expirada');
                    }else{
                        alertaError(respuesta);
                    }
                }
            })

        }else{
             registrarVehiculo(formData, urlBase).then(respuesta=>{
                if(respuesta.tipo == "OK" ){
                        alertaExito(respuesta);
                    botonCerrarModal.click();
                    funcionCallback();
                }else if(respuesta.tipo == "ERROR"){
                    if(respuesta.titulo == 'Sesión Expirada'){
                        window.location.replace(urlBase+'sesion-expirada');

                    }else if(respuesta.titulo == "Usuario No Encontrado"){
                        respuesta.documento = documentoPropietario.value
                        alertaAdvertencia(respuesta);

                    }else{
                        alertaError(respuesta);
                    }
                }
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
            if(respuesta.titulo == "Usuario No Encontrado"){
                modalRegistroVisitante(urlBase, respuesta.documento);
            }
        } 
    });
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



