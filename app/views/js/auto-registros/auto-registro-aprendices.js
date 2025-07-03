import { registrarAprendiz } from '../fetchs/aprendices-fetch.js';
import {consultarFicha, consultarFichas} from '../fetchs/fichas-fetch.js';

let urlBase;
let caja01;
let caja02;
let botonAtras;
let botonSiguiente;
let botonRegistrar;

function eventoAutoRegistrarAprendiz(){
    const formularioAprendiz = document.getElementById('formulario_aprendiz');
    formularioAprendiz.addEventListener('submit', (e)=>{
        e.preventDefault();
        let formData = new FormData(formularioAprendiz);
        formData.append('operacion', 'registrar_aprendiz');

        registrarAprendiz(formData, urlBase).then(respuesta=>{
            if(respuesta.tipo == "OK"){
                alertaExito(respuesta);

            }else if(respuesta.tipo == "ERROR"){ 
                alertaError(respuesta);
            }
        });
    })
}

function dibujarFichas(){
    const dataListFichas = document.getElementById('lista_fichas');
    consultarFichas(urlBase).then(respuesta=>{
        if(respuesta.tipo == 'OK'){
            respuesta.fichas.forEach(ficha => {
                dataListFichas.innerHTML += `
                    <option value="${ficha.numero_ficha}">${ficha.numero_ficha}</option>
                    `
            });

        }else if(respuesta.tipo == 'ERROR' && respuesta.titulo != 'Datos No Encontrados'){
            alertaError(respuesta);
        }
    })
}

function eventoInputFicha(){
    const inputFicha = document.getElementById('numero_ficha');
    const inputPrograma = document.getElementById('nombre_programa');
    const inputFechaFicha = document.getElementById('fecha_fin_ficha');

    inputFicha.addEventListener('change', ()=>{
        consultarFicha(inputFicha.value, urlBase).then(respuesta=>{
            if(respuesta.tipo == 'OK'){
                inputPrograma.value = respuesta.datos_ficha.nombre_programa;
                inputFechaFicha.value = respuesta.datos_ficha.fecha_fin_ficha;

            }else if(respuesta.tipo == 'ERROR' && respuesta.titulo != 'Ficha No Encontrada'){
                alertaError(respuesta);
            }
        })
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
            window.location.replace(urlBase+'auto-registro-aprendices');
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
    botonAtras = document.getElementById('btn_atras_aprendiz');
    botonSiguiente = document.getElementById('btn_siguiente_aprendiz');
    botonRegistrar = document.getElementById('btn_registrarme_aprendiz');

    dibujarFichas();
    eventoInputFicha();
    motrarCampos();
    volverCampos();
    eventoAutoRegistrarAprendiz();
})

