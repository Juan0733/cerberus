import {validarUsuarioAptoSalida, registrarSalidaVehicular} from '../fetchs/movimientos-fetch.js';
import {consultarVehiculo, consultarPropietarios} from '../fetchs/vehiculos-fetch.js';
import {modalRegistroVisitante} from '../modales/modal-registro-visitante.js';
import {modalRegistroNovedadUsuario} from '../modales/modal-registro-novedad-usuario.js';
import { modalRegistroNovedadVehiculo } from '../modales/modal-registro-novedad-vehiculo.js';
import { modalScanerQr } from '../modales/modal-scaner-qr.js';
import { modalSeleccionPuerta } from '../modales/modal-seleccion-puerta.js';

let documentoPeaton;
let documentoPropietario;
let documentoPasajero;
let placaVehiculo;
let selectTipoVehiculo;
let contenedorVehiculoPropietario;
let cajaPropietarioBtn;
let cajaTipoVehiculo;
let observacion;
let botonPeatonal;
let botonVehicular;
let botonRegistrarSalida;
let formularioPasajeros;
let formularioPeatonal;
let formularioVehicular;
let contenedorBotonesFormularios;
let cuerpoTablaPasajeros;
let listaPropietarios;
let puerta;
let urlBase;

const datosSalidaVehicular = {
    placa: "",
    tipoVehiculo: "",
    propietario: "",
    pasajeros: []
};

function abrirFormularioPeatonal(){
    cerrarFormularios();

    if(window.innerWidth <= 1023){
        botonVehicular.style.display = "none";
    }

    botonPeatonal.style.display = "none"
    formularioPeatonal.style.display = "flex"
    documentoPeaton.focus();
}
export{abrirFormularioPeatonal}

function abrirFormularioVehicular() {
    cerrarFormularios();

    if(window.innerWidth <= 1023){
        botonPeatonal.style.display = "none";

        if(window.innerWidth < 768){
            contenedorBotonesFormularios.style.justifyContent = 'start';
        }
    }

    botonVehicular.style.display = "none"
    formularioVehicular.style.display = "flex"
    placaVehiculo.focus();
}
export{abrirFormularioVehicular}

function cerrarFormularios(){
    if(formularioPeatonal.style.display == 'flex'){
        formularioPeatonal.reset();

        formularioPeatonal.style.display = 'none';
        botonPeatonal.style = 'flex';

        if(botonVehicular.style.display == 'none'){
            botonVehicular.style.display = 'flex';
        }
    }

    if(formularioVehicular.style.display == 'flex'){
        limpiarFormularioVehicular();

        formularioVehicular.style.display = 'none';
        botonVehicular.style = 'flex';
        
        if(botonPeatonal.style.display == 'none'){
            botonPeatonal.style.display = 'flex';
        }
    }
    
    if(contenedorBotonesFormularios.style.justifyContent == 'start'){
        contenedorBotonesFormularios.style.justifyContent = 'center';
    }
}

function eventoInputPlaca(){
    placaVehiculo.addEventListener('change',()=>{
        datosSalidaVehicular.placa = "";
        placaVehiculo.classList.remove('input-ok');
        placaVehiculo.classList.remove('input-error');

        if(cajaTipoVehiculo.style.display == 'block'){
            cajaTipoVehiculo.style.display = 'none';
            selectTipoVehiculo.required = false;

            cajaPropietarioBtn.style.gridColumn = 'span 1';

            if(window.innerWidth <= 767){
                contenedorVehiculoPropietario.style.gridTemplateColumns = 'repeat(1,1fr)';
            }
        }
      
        if (placaVehiculo.checkValidity()) {
            datosSalidaVehicular.placa = placaVehiculo.value;
      
            consultarVehiculo(placaVehiculo.value, urlBase).then(respuesta => {
                if(respuesta.tipo == "OK"){
                    placaVehiculo.classList.add('input-ok');
                    documentoPropietario.focus();
                    dibujarPropietarios();

                }else if(respuesta.tipo == "ERROR"){
                    if(respuesta.titulo == "Vehículo No Encontrado"){
                        placaVehiculo.classList.add('input-error');
                        
                        cajaTipoVehiculo.style.display = 'block';
                        selectTipoVehiculo.required = true;

                        cajaPropietarioBtn.style.gridColumn = 'span 2';

                        if(window.innerWidth <= 767){
                           contenedorVehiculoPropietario.style.gridTemplateColumns = 'repeat(2,1fr)';
                        } 

                    }else if(respuesta.titulo == 'Sesión Expirada'){
                        window.location.replace(urlBase+'sesion-expirada');
                        
                    }else{
                        alertaError(respuesta);
                    }
                }
            });
        }else{
            placaVehiculo.reportValidity();
        }
    })
}

