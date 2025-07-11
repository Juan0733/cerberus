import {registrarNovedadVehiculo} from '../fetchs/novedades-vehiculos-fetch.js';
import {consultarPropietarios} from '../fetchs/vehiculos-fetch.js'

let contenedorModales;
let modalesExistentes;
let placaVehiculo;
let selectTipoNovedad;
let botonCerrarModal;
let urlBase;

const contenedorSpinner = document.getElementById('contenedor_spinner');

async function modalRegistroNovedadVehiculo(url, novedad, documento, placa) {
    try {
        contenedorSpinner.classList.add("mostrar_spinner");
        const response = await fetch(url+'app/views/inc/modales/modal-novedad-vehiculo.php');

        if(!response.ok) throw new Error('Hubo un error en la solicitud');

        const contenidoModal = await response.text();
        const modal = document.createElement('div');
            
        modal.classList.add('contenedor-ppal-modal');
        modal.id = 'modal_novedad_vehiculo';
        modal.innerHTML = contenidoModal;
        contenedorModales = document.getElementById('contenedor_modales');
        
        modalesExistentes = contenedorModales.getElementsByClassName('contenedor-ppal-modal');
        if(modalesExistentes.length > 0){
           for (let i = 0; i < modalesExistentes.length; i++) {
                modalesExistentes[i].remove();
            }
        }

        contenedorModales.appendChild(modal);

        const inputDocumento = document.getElementById('documento_involucrado'); 
        const inputPlaca = document.getElementById('numero_placa');
        selectTipoNovedad = document.getElementById('tipo_novedad');

        inputDocumento.value = documento;
        inputDocumento.readOnly = true;
        selectTipoNovedad.value = novedad;
        selectTipoNovedad.disabled = true;
        inputPlaca.value = placa;
        inputPlaca.readOnly = true;

        placaVehiculo = placa;
        urlBase = url;
       
        eventoCerrarModal();
        eventoTextArea();
        eventoRegistrarNovedadVehiculo();
        dibujarPropietarios(placa);
           
    } catch (error) {
        contenedorSpinner.classList.remove("mostrar_spinner");

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

        let formData = new FormData(formularioNovedad);
        formData.append('operacion', 'registrar_novedad_vehiculo');
        formData.append('tipo_novedad', selectTipoNovedad.value);

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
    const textAreaDescripcion = document.getElementById("descripcion");
    let temporizador;
    let primeraValidacion = true;

    textAreaDescripcion.addEventListener('keyup', ()=>{
        clearTimeout(temporizador);
        temporizador = setTimeout(()=>{
            let patron = /^[A-Za-zñÑáéíóúÁÉÍÓÚüÜ0-9., ]{5,150}$/;
    
            if (!patron.test(textAreaDescripcion.value)){
                if(primeraValidacion){
                    textAreaDescripcion.setCustomValidity("Debes digitar solo números y letras, mínimo 1 y máximo 100 caracteres");
                    textAreaDescripcion.reportValidity();
                    primeraValidacion = false;
                }

            } else {
                textAreaDescripcion.setCustomValidity(""); 
                primeraValidacion = true;
            }
        }, 1000);
    })
}

function dibujarPropietarios(){
    const selectPropietario = document.getElementById('propietario');
    propietario.innerHTML = '<option value="" disabled selected>Seleccionar</option>';

    consultarPropietarios(placaVehiculo, urlBase).then(respuesta=>{
        if(respuesta.tipo == 'OK'){
            respuesta.propietarios.forEach(propietario => {
                selectPropietario.innerHTML += `<option value="${propietario.numero_documento}">${propietario.numero_documento} - ${propietario.nombres} ${propietario.apellidos}</option>`
            });

            contenedorSpinner.classList.remove("mostrar_spinner");
            contenedorModales.classList.add('mostrar');
            
            setTimeout(()=>{
                document.getElementById('propietario').focus();
            }, 250)

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



