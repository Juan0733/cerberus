import {registrarVehiculo} from '../fetchs/vehiculos-fetch.js';
import {modalRegistroVisitante} from './modal-registro-visitante.js'

let documentoPropietario;
let contenedorModales;
let modalesExistentes;
let botonCerrarModal;
let funcionCallback;
let urlBase;

async function modalRegistroVehiculo(placa, funcion, url) {
    try {
        const response = await fetch(url+'app/views/inc/modales/modal-vehiculo.php');

        if(!response.ok) throw new Error('Hubo un error en la solicitud');

        const contenidoModal = await response.text();
        const modal = document.createElement('div');
            
        modal.classList.add('contenedor-ppal-modal');
        modal.innerHTML = contenidoModal;
        contenedorModales = document.getElementById('contenedor-modales');
        contenedorModales.appendChild(modal);

        let numeroPlaca = document.getElementById('numero_placa'); 

        numeroPlaca.value = placa;
        numeroPlaca.setAttribute('readonly', '');

        documentoPropietario = document.getElementById('propietario');
        funcionCallback = funcion;
        urlBase = url;
        
        modalesExistentes = contenedorModales.getElementsByClassName('contenedor-ppal-modal');
        contenedorModales.classList.add('mostrar');
        
        eventoBotonCerrarModal();
        eventoFormularioVehiculo();

           
    } catch (error) {
        let respuesta = {
            titulo: 'Error Modal',
            mensaje: error
        }
        
        alertaError(respuesta);
    }
    
}
export { modalRegistroVehiculo };

function eventoBotonCerrarModal(){
    botonCerrarModal = document.getElementById('cerrar_modal_vehiculo');

    botonCerrarModal.addEventListener('click', ()=>{
        modalesExistentes[modalesExistentes.length-1].remove();
        contenedorModales.classList.remove('mostrar');
        
    });

    document.getElementById('btn_cancelar_vehiculo').addEventListener('click', ()=>{
        botonCerrarModal.click();
    });
}

function eventoFormularioVehiculo(){
    let formularioVehiculo = document.getElementById('forma_acceso_03');
    formularioVehiculo.addEventListener('submit', (e)=>{
        e.preventDefault();
        let formData = new FormData(formularioVehiculo);
        formData.append('operacion', 'registrar_vehiculo');

        registrarVehiculo(formData, urlBase).then(respuesta=>{
            if(respuesta.tipo == "ERROR" ){
                if(respuesta.titulo == "Usuario No Encontrado"){
                    alertaAdvertencia(respuesta);
                }else{
                    alertaError(respuesta);
                }
                
            }else if(respuesta.tipo == "OK"){
                alertaExito(respuesta);
                botonCerrarModal.click();
                funcionCallback();
            }
        });
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
                modalRegistroVisitante(urlBase, documentoPropietario.value);
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



