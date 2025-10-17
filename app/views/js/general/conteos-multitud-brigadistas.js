import {conteoTotalUsuarios} from '../fetchs/usuarios-fetch.js'
import {conteoTotalBrigadistas} from '../fetchs/funcionarios-fetch.js'
import {modalBrigadistas} from '../modales/modal-brigadistas.js'
import { modalSeleccionPuerta } from '../modales/modal-seleccion-puerta.js';

let urlBase;
let contadorMultitud;
let contadorMultitudMobile;
let contadorBrigadistas;
let contadorBrigadistasMobile;

function dibujarConteos(conteoMultitud, conteoBrigadistas){
    contadorMultitud.innerText = conteoMultitud;
    contadorMultitudMobile.innerText = conteoMultitud;

    contadorBrigadistas.innerText = conteoBrigadistas;
    contadorBrigadistasMobile.innerText = conteoBrigadistas;
}

function dibujarConteosActuales(){
    const ultimaActualizacion = sessionStorage.getItem('ultima_actualizacion_conteos');
    const momentoActual = Date.now();
    const intervalo = 30 * 1000;

    if(!ultimaActualizacion || momentoActual - ultimaActualizacion > intervalo){
        conteoTotalUsuarios(urlBase).then(respuesta => {
            if(respuesta.tipo == 'OK'){
                const conteoMultitud = respuesta.total_usuarios;
                sessionStorage.setItem('conteo_multitud', conteoMultitud)

                conteoTotalBrigadistas(urlBase).then(respuesta=>{
                    if(respuesta.tipo == 'OK'){
                        const conteoBrigadistas = respuesta.total_brigadistas;
                        sessionStorage.setItem('conteo_brigadistas', conteoBrigadistas);

                        dibujarConteos(conteoMultitud, conteoBrigadistas);
                        sessionStorage.setItem('ultima_actualizacion_conteos', Date.now())

                    }else if(respuesta.tipo == 'ERROR'){
                        if(respuesta.titulo == 'Sesión Expirada'){
                            window.location.replace(urlBase+'sesion-expirada');
                        }else{
                            alertaError(respuesta);
                        }
                    }
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
}

function dibujarConteosGuardados(){
    const conteoMultitud = sessionStorage.getItem('conteo_multitud');
    const conteoBrigadistas = sessionStorage.getItem('conteo_brigadistas');
    if(conteoMultitud && conteoBrigadistas){
        dibujarConteos(conteoMultitud, conteoBrigadistas);
    }
}

function eventoBrigadistas(){
    document.getElementById('btn_brigadistas').addEventListener('click', ()=>{
        modalBrigadistas(urlBase);
    })

    document.getElementById('btn_brigadistas_mobile').addEventListener('click', ()=>{
        modalBrigadistas(urlBase);
    })
}

function eventoPuerta(){
    const botonPuerta = document.getElementById('btn_puerta');

    if(botonPuerta && !document.getElementById('btn_peatonal')){
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
    contadorBrigadistas = document.getElementById('contador_brigadistas');
    contadorBrigadistasMobile = document.getElementById('contador_brigadistas_mobile');

    dibujarConteosGuardados();
    dibujarConteosActuales();
    eventoBrigadistas();
    eventoPuerta();
    
    setInterval(dibujarConteosActuales, 1000);
})


