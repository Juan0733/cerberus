import {conteoTotalUsuarios} from '../fetchs/usuarios-fetch.js'
import {conteoTotalBrigadistas} from '../fetchs/funcionarios-fetch.js'
import {modalFuncionariosBrigadistas} from '../modales/modal-funcionarios-brigadistas.js'
import { modalSeleccionPuerta } from '../modales/modal-seleccion-puerta.js';

let urlBase;
let contadorMultitud;
let contadorMultitudMobile;
let contadorBrigadistas;

function dibujarConteoMultitud(){
    conteoTotalUsuarios(urlBase).then(respuesta => {
        if(respuesta.tipo == 'OK'){
            contadorMultitud.innerText = "Multitud: " + respuesta.total_usuarios;
            if(contadorMultitudMobile){
                contadorMultitudMobile.innerText ="Multitud: " + respuesta.total_usuarios;
            }
            
        }else if(respuesta.tipo == 'ERROR'){
            if(respuesta.titulo == 'Sesión Expirada'){
                window.location.replace(urlBase+'sesion-expirada');
            }else{
                alertaError(respuesta);
            }
        }
    })
}

function dibujarConteoBrigadistas(){
    conteoTotalBrigadistas(urlBase).then(respuesta=>{
        if(respuesta.tipo == 'OK'){
            contadorBrigadistas.innerText = "Brigadistas: " + respuesta.total_brigadistas;

        }else if(respuesta.tipo == 'ERROR'){
            if(respuesta.titulo == 'Sesión Expirada'){
                window.location.replace(urlBase+'sesion-expirada');
            }else{
                alertaError(respuesta);
            }
        }
    })
}

function eventoBrigadistas(){
    document.getElementById('btn_brigadistas').addEventListener('click', ()=>{
        modalFuncionariosBrigadistas(urlBase);
    })

    document.getElementById('btn_brigadistas_mobile').addEventListener('click', ()=>{
        modalFuncionariosBrigadistas(urlBase);
    })
}

function eventoPuerta(){
    const botonPuerta = document.getElementById('btn_puerta');

    if(botonPuerta){
        botonPuerta.addEventListener('click', ()=>{
            modalSeleccionPuerta(urlBase);
        })

        document.getElementById('btn_puerta_mobile').addEventListener('click', ()=>{
            modalSeleccionPuerta(urlBase);
        })
    }
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

document.addEventListener('DOMContentLoaded', () => {
    urlBase = document.getElementById('url_base').value;
    contadorMultitud = document.getElementById('contador_multitud');
    contadorMultitudMobile = document.getElementById("contador_multitud_mobile");
    contadorBrigadistas = document.getElementById('contador_brigadistas')
    dibujarConteoMultitud();
    dibujarConteoBrigadistas();
    eventoBrigadistas();
    eventoPuerta();
    setInterval(() => {
        dibujarConteoMultitud();
        dibujarConteoBrigadistas();
    }, 60000);
})