function eventoSelectTipoVehiculo(){
    selectTipoVehiculo.addEventListener('change', ()=>{
        datosSalidaVehicular.tipoVehiculo = selectTipoVehiculo.value;
    })
}

function eventoInputPropietario(){
    documentoPropietario.addEventListener('change', ()=>{
        datosSalidaVehicular.propietario = '';
        documentoPropietario.classList.remove('input-ok');
        documentoPropietario.classList.remove('input-error');

        
        if(documentoPropietario.checkValidity()) {
            let existePasajero = false;
            for(const pasajero of datosSalidaVehicular.pasajeros){
                if(pasajero.documento_pasajero == documentoPropietario.value){
                    existePasajero = true;
                    break;
                }
            }

            if(!existePasajero){
                validarUsuarioAptoSalida(documentoPropietario.value, urlBase).then(respuesta => {
                    if(respuesta.tipo == "OK"){
                        documentoPropietario.classList.add('input-ok');
                        documentoPasajero.focus();
                        datosSalidaVehicular.propietario = documentoPropietario.value;

                    }else if(respuesta.tipo == "ERROR"){
                        datosSalidaVehicular.propietario = "";
                        if(respuesta.titulo == "Usuario No Encontrado" || respuesta.titulo == "Entrada No Registrada"){
                            documentoPropietario.classList.add('input-error');
                            respuesta.documento = documentoPropietario.value;
                            respuesta.callback = eventoManualInputPropietario;
                            alertaAdvertencia(respuesta);

                        }else if(respuesta.titulo == 'Sesión Expirada'){
                            window.location.replace(urlBase+'sesion-expirada');

                        }else{
                            alertaError(respuesta);
                        }
                    }
                });

            }else{
                let mensaje = {
                    titulo: "Error Propietario",
                    mensaje: `El usuario con número de documento ${documentoPropietario.value} ya se encuentra en la lista de pasajeros.`
                };

                documentoPropietario.classList.add('input-error');
                alertaError(mensaje);
            }
        }else{
            documentoPropietario.reportValidity();
        }
    })
}

function eventoFormularioPasajeros(){
    formularioPasajeros.addEventListener('submit', (e)=>{
        e.preventDefault();
        if(datosSalidaVehicular.propietario != documentoPasajero.value){
            let existePasajero = false;
            for(const pasajero of datosSalidaVehicular.pasajeros){
                if(pasajero.documento_pasajero == documentoPasajero.value){
                    existePasajero = true;
                    break;
                }
            }

            if(!existePasajero){
                validarUsuarioAptoSalida(documentoPasajero.value, urlBase).then(respuesta => {
                    if(respuesta.tipo == "OK"){
                        let datosPasajero = {
                            documento_pasajero: documentoPasajero.value,
                            nombres: `${respuesta.usuario.nombres} ${respuesta.usuario.apellidos}`
                        }
                        datosSalidaVehicular.pasajeros.push(datosPasajero);
                        documentoPasajero.value = '';
                        dibujarTablaPasajeros();
                        
                    }else if(respuesta.tipo == "ERROR"){
                        if(respuesta.titulo == "Usuario No Encontrado" || respuesta.titulo == "Entrada No Registrada"){
                            respuesta.documento = documentoPasajero.value;
                            respuesta.callback = eventoManualFormularioPasajeros;
                            alertaAdvertencia(respuesta);

                        }else if(respuesta.titulo == 'Sesión Expirada'){
                            window.location.replace(urlBase+'sesion-expirada');

                        }else{
                            alertaError(respuesta);
                        }
                    }
                });
            }else{
                let mensaje = {
                    titulo: "Error Pasajero",
                    mensaje: `El usuario con número de documento ${documentoPasajero.value} ya se encuentra en la lista de pasajeros.`
                };
                alertaError(mensaje);
            }
        }else{
            let mensaje = {
                titulo: "Error Pasajero",
                mensaje: `El usuario con número de documento ${documentoPasajero.value} ya se encuentra como propietario.`
            };
            alertaError(mensaje);
        }
        
    });
}

