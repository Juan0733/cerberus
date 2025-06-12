import {registrarNovedadVehiculo} from '../fetchs/novedades-vehiculos-fetch.js';
import {consultarPropietarios} from '../fetchs/vehiculos-fetch.js'

let contenedorModales;
let modalesExistentes;
let botonCerrarModal;
let descripcion;
let urlBase;

async function modalRegistroNovedadVehiculo(url, novedad, documento, placa) {
    try {
        const response = await fetch(url+'app/views/inc/modales/modal-novedad-vehiculo.php');

        if(!response.ok) throw new Error('Hubo un error en la solicitud');

        const contenidoModal = await response.text();
        const modal = document.createElement('div');
            
        modal.classList.add('contenedor-ppal-modal');
        modal.id = 'modal_novedad_vehiculo';
        modal.innerHTML = contenidoModal;
        contenedorModales = document.getElementById('contenedor_modales');
        contenedorModales.appendChild(modal);

        
        let documentoInvolucrado = document.getElementById('documento_involucrado'); 
        let tipoNovedad = document.getElementById('tipo_novedad');
        let numeroPlaca = document.getElementById('numero_placa');
        descripcion = document.getElementById("descripcion");

        documentoInvolucrado.value = documento;
        documentoInvolucrado.setAttribute('readonly', '');
        tipoNovedad.value = novedad;
        tipoNovedad.setAttribute('readonly', '');
        numeroPlaca.value = placa;
        numeroPlaca.setAttribute('readonly', '')

        urlBase = url;

        modalesExistentes = contenedorModales.getElementsByClassName('contenedor-ppal-modal');
       
        eventoCerrarModal();
        dibujarPropietarios(placa);
        eventoTextArea();
        eventoRegistrarNovedadVehiculo();
           
    } catch (error) {
        if(botonCerrarModal){
            botonCerrarModal.click();
        }

       console.error('Hubo un error:', error);
        alertaError({
            titulo: 'Error Modal',
            mensaje: 'Error al cargar modal registro novedad vehículo'
        });
    }
    
}
export { modalRegistroNovedadVehiculo };

function eventoCerrarModal(){
    botonCerrarModal = document.getElementById('cerrar_modal_novedad_vehiculo');

    botonCerrarModal.addEventListener('click', ()=>{
        modalesExistentes[modalesExistentes.length-1].remove();
        contenedorModales.classList.remove('mostrar');
    });

    document.getElementById('btn_cancelar_novedad_vehiculo').addEventListener('click', ()=>{
        botonCerrarModal.click();
    });
}

function eventoRegistrarNovedadVehiculo(){
    let formularioNovedad = document.getElementById('formulario_novedad_vehiculo');
    formularioNovedad.addEventListener('submit', (e)=>{
        e.preventDefault();

        if(!descripcion.reportValidty()){
            return
        }

        let formData = new FormData(formularioNovedad);
        formData.append('operacion', 'registrar_novedad_vehiculo');

        registrarNovedadVehiculo(formData, urlBase).then(respuesta=>{
            if(respuesta.tipo == "OK" ){
                alertaExito(respuesta);
                botonCerrarModal.click();
                
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
    let temporizador;
    let primeraValidacion = true;

    descripcion.addEventListener('keyup', ()=>{
        clearTimeout(temporizador);
        temporizador = setTimeout(()=>{
            let patron = /^[A-Za-zñÑáéíóúÁÉÍÓÚüÜ0-9 ]{5,100}$/;
    
            if (!patron.test(descripcion.value)){

                if(primeraValidacion){
                    descripcion.setCustomValidity("Debes digitar solo números y letras, mínimo 1 y máximo 100 caracteres");
                    descripcion.reportValidity();
                    primeraValidacion = false;
                }

            } else {
                descripcion.setCustomValidity(""); 
                primeraValidacion = true;
            }
        }, 1000);
    })
}

function dibujarPropietarios(placa){
    const selectPropietario = document.getElementById('propietario');
    propietario.innerHTML = '<option value="" disabled selected>Seleccionar</option>';

    consultarPropietarios(placa, urlBase).then(respuesta=>{
        if(respuesta.tipo == 'OK'){
            respuesta.propietarios.forEach(propietario => {
                selectPropietario.innerHTML += `<option value="${propietario.numero_documento}">${propietario.numero_documento} - ${propietario.nombres} ${propietario.apellidos}</option>`
            });

            contenedorModales.classList.add('mostrar');

        }else if(respuesta.tipo == 'ERROR'){
            if(respuesta.titulo == 'Sesión Expirada'){
                window.location.replace(urlBase+'sesion-expirada');

            }else{
                botonCerrarModal.click();
                alertaError(respuesta);
            }
            
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



