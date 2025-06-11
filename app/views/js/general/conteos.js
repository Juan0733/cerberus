import {conteoTotalUsuarios} from '../fetchs/usuarios-fetch.js'
import {conteoTotalBrigadistas} from '../fetchs/funcionarios-fetch.js'
import {modalFuncionariosBrigadistas} from '../modales/modal-funcionarios-brigadistas.js'

let urlBase;
let contadorMultitud;
let contadorMultitudInicio;
let contadorBrigadistas;

function dibujarConteoMultitud(){
    conteoTotalUsuarios(urlBase).then(respuesta => {
        if(respuesta.tipo == 'OK'){
            contadorMultitud.innerText = "Multitud: " + respuesta.total_usuarios;
            if(contadorMultitudInicio){
                contadorMultitudInicio.innerHTML ="Multitud: " + respuesta.total_usuarios;
            }
        }else if(respuesta.tipo == 'ERROR'){
            if(respuesta.titulo == 'Sesión Expirada'){
                window.location.replace(urlBase+'sesion-expirada');
            }else{
                alertaError(datos);
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
                alertaError(datos);
            }
        }
    })
}

function eventoBrigadistas(){
    document.getElementById('btn_brigadistas').addEventListener('click', ()=>{
        modalFuncionariosBrigadistas(urlBase);
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

document.addEventListener('DOMContentLoaded', () => {
    urlBase = document.getElementById('url_base').value;
    contadorMultitud = document.getElementById('contador_multitud');
    contadorMultitudInicio = document.querySelector(".titulo_multi_detalle");
    contadorBrigadistas = document.getElementById('contador_brigadistas')
    dibujarConteoMultitud();
    dibujarConteoBrigadistas();
    eventoBrigadistas();
    setInterval(() => {
        dibujarConteoMultitud();
        dibujarConteoBrigadistas();
    }, 60000);
})


