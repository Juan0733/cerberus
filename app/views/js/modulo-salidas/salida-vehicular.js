import {validarUsuarioAptoSalida} from '../fetchs/movimientos-fetch.js';
import {registrarSalidaVehicular} from '../fetchs/movimientos-fetch.js';
import {consultarVehiculo} from '../fetchs/vehiculos-fetch.js';
import {consultarPropietarios} from '../fetchs/vehiculos-fetch.js';
import {modalRegistroVehiculo} from '../modales/modal-registro-vehiculo.js';
import {modalRegistroVisitante} from '../modales/modal-registro-visitante.js';
import {modalRegistroNovedadUsuario} from '../modales/modal-registro-novedad-usuario.js';
import { modalRegistroNovedadVehiculo } from '../modales/modal-registro-novedad-vehiculo.js';

let documentoPropietario;
let documentoPasajero;
let placaVehiculo;
let observacion;
let cuerpoTablaPasajeros;
let listaPropietarios;
let urlBase;

const datosEntradaVehicular = {
    placa: "",
    propietario: "",
    pasajeros: []
};

function eventoAbrirFormularioVehicular() {
    const botonVehicular = document.getElementById('btn_vehicular');
    const botonPeatonal = document.getElementById('btn_peatonal');
    const formularioVehicular = document.getElementById('formulario_vehicular');
    const formularioPeatonal = document.getElementById('formulario_peatonal');
    const contenedorBotonVolver = document.getElementById('contenedor_btn_volver');

    botonVehicular.addEventListener('click', ()=>{
        limpiarFormularioVehicular();
        if(window.innerWidth > 1023){
            if (formularioPeatonal.style.display == "flex") {
                formularioPeatonal.style.display = "none"
                botonPeatonal.style.display = 'flex';
            }

            botonVehicular.style.display = "none"
            formularioVehicular.style.display = "flex"
            placaVehiculo.focus();

        }else{
            botonVehicular.style.display = "none";
            botonPeatonal.style.display = "none";
            contenedorBotonVolver.style.display = 'flex';
            formularioVehicular.style.display = "flex"
            placaVehiculo.focus();
        }
    });
}

function validarVehiculoAptoEntrada(){
    consultarVehiculo(placaVehiculo.value, urlBase).then(respuesta => {
        if(respuesta.tipo == "OK"){
            placaVehiculo.classList.remove('input-error');
            placaVehiculo.classList.add('input-ok');
            documentoPropietario.focus();
            datosEntradaVehicular.placa = placaVehiculo.value;
            dibujarPropietarios();
            
        }else if(respuesta.tipo == "ERROR"){
            if(respuesta.titulo == "Vehículo No Encontrado"){
                placaVehiculo.classList.remove('input-ok');
                placaVehiculo.classList.add('input-error');
                respuesta.vehiculo = placaVehiculo.value;
                respuesta.callback = validarVehiculoAptoEntrada;
                alertaAdvertencia(respuesta);

            }else if(respuesta.titulo == 'Sesión Expirada'){
                window.location.replace(urlBase+'sesion-expirada');
                
            }else{
                alertaError(respuesta);
            }
        }
    });
}

function validarPropietarioAptoEntrada(){
    validarUsuarioAptoSalida(documentoPropietario.value, urlBase).then(respuesta => {
        if(respuesta.tipo == "OK"){
            documentoPropietario.classList.remove('input-error');
            documentoPropietario.classList.add('input-ok');
            documentoPasajero.focus();
            datosEntradaVehicular.propietario = documentoPropietario.value;

        }else if(respuesta.tipo == "ERROR"){
            datosEntradaVehicular.propietario = "";
            if(respuesta.titulo == "Usuario No Encontrado" || respuesta.titulo == "Entrada No Registrada"){
                documentoPropietario.classList.remove('input-ok');
                documentoPropietario.classList.add('input-error');
                respuesta.documento = documentoPropietario.value;
                respuesta.callback = validarPropietarioAptoEntrada;
                alertaAdvertencia(respuesta);

            }else if(respuesta.titulo == 'Sesión Expirada'){
                window.location.replace(urlBase+'sesion-expirada');

            }else{
                alertaError(respuesta);
            }
        }
    });
}

function validarPasajeroAptoEntrada(){
    validarUsuarioAptoSalida(documentoPasajero.value, urlBase).then(respuesta => {
        if(respuesta.tipo == "OK"){
            let datosPasajero = {
                documento_pasajero: documentoPasajero.value,
                nombres: `${respuesta.usuario.nombres} ${respuesta.usuario.apellidos}`
            }
            datosEntradaVehicular.pasajeros.push(datosPasajero);
            documentoPasajero.value = '';
            dibujarTablaPasajeros();
            
        }else if(respuesta.tipo == "ERROR"){
            if(respuesta.titulo == "Usuario No Encontrado" || respuesta.titulo == "Entrada No Registrada"){
                respuesta.documento = documentoPasajero.value;
                respuesta.callback = validarPasajeroAptoEntrada;
                alertaAdvertencia(respuesta);

            }else if(respuesta.titulo == 'Sesión Expirada'){
                window.location.replace(urlBase+'sesion-expirada');

            }else{
                alertaError(respuesta);
            }
        }
    });
}

