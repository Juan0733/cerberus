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
        }else{
            console.error(respuesta.mensaje);
        }
    })
}

function dibujarConteoBrigadistas(){
    conteoTotalBrigadistas(urlBase).then(respuesta=>{
        if(respuesta.tipo == 'OK'){
            contadorBrigadistas.innerText = "Brigadistas: " + respuesta.total_brigadistas;
        }else{
            console.error(respuesta.mensaje);
        }
    })
}

function eventoBrigadistas(){
    document.getElementById('btn_brigadistas').addEventListener('click', ()=>{
        modalFuncionariosBrigadistas(urlBase);
    })
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