function dibujarPropietarios(){
    consultarPropietarios(datosSalidaVehicular.placa, urlBase).then(respuesta=>{
        if(respuesta.tipo == 'OK'){
            listaPropietarios.innerHTML = '';

            respuesta.propietarios.forEach(propietario=>{
                listaPropietarios.innerHTML += `
                    <option value="${propietario.numero_documento}">
                `;
            })

        }else if(respuesta.tipo == 'ERROR'){
            if(respuesta.titulo == 'Sesión Expirada'){
                window.location.replace(urlBase+'sesion-expirada');

            }else if(respuesta.titulo != 'Datos No Encontrados'){
                alertaError(respuesta);
            }
        }
    })
}

function dibujarTablaPasajeros(){
    cuerpoTablaPasajeros.innerHTML = '';

    datosSalidaVehicular.pasajeros.forEach((pasajero, indice) => {
        cuerpoTablaPasajeros.innerHTML += `
            <tr>
                <td>${pasajero.documento_pasajero}</td>
                <td>${pasajero.nombres}</td>
                <td>
                    <ion-icon name="trash-outline" class="eliminar-pasajero" data-id="${indice}"></ion-icon>
                </td>
            </tr>`;
    });

    eventoEliminarPasajero();
}

function eventoEliminarPasajero(){
    const botonesEliminar = document.querySelectorAll('.eliminar-pasajero');
    botonesEliminar.forEach(boton => {
        let indice = boton.id;
        boton.addEventListener('click', ()=>{
            datosSalidaVehicular.pasajeros.splice(indice, 1);
            dibujarTablaPasajeros();
        })
    });
}

function eventoRegistrarSalidaVehicular(){
    botonRegistrarSalida.addEventListener('click', ()=>{
        if(datosSalidaVehicular.placa == ''){
            eventoManualInputPlaca();
            return

        }else if(datosSalidaVehicular.propietario == ''){
            eventoManualInputPropietario();
            return;

        }else if(!selectTipoVehiculo.checkValidity()){
            selectTipoVehiculo.reportValidity();
            return

        }else if(!observacion.reportValidity()){
            return;
        }
        const formData = new FormData();
        const pasajeros = JSON.stringify(datosSalidaVehicular.pasajeros);

        formData.append('operacion', 'registrar_salida_vehicular');
        formData.append('propietario', datosSalidaVehicular.propietario);
        formData.append('placa_vehiculo', datosSalidaVehicular.placa);
        formData.append('tipo_vehiculo', datosSalidaVehicular.tipoVehiculo);
        formData.append('pasajeros', pasajeros);
        formData.append('observacion_vehicular', observacion.value);

        registrarSalidaVehicular(formData, urlBase).then(respuesta=>{
            if(respuesta.tipo == 'OK'){
                alertaExito(respuesta);
                limpiarFormularioVehicular();

                setTimeout(()=>{
                    placaVehiculo.focus();
                }, 1000);
                
            }else if(respuesta.tipo == 'ERROR'){
                if(respuesta.titulo == 'Propietario Incorrecto'){
                    respuesta.documento = datosSalidaVehicular.propietario;
                    respuesta.vehiculo= datosSalidaVehicular.placa;
                    respuesta.callback = eventoManualBotonSalida;
                    alertaAdvertencia(respuesta)

                }else if(respuesta.titulo == 'Sesión Expirada'){
                    window.location.replace(urlBase+'sesion-expirada');

                }else{
                    alertaError(respuesta);
                }
            }
        })
    })
}

function eventoTextArea(){
    const patron = /^[A-Za-zñÑáéíóúÁÉÍÓÚüÜ0-9., ]{0,100}$/;

    observacion.addEventListener('keyup', ()=>{
        observacion.setCustomValidity("");
            
        if (!patron.test(observacion.value)){
            observacion.setCustomValidity("Debes digitar solo números y letras, máximo 100 caracteres");
            observacion.reportValidity();  
        };
    })
}

function eventoPuerta(){
    const botonPuerta = document.getElementById('btn_puerta');
    botonPuerta.addEventListener('click', ()=>{
        modalSeleccionPuerta(urlBase, validarPuertaActual);
    })

    document.getElementById('btn_puerta_mobile').addEventListener('click', ()=>{
        modalSeleccionPuerta(urlBase, validarPuertaActual);
    })
}

function validarPuertaActual(){
    if(puerta.value){
        if(puerta.value == 'PEATONAL'){
            abrirFormularioPeatonal();

        }else if(puerta.value == 'PRINCIPAL' || puerta.value == 'GANADERIA'){
            abrirFormularioVehicular();
        }

    }else{
        modalSeleccionPuerta(urlBase, validarPuertaActual);
    }
}

function eventoManualInputPlaca(){
    const evento = new Event("change", { bubbles: true, cancelable: true });
    placaVehiculo.dispatchEvent(evento);
}

