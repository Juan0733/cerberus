import { consultarModalPermisoVehiculo } from '../fetchs/modales-fetch.js';
import {registrarPermisoVehiculo} from '../fetchs/permisos-vehiculos-fetch.js';
import {consultarPropietarios} from '../fetchs/vehiculos-fetch.js'

let contenedorModales;
let modalesExistentes;
let botonCerrarModal;
let inputPlaca;
let selectTipoPermiso;
let funcionCallback;
let urlBase;

function modalRegistroPermisoVehiculo(url, permiso=false, placa=false, callback) {
    consultarModalPermisoVehiculo(url).then(respuesta=>{
        if(respuesta.tipo == 'OK'){
            const contenidoModal = respuesta.modal;
            const modal = document.createElement('div');
                
            modal.classList.add('contenedor-ppal-modal');
            modal.id = 'modal_permiso_vehiculo';
            modal.innerHTML = contenidoModal;
            contenedorModales = document.getElementById('contenedor_modales');

            modalesExistentes = contenedorModales.getElementsByClassName('contenedor-ppal-modal');
            if(modalesExistentes.length > 0){
            for (let i = 0; i < modalesExistentes.length; i++) {
                    modalesExistentes[i].remove();
                }
            }

            contenedorModales.appendChild(modal);

            inputPlaca = document.getElementById('numero_placa');
            selectTipoPermiso = document.getElementById('tipo_permiso');

            funcionCallback = callback;
            urlBase = url;

            if(placa){ 
                inputPlaca.value = placa;
                inputPlaca.readOnly = true;
                dibujarPropietarios();
            }

            if(permiso){
                selectTipoPermiso.value = permiso;
                selectTipoPermiso.disabled = true;
            }

            eventoCerrarModal();
            eventoTextArea();
            eventoInputPlaca();
            eventoRegistrarPermisoVehiculo();

            contenedorModales.classList.add('mostrar');
            
            setTimeout(()=>{
                document.getElementById('propietario').focus();
            }, 250)

        }else if(respuesta.tipo == 'ERROR'){
            alertaError(respuesta);
        }
    })
}
export { modalRegistroPermisoVehiculo };

function eventoCerrarModal(){
    botonCerrarModal = document.getElementById('cerrar_modal_permiso_vehiculo');

    botonCerrarModal.addEventListener('click', ()=>{
        modalesExistentes[modalesExistentes.length-1].remove();
        contenedorModales.classList.remove('mostrar');
        
    });

    document.getElementById('btn_cancelar_permiso_vehiculo').addEventListener('click', ()=>{
        botonCerrarModal.click();
    });
}

function eventoInputPlaca(){
    let temporizador;
    
    inputPlaca.addEventListener('keyup', ()=>{
        clearTimeout(temporizador);
        temporizador = setTimeout(()=>{
            if(inputPlaca.checkValidity()){
                dibujarPropietarios();

            }else{
                inputPlaca.reportValidity();
            }
            
        }, 1000)
    })
}

function dibujarPropietarios(){
    const selectPropietario = document.getElementById('propietario');
    selectPropietario.innerHTML = '<option value="" disabled selected>Seleccionar</option>'

    consultarPropietarios(inputPlaca.value, urlBase).then(respuesta=>{
        if(respuesta.tipo == 'OK' || (respuesta.tipo == 'ERROR' && respuesta.titulo == 'Datos No Encontrados')){
            const propietarios = respuesta.propietarios ?? [];

            propietarios.forEach(propietario => {
                selectPropietario.innerHTML += `<option value="${propietario.numero_documento}">${propietario.numero_documento} - ${propietario.nombres} ${propietario.apellidos}`
            });

        }else if(respuesta.tipo == 'ERROR'){
            if(respuesta.titulo == 'Sesión Expirada'){
                window.location.replace(urlBase+'sesion-expirada');

            }else{
                alertaError(respuesta);
            }
        }
    })
}

function eventoRegistrarPermisoVehiculo(){
    let formularioPermisoVehiculo = document.getElementById('formulario_permiso_vehiculo');
    formularioPermisoVehiculo.addEventListener('submit', (e)=>{
        e.preventDefault();

        let formData = new FormData(formularioPermisoVehiculo);
        formData.append('operacion', 'registrar_permiso_vehiculo');

        if(selectTipoPermiso.disabled == true){
            formData.append('tipo_permiso', selectTipoPermiso.value);
        }
        
        registrarPermisoVehiculo(formData, urlBase).then(respuesta=>{
            if(respuesta.tipo == "OK" ){
                alertaExito(respuesta);
                funcionCallback();
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