import {validarUsuarioAptoEntrada} from '../fetchs/movimientos-fetch.js'
import {consultarVehiculo} from '../fetchs/vehiculos-fetch.js'
import {modalRegistroVehiculo} from '../modales/modal-registro-vehiculo.js';
import {modalRegistroVisitante} from '../modales/modal-registro-visitante.js';
import {modalRegistroNovedad} from '../modales/modal-registro-novedad.js';

let documentoPropietario;
let documentoPasajero;
let placaVehiculo
let formularioPasajeros;
let formularioVehicular;
let botonPeatonal;
let botonVehicular;
let urlBase;

const datosEntradaVehicular = {
    placa: "",
    propietario: "",
    pasajeros: []
};

function mostrarFormularioVehicular(){
    if (botonPeatonal.style.display == "none") {
        if (window.innerWidth >= 780) {
            botonPeatonal.style.display = "flex"
        }
        document.getElementById('formulario_peatonal').style.display = "none"
        botonVehicular.style.display = "none"
        formularioVehicular.style.display = "flex"
        placaVehiculo.focus();
    }else{
        
        if (window.innerWidth <= 779) {
            botonPeatonal.style.display = "none"
            document.querySelector('.cont-btn-volver').style.display = 'flex'
        }
        
        botonVehicular.style.display = "none"
        formularioVehicular.style.display = "flex"
        placaVehiculo.focus();
    }
}

function validarExistenciaVehiculo(){
    consultarVehiculo(placaVehiculo.value, urlBase).then(respuesta => {
        if(respuesta.tipo == "ERROR"){
            datosEntradaVehicular.placa = "";
            console.log(datosEntradaVehicular)
            if(respuesta.titulo == "Vehículo No Encontrado"){
                alertaAdvertencia(respuesta);
            }else{
                alertaError(respuesta);
            }
        }else if(respuesta.tipo == "OK"){
            datosEntradaVehicular.placa = placaVehiculo.value;
            console.log(datosEntradaVehicular);
        }
    });
}

function validarPropietarioAptoEntrada(){
    validarUsuarioAptoEntrada(documentoPropietario.value, urlBase).then(respuesta => {
        if(respuesta.tipo == "ERROR"){
            datosEntradaVehicular.propietario = "";
            console.log(datosEntradaVehicular)
            if(respuesta.titulo == "Usuario No Encontrado" || respuesta.titulo == "Salida No Registrada"){
                respuesta.documento = documentoPropietario.value;
                respuesta.funcion = validarPropietarioAptoEntrada;
                alertaAdvertencia(respuesta);
            }else if(respuesta){
                alertaError(respuesta);
            }
        }else if(respuesta.tipo == "OK"){
            datosEntradaVehicular.propietario = documentoPropietario.value;
            console.log(datosEntradaVehicular);
        }
    });
}

function eventoInputPropietario(){
    let temporizador;
    documentoPropietario.addEventListener('input',()=>{
        clearTimeout(temporizador);
        temporizador = setTimeout(() => {
            if (documentoPropietario.value.length >= 6) {
                if (documentoPropietario.value.length > 15) {
                    let documentoFormateado = documentoPropietario.value.replace(/\D/g, '').slice(0, 10);   
                    documentoPropietario.value = documentoFormateado;
                }
                validarPropietarioAptoEntrada();
            }
        }, 1500);
    })
}

function eventoInputPlaca(){
    let temporizador;
    placaVehiculo.addEventListener('input',()=>{
        clearTimeout(temporizador);
        temporizador = setTimeout(() => {
            if (placaVehiculo.value.length >= 5) {
                validarExistenciaVehiculo();
            }
        }, 1500);
    })
}

function eventoInputPasajero(){
    documentoPasajero.addEventListener('input',()=>{  
        if(documentoPasajero.value.length > 15){  
            let documentoFormateado = documentoPasajero.value.replace(/\D/g, '').slice(0, 10);   
            documentoPasajero.value = documentoFormateado;
        }
    });
}

function validarPasajeroAptoEntrada(){
    validarUsuarioAptoEntrada(documentoPasajero.value, urlBase).then(respuesta => {
        if(respuesta.tipo == "ERROR"){
            datosEntradaVehicular.pasajeros = [];
            if(respuesta.titulo == "Usuario No Encontrado" || respuesta.titulo == "Salida No Registrada"){
                respuesta.documento = documentoPasajero.value;
                respuesta.funcion = validarPasajeroAptoEntrada;
                alertaAdvertencia(respuesta);
            }else{
                alertaError(respuesta);
            }
        }else if(respuesta.tipo == "OK"){
            let datosPasajero = {
                numero_documento: documentoPasajero.value,
                nombres: respuesta.usuario.nombres,
                grupo_usuario: respuesta.usuario.grupo
            }
            datosEntradaVehicular.pasajeros.push(datosPasajero);
            console.log(datosEntradaVehicular);
        }

function eventoFormularioPasajeros(){
    formularioPasajeros.addEventListener('submit', (e)=>{
        e.preventDefault();
        if(documentoPasajero.value.length < 6 ){
            

            if(datosEntradaVehicular.propietario != documentoPasajero.value){
                datosEntradaVehicular.pasajeros.forEach(pasajero => {
                    if(documentoPasajero.value == pasajero.numero_documento){
                        return;
                    }
                });

                validarPasajeroAptoEntrada();
            }


        }
        let formData = new FormData(formularioPasajeros);
        formData.append('operacion', 'registrar_entrada_peatonal');
        formData.append('documento_propietario', documentoPropietario.value);
        formData.append('placa_vehiculo', placaVehiculo.value);
        formData.append('documento_pasajero', documentoPasajero.value);

        registrarEntradaPeatonal(formData, urlBase).then(respuesta=>{
            if(respuesta.tipo == "ERROR" ){
                if(respuesta.titulo == "Usuario No Encontrado"){
                    alertaAdvertencia(respuesta);
                }else{
                    alertaError(respuesta);
                }
                
            }else if(respuesta.tipo == "OK"){
                alertaExito(respuesta);
                formularioPasajeros.reset();
                eventoInputPasajero();
            }
        });
    });
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
            if(respuesta.titulo == "Salida No Registrada"){
                modalRegistroNovedad('Salida no registrada',  respuesta.documento, urlBase, respuesta.funcion);
            }else if(respuesta.titulo == "Usuario No Encontrado"){
                modalRegistroVisitante(urlBase, respuesta.documento, respuesta.funcion);
            }else if(respuesta.titulo == "Vehículo No Encontrado"){
                modalRegistroVehiculo(placaVehiculo.value, respuesta.funcion,  urlBase);
            }
        } 
    });
}

function eventoBotonVehicular() {
    botonVehicular.addEventListener('click', function() {
        mostrarFormularioVehicular();
    });
}

document.addEventListener('DOMContentLoaded', ()=>{
    urlBase = document.getElementById('url_base').value;
    formularioPasajeros = document.getElementById('formulario_pasajeros');
    formularioVehicular = document.getElementById('formulario_vehicular');
    botonPeatonal = document.getElementById('btn_peatonal');
    botonVehicular = document.getElementById('btn_vehicular');
    documentoPropietario = document.getElementById('documento_propietario');
    documentoPasajero = document.getElementById('documento_pasajero');
    placaVehiculo = document.getElementById('placa_vehiculo');

    eventoBotonVehicular();
    eventoInputPlaca();
    eventoInputPropietario();
})