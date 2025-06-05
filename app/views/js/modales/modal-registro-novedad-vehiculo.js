import {registrarNovedadVehiculo} from '../fetchs/novedades-vehiculos-fetch.js';
import {consultarPropietarios} from '../fetchs/vehiculos-fetch.js'

let contenedorModales;
let modalesExistentes;
let botonCerrarModal;
let urlBase;

async function modalRegistroNovedadVehiculo(url, novedad, documento, placa) {
    try {
        const response = await fetch(url+'app/views/inc/modales/modal-novedad-vehiculo.php');

        if(!response.ok) throw new Error('Hubo un error en la solicitud');

        const contenidoModal = await response.text();
        const modal = document.createElement('div');
            
        modal.classList.add('contenedor-ppal-modal');
        modal.innerHTML = contenidoModal;
        contenedorModales = document.getElementById('contenedor-modales');
        contenedorModales.appendChild(modal);

        
        let documentoInvolucrado = document.getElementById('documento_involucrado'); 
        let tipoNovedad = document.getElementById('tipo_novedad');
        let numeroPlaca = document.getElementById('numero_placa');

        documentoInvolucrado.value = documento;
        documentoInvolucrado.setAttribute('readonly', '');
        tipoNovedad.value = novedad;
        tipoNovedad.setAttribute('readonly', '');
        numeroPlaca.value = placa;
        numeroPlaca.setAttribute('readonly', '')

        urlBase = url;

        modalesExistentes = contenedorModales.getElementsByClassName('contenedor-ppal-modal');
        contenedorModales.classList.add('mostrar');
       
        dibujarPropietarios(placa);
        eventoCerrarModal();
        eventoRegistrarNovedadVehiculo();
           
    } catch (error) {
        let respuesta = {
            titulo: 'Error Modal',
            mensaje: 'Error al cargar modal registro de novedad de vehículo'
        }
        
        alertaError(respuesta);
    }
    
}
export { modalRegistroNovedadVehiculo };

function eventoCerrarModal(){
    botonCerrarModal = document.getElementById('cerrar_modal_novedad');

    botonCerrarModal.addEventListener('click', ()=>{
        modalesExistentes[modalesExistentes.length-1].remove();
        if(modalesExistentes.length > 0) {
            modalesExistentes[modalesExistentes.length-1].style.display = 'block';
        }else{
            contenedorModales.classList.remove('mostrar');
        }
    });

    document.getElementById('btn_cancelar_novedad').addEventListener('click', ()=>{
        botonCerrarModal.click();
    });
}

function eventoRegistrarNovedadVehiculo(){
    let formularioNovedad = document.getElementById('forma_acceso_05');
    formularioNovedad.addEventListener('submit', (e)=>{
        e.preventDefault();
        let formData = new FormData(formularioNovedad);
        formData.append('operacion', 'registrar_novedad_vehiculo');

        registrarNovedadVehiculo(formData, urlBase).then(respuesta=>{
            if(respuesta.tipo == "ERROR" ){
                alertaError(respuesta);
                
            }else if(respuesta.tipo == "OK"){
                alertaExito(respuesta);
                botonCerrarModal.click();
            }
        });
    })
}

function dibujarPropietarios(placa){
    const selectPropietario = document.getElementById('propietario');
    propietario.innerHTML = '<option value="">Seleccionar</option>';

    consultarPropietarios(placa, urlBase).then(respuesta=>{
        if(respuesta.tipo == 'OK'){
            respuesta.propietarios.forEach(propietario => {
                selectPropietario.innerHTML += `<option value="${propietario.numero_documento}">${propietario.numero_documento} - ${propietario.nombres} ${propietario.apellidos}</option>`
            });
        }else if(respuesta.tipo == 'ERROR'){
            alertaError(respuesta);
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



