import { consultarModalVehiculo } from '../fetchs/modales-fetch.js';
import {registrarVehiculo} from '../fetchs/vehiculos-fetch.js';
import {modalRegistroVisitante} from './modal-registro-visitante.js'

let contenedorModales;
let modalesExistentes;
let formularioVehiculo;
let inputDocumento;
let botonCerrarModal;
let funcionCallback;
let urlBase;

function modalRegistroVehiculo(url, placa=false, callback=false) {
    consultarModalVehiculo(url).then(respuesta=>{
        if(respuesta.tipo == 'OK'){
            const contenidoModal = respuesta.modal;
            const modal = document.createElement('div');
                
            modal.classList.add('contenedor-ppal-modal');
            modal.id = 'modal_vehiculo';
            modal.innerHTML = contenidoModal;
            contenedorModales = document.getElementById('contenedor_modales');
            contenedorModales.appendChild(modal);

            
            if(placa){
                const numeroPlaca = document.getElementById('numero_placa'); 
                numeroPlaca.value = placa;
                numeroPlaca.readOnly = true;
            }

            formularioVehiculo = document.getElementById('formulario_vehiculo');
            inputDocumento = document.getElementById('propietario');
            funcionCallback = callback;
            urlBase = url;
            
            eventoCerrarModal();
            eventoInputPropietario();
            eventoRegistrarVehiculo();

            modalesExistentes = contenedorModales.getElementsByClassName('contenedor-ppal-modal');
            if (modalesExistentes.length > 1) {
                modalesExistentes[modalesExistentes.length-2].style.display = 'none';
            }else{
                contenedorModales.classList.add('mostrar');
            } 
        
            setTimeout(()=>{
                inputDocumento.focus();
            }, 250)

        }else if(respuesta.tipo == 'ERROR'){
            alertaError(respuesta);
        }   
    })
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

function eventoInputPropietario() {
    inputDocumento.addEventListener('change', function() {
        if (inputDocumento.value.length>15) {
            let cadenas = inputDocumento.value.split(' ');
            for(const cadena of cadenas) {
                if(/\d/.test(cadena)){
                    inputDocumento.value = cadena.replace(/\D/g, '');
                    break;
                }
            }
        }
    })
}

function eventoRegistrarVehiculo(){
    formularioVehiculo.addEventListener('submit', (e)=>{
        e.preventDefault();
        let formData = new FormData(formularioVehiculo);
        formData.append('operacion', 'registrar_vehiculo');

        registrarVehiculo(formData, urlBase).then(respuesta=>{
            if(respuesta.tipo == "OK" ){
                alertaExito(respuesta);
                
                if(funcionCallback){
                    funcionCallback();
                }

                botonCerrarModal.click();

            }else if(respuesta.tipo == "ERROR"){
                if(respuesta.titulo == 'Sesión Expirada'){
                    window.location.replace(urlBase+'sesion-expirada');

                }else if(respuesta.titulo == "Usuario No Encontrado"){
                    respuesta.documento = inputDocumento.value
                    alertaAdvertencia(respuesta);

                }else{
                    alertaError(respuesta);
                }
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
                modalRegistroVisitante(urlBase, respuesta.documento);
            }
        } 
    });
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