function dibujarTablaPasajeros(){
    cuerpoTablaPasajeros.innerHTML = '';

    datosEntradaVehicular.pasajeros.forEach((pasajero, indice) => {
        cuerpoTablaPasajeros.innerHTML += `
            <tr>
                <td>${pasajero.documento_pasajero}</td>
                <td>${pasajero.nombres}</td>
                <td>
                    <button type="button" id="${indice}" class ="eliminar-pasajero">
                        <ion-icon name="trash-outline" role="img" class="md hydrated"></ion-icon>
                    </button>
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
            datosEntradaVehicular.pasajeros.splice(indice, 1);
            dibujarTablaPasajeros();
        })
    });
}

function eventoInputPlaca(){
    let temporizador;
    placaVehiculo.addEventListener('keyup',()=>{
        datosEntradaVehicular.placa = "";
        placaVehiculo.classList.remove('input-ok');
        placaVehiculo.classList.remove('input-error');
      
        clearTimeout(temporizador);
        temporizador = setTimeout(() => {
            if (placaVehiculo.checkValidity()) {
                validarVehiculoAptoEntrada();
                placaVehiculo.blur();
            }else{
                placaVehiculo.reportValidity();
            }
        }, 1500);
    })
}

function validarDocumentoPropietario(){
    if(documentoPropietario.checkValidity()) {
        let existePasajero = false;
        for(const pasajero of datosEntradaVehicular.pasajeros){
            if(pasajero.documento_pasajero == documentoPropietario.value){
                existePasajero = true;
                break;
            }
        }

        if(!existePasajero){
            validarPropietarioAptoEntrada();
        }else{
            let mensaje = {
                titulo: "Error Propietario",
                mensaje: `El usuario con numero de documento ${documentoPropietario.value}, ya se encuentra en la lista de pasajeros.`
            };

            documentoPropietario.classList.add('input-error');
            alertaError(mensaje);
        }
    }else{
        documentoPropietario.reportValidity();
    }
}

function eventoInputPropietario(){
    let temporizador;
    
    documentoPropietario.addEventListener('input', ()=>{
        datosEntradaVehicular.propietario = '';
        datosEntradaVehicular.grupo_propietario = '';
        documentoPropietario.classList.remove('input-ok');
        documentoPropietario.classList.remove('input-error');

        
        if(documentoPropietario.value.length > 15){
            clearTimeout(temporizador);
            temporizador = setTimeout(()=>{
                let documentoFormateado = documentoPropietario.value.replace(/\D/g, '').slice(0, 10);   
                documentoPropietario.value = documentoFormateado;
                documentoPropietario.blur();
                validarDocumentoPropietario();
            }, 250);
        }else{
            clearTimeout(temporizador);
            temporizador = setTimeout(()=>{
                validarDocumentoPropietario();
            }, 1500)
        }
    })
}

function eventoInputPasajero(){
    documentoPasajero.addEventListener('change',()=>{  
        if(documentoPasajero.value.length > 15){  
            let documentoFormateado = documentoPasajero.value.replace(/\D/g, '').slice(0, 10);   
            documentoPasajero.value = documentoFormateado;
        }
    });
}

function eventoAgregarPasajero(){
    document.getElementById('formulario_pasajeros').addEventListener('submit', (e)=>{
        e.preventDefault();
        if(datosEntradaVehicular.propietario != documentoPasajero.value){
            let existePasajero = false;
            for(const pasajero of datosEntradaVehicular.pasajeros){
                if(pasajero.documento_pasajero == documentoPasajero.value){
                    existePasajero = true;
                    break;
                }
            }

            if(!existePasajero){
                validarPasajeroAptoEntrada();
            }else{
                let mensaje = {
                    titulo: "Error Pasajero",
                    mensaje: `El usuario con numero de documento ${documentoPropietario.value}, ya se encuentra en la lista de pasajeros.`
                };
                alertaError(mensaje);
            }
        }else{
            let mensaje = {
                titulo: "Error Pasajero",
                mensaje: `El usuario con numero de documento ${documentoPropietario.value}, ya se encuentra como propietario.`
            };
            alertaError(mensaje);
        }
        
    });
}

function eventoRegistrarSalidaVehicular(){
    document.getElementById('registrar_salida').addEventListener('click', ()=>{
        if(!placaVehiculo.checkValidity()){
            placaVehiculo.reportValidity();
        }else if(!documentoPropietario.checkValidity()){
            documentoPropietario.reportValidity();
        }else if(!observacion.reportValidity()){
            return;
        }else if(datosEntradaVehicular.placa == ''){
           validarVehiculoAptoEntrada();
        }else if(datosEntradaVehicular.propietario == ''){
            validarPropietarioAptoEntrada();
        }else{
            const formData = new FormData();
            const pasajeros = JSON.stringify(datosEntradaVehicular.pasajeros);

            formData.append('operacion', 'registrar_salida_vehicular');
            formData.append('propietario', datosEntradaVehicular.propietario);
            formData.append('grupo_propietario', datosEntradaVehicular.grupo_propietario);
            formData.append('placa_vehiculo', datosEntradaVehicular.placa);
            formData.append('pasajeros', pasajeros);
            formData.append('observacion_vehicular', observacion.value);

            registrarSalidaVehicular(formData, urlBase).then(respuesta=>{
                if(respuesta.tipo == 'OK'){
                    alertaExito(respuesta);
                    limpiarFormularioVehicular();
                    placaVehiculo.focus();
                   
                }else if(respuesta.tipo == 'ERROR'){
                    if(respuesta.titulo == 'Propietario Incorrecto'){
                        respuesta.documento = datosEntradaVehicular.propietario;
                        respuesta.vehiculo= datosEntradaVehicular.placa;
                        alertaAdvertencia(respuesta)
                    }else if(respuesta.titulo == 'Sesión Expirada'){
                        window.location.replace(urlBase+'sesion-expirada');
                    }else{
                        alertaError(respuesta);
                    }
                }
            })
            
        }
    })
}

function eventoTextArea(){
    let temporizador;
    let primeraValidacion = true;

    observacion.addEventListener('keyup', ()=>{
        clearTimeout(temporizador);
        temporizador = setTimeout(()=>{
            let patron = /^[A-Za-zñÑáéíóúÁÉÍÓÚüÜ0-9 ]{0,100}$/;
    
            if (!patron.test(observacion.value)){

                if(primeraValidacion){
                    observacion.setCustomValidity("Debes digitar solo números y letras, máximo 100 caracteres");
                    observacion.reportValidity();
                    primeraValidacion = false;
                }

            } else {
                observacion.setCustomValidity(""); 
                primeraValidacion = true;
            }
        }, 1000);
    })
}

function dibujarPropietarios(){
    consultarPropietarios(datosEntradaVehicular.placa, urlBase).then(respuesta=>{
        if(respuesta.tipo == 'OK'){
            listaPropietarios.innerHTML = '';

            respuesta.propietarios.forEach(propietario=>{
                listaPropietarios.innerHTML += `
                    <option value="${propietario.numero_documento}">${propietario.numero_documento}</option>
                `;
            })

        }else if(respuesta.tipo == 'ERROR'){
            if(respuesta.titulo == 'Sesión Expirada'){
                window.location.replace(urlBase+'sesion-expirada');

            }else{
                alertaError(respuesta);
            }
        }
    })
}

function limpiarFormularioVehicular(){
    placaVehiculo.value = '';
    documentoPropietario.value = '';
    documentoPasajero.value = '';
    observacion.value = '';
    cuerpoTablaPasajeros.innerHTML = '';
    datosEntradaVehicular.propietario = '';
    datosEntradaVehicular.grupo_propietario = '';
    datosEntradaVehicular.placa = '';
    datosEntradaVehicular.pasajeros = [];
    placaVehiculo.classList.remove('input-ok');
    documentoPropietario.classList.remove('input-ok');
    placaVehiculo.classList.remove('input-error');
    documentoPropietario.classList.remove('input-error');
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
                modalRegistroNovedadUsuario( urlBase, 'Entrada no registrada',  respuesta.documento, respuesta.callback);
            }else if(respuesta.titulo == "Usuario No Encontrado"){
                modalRegistroVisitante(urlBase, respuesta.documento, respuesta.callback);
            }else if(respuesta.titulo == "Vehículo No Encontrado"){
                modalRegistroVehiculo(urlBase, respuesta.vehiculo, respuesta.callback);
            }else if(respuesta.titulo == "Propietario Incorrecto"){
                modalRegistroNovedadVehiculo(urlBase, 'Vehiculo prestado', respuesta.documento, respuesta.vehiculo);
            }
        } 
    });
}


document.addEventListener('DOMContentLoaded', ()=>{
    urlBase = document.getElementById('url_base').value;
    documentoPropietario = document.getElementById('documento_propietario');
    documentoPasajero = document.getElementById('documento_pasajero');
    cuerpoTablaPasajeros = document.getElementById('cuerpo_tabla_pasajeros');
    listaPropietarios = document.getElementById('lista_propietarios');
    placaVehiculo = document.getElementById('placa_vehiculo');
    observacion = document.getElementById('observacion_vehicular');

    eventoAbrirFormularioVehicular();
    eventoInputPlaca();
    eventoInputPropietario();
    eventoInputPasajero();
    eventoAgregarPasajero();
    eventoTextArea();
    eventoRegistrarSalidaVehicular();
});