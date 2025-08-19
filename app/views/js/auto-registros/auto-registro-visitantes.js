import { consultarMotivosIngreso } from '../fetchs/motivos-ingreso.js';
import {registrarVisitante} from '../fetchs/visitantes-fetch.js';

let urlBase;
let caja01;
let caja02;
let botonAtras;
let botonSiguiente;
let botonRegistrar;

function eventoAutoRegistrarVisitante(){
    const formularioVisitante = document.getElementById('formulario_visitante');
    formularioVisitante.addEventListener('submit', (e)=>{
        e.preventDefault();
        let formData = new FormData(formularioVisitante);
        formData.append('operacion', 'registrar_visitante');

        registrarVisitante(formData, urlBase).then(respuesta=>{
            if(respuesta.tipo == "OK"){
                respuesta.mensaje = "Te has registrado correctamente, ¡Bienvenido al CAB!"
                alertaExito(respuesta);

            }else if(respuesta.tipo == "ERROR"){ 
                alertaError(respuesta);
            }
        });
    })
}

function dibujarMotivosIngreso(){
    const dataListMotivos = document.getElementById('lista_motivos');

    consultarMotivosIngreso(urlBase).then(respuesta=>{
        if(respuesta.tipo == 'OK'){
            respuesta.motivos_ingreso.forEach(motivo => {
                dataListMotivos.innerHTML += `
                    <option value="${motivo.motivo}"></option>`;
            });

        }else if(respuesta.tipo == 'ERROR' && respuesta.titulo != 'Datos No Encontrados'){
            alertaError(respuesta);
        }
    })
}

function motrarCampos() {
    const inputsSeccion01 = document.getElementsByClassName('campo-seccion-01');
    const inputCorreo = document.getElementById('correo_electronico');

    botonSiguiente.addEventListener('click', ()=>{
        let validos = true;

        for(const input of inputsSeccion01) {
            if(!input.checkValidity()){
                input.reportValidity();
                validos = false;
                break;
            }
        };

        if(validos){
            caja01.style.display = 'none';
            botonSiguiente.style.display = 'none';
            caja02.style.display = 'flex';
            botonRegistrar.style.display = 'flex';
            botonAtras.style.display = 'flex';

            inputCorreo.focus();
        }
    })
}

function volverCampos() {
    const inputTipoDocumento = document.getElementById('tipo_documento');

    botonAtras.addEventListener('click', ()=>{
        caja02.style.display = 'none';
        botonAtras.style.display = 'none';
        botonRegistrar.style.display = 'none'
        caja01.style.display = 'flex';
        botonSiguiente.style.display = 'flex';

        inputTipoDocumento.focus();
    })
}

function alertaExito(respuesta){
    Swal.fire({
        icon: 'success',
        iconColor: "#2db910",
        color: '#F3F4F4',
        title: respuesta.titulo,
        text: respuesta.mensaje,
        confirmButtonText: 'OK',
        customClass: {
            popup: 'alerta-contenedor',
            confirmButton: 'btn-confirmar'
        }
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.replace(urlBase+'auto-registro-visitantes');
        } 
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

document.addEventListener('DOMContentLoaded', ()=>{
    urlBase = document.getElementById('url_base').value;
    caja01 = document.getElementById('caja_01');
    caja02 = document.getElementById('caja_02');
    botonAtras = document.getElementById('btn_atras_visitante');
    botonSiguiente = document.getElementById('btn_siguiente_visitante');
    botonRegistrar = document.getElementById('btn_registrarme_visitante');

    dibujarMotivosIngreso();
    motrarCampos();
    volverCampos();
    eventoAutoRegistrarVisitante();
})