function eventoManualInputPropietario(){
    const evento = new Event("change", { bubbles: true, cancelable: true });
    documentoPropietario.dispatchEvent(evento);
}

function eventoManualFormularioPasajeros(){
    const evento = new Event("submit", { bubbles: true, cancelable: true });
    formularioPasajeros.dispatchEvent(evento);
}

function eventoManualBotonSalida(){
    const evento = new Event("click", { bubbles: true, cancelable: true });
    botonRegistrarSalida.dispatchEvent(evento);
}

function eventoScanerQrPropietario(){
    document.getElementById('btn_scaner_qr_propietario').addEventListener('click', ()=>{
        modalScanerQr(urlBase, documentoPropietario, eventoManualInputPropietario);
    })
}

function eventoScanerQrPasajero(){
    document.getElementById('btn_scaner_qr_pasajero').addEventListener('click', ()=>{
        modalScanerQr(urlBase, documentoPasajero, eventoManualFormularioPasajeros);
    })
}

function limpiarFormularioVehicular(){
    placaVehiculo.value = '';
    selectTipoVehiculo.value = '';
    documentoPropietario.value = '';
    documentoPasajero.value = '';
    observacion.value = '';
    cuerpoTablaPasajeros.innerHTML = '';
    datosSalidaVehicular.propietario = '';
    datosSalidaVehicular.placa = '';
    datosSalidaVehicular.tipoVehiculo = '';
    datosSalidaVehicular.pasajeros = [];
    placaVehiculo.classList.remove('input-ok');
    documentoPropietario.classList.remove('input-ok');
    placaVehiculo.classList.remove('input-error');
    documentoPropietario.classList.remove('input-error');

    if(cajaTipoVehiculo.style.display == 'block'){
        cajaTipoVehiculo.style.display = 'none';
        selectTipoVehiculo.required = false;

        cajaPropietarioBtn.style.gridColumn = 'span 1';

        if(window.innerWidth <= 767){
            contenedorVehiculoPropietario.style.gridTemplateColumns = 'repeat(1,1fr)';
        }
    }
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
            if(respuesta.titulo == "Entrada No Registrada"){
                modalRegistroNovedadUsuario( urlBase, 'ENTRADA NO REGISTRADA',  respuesta.documento, respuesta.callback);
            }else if(respuesta.titulo == "Usuario No Encontrado"){
                modalRegistroVisitante(urlBase, respuesta.documento, respuesta.callback);
            }else if(respuesta.titulo == "Propietario Incorrecto"){
                modalRegistroNovedadVehiculo(urlBase, 'VEHICULO PRESTADO', respuesta.documento, respuesta.vehiculo, respuesta.callback);
            }
        } 
    });
}

document.addEventListener('DOMContentLoaded', ()=>{
    urlBase = document.getElementById('url_base').value;
    documentoPeaton = document.getElementById("documento_peaton");
    documentoPropietario = document.getElementById('documento_propietario');
    documentoPasajero = document.getElementById('documento_pasajero');
    selectTipoVehiculo = document.getElementById('tipo_vehiculo');
    contenedorVehiculoPropietario = document.getElementById('contenedor_vehiculo_propietario');
    cajaPropietarioBtn = document.getElementById('caja_propietario_btn');
    cajaTipoVehiculo = document.getElementById('caja_tipo_vehiculo');
    cuerpoTablaPasajeros = document.getElementById('cuerpo_tabla_pasajeros');
    listaPropietarios = document.getElementById('lista_propietarios');
    placaVehiculo = document.getElementById('placa_vehiculo');
    observacion = document.getElementById('observacion_vehicular');
    botonVehicular = document.getElementById('btn_vehicular');
    botonPeatonal = document.getElementById('btn_peatonal');
    botonRegistrarSalida = document.getElementById('registrar_salida');
    formularioPasajeros = document.getElementById('formulario_pasajeros');
    formularioPeatonal = document.getElementById("formulario_peatonal"); 
    formularioVehicular = document.getElementById("formulario_vehicular");
    contenedorBotonesFormularios = document.getElementById('contenedor_btns_formularios');
    puerta = document.getElementById('puerta');

    eventoInputPlaca();
    eventoSelectTipoVehiculo();
    eventoInputPropietario();
    eventoFormularioPasajeros();
    eventoTextArea();
    eventoRegistrarSalidaVehicular();
    eventoScanerQrPropietario();
    eventoScanerQrPasajero();
    eventoPuerta();
    validarPuertaActual();
});