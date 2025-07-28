import {conteoTipoUsuario} from '../fetchs/usuarios-fetch.js'
import {conteoTipoVehiculo} from '../fetchs/vehiculos-fetch.js'
import { modalSeleccionPuerta } from '../modales/modal-seleccion-puerta.js';

let conteoAprendices;
let barraAprendices;
let porcentajeAprendices;
let conteoFuncionarios;
let barraFuncionarios;
let porcentajeFuncionarios;
let conteoVisitantes;
let barraVisitantes;
let porcentajeVisitantes;
let conteoVigilantes;
let barraVigilantes;
let porcentajeVigilantes;
let conteoCarros;
let barraCarros;
let porcentajeCarros;
let conteoMotos;
let barraMotos;
let porcentajeMotos;

let urlBase;

function dibujarConteoUsuarios(){
    conteoTipoUsuario(urlBase).then(respuesta => {
        if(respuesta.tipo == 'OK'){
            respuesta.usuarios.forEach(usuario => {
                if(usuario.tipo_usuario == 'aprendices'){
                    conteoAprendices.innerHTML = "<span class='numero'>" + usuario.cantidad + "</span> en el CAB";
                    barraAprendices.style.width = usuario.porcentaje + "%";
                    porcentajeAprendices.innerHTML = usuario.porcentaje + "% son Aprendices";
                } else if(usuario.tipo_usuario == 'funcionarios'){
                    conteoFuncionarios.innerHTML = "<span class='numero'>" + usuario.cantidad + "</span> en el CAB";
                    barraFuncionarios.style.width = usuario.porcentaje + "%";
                    porcentajeFuncionarios.innerHTML = usuario.porcentaje + "% son Funcionarios";
                } else if(usuario.tipo_usuario == 'visitantes'){
                   conteoVisitantes.innerHTML = "<span class='numero'>" + usuario.cantidad + "</span> en el CAB";
                    barraVisitantes.style.width = usuario.porcentaje + "%";
                    porcentajeVisitantes.innerHTML = usuario.porcentaje + "% son Visitantes";
                } else if(usuario.tipo_usuario == 'vigilantes'){
                    conteoVigilantes.innerHTML = "<span class='numero'>" + usuario.cantidad + "</span> en el CAB";
                    barraVigilantes.style.width = usuario.porcentaje + "%";
                    porcentajeVigilantes.innerHTML = usuario.porcentaje + "% son Vigilantes";
                }
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

function dibujarConteoVehiculos(){
    conteoTipoVehiculo(urlBase).then(respuesta => {
        if(respuesta.tipo == 'OK'){
            respuesta.vehiculos.forEach(vehiculo => {
                if(vehiculo.tipo_vehiculo == 'carros'){
                    conteoCarros.innerHTML = "<span class='numero'>" + vehiculo.cantidad + "</span> en el CAB";
                    barraCarros.style.width = vehiculo.porcentaje + "%";
                    porcentajeCarros.innerHTML = vehiculo.porcentaje + "% son Carros";
                } else if(vehiculo.tipo_vehiculo == 'motos'){
                    conteoMotos.innerHTML = "<span class='numero'>" + vehiculo.cantidad + "</span> en el CAB";
                    barraMotos.style.width = vehiculo.porcentaje + "%";
                    porcentajeMotos.innerHTML = vehiculo.porcentaje + "% son Motos";
                }
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
    conteoAprendices = document.getElementById('conteo_aprendices');
    barraAprendices = document.getElementById('barra_aprendices');
    porcentajeAprendices = document.getElementById('subtitle_barra_aprendices');
    conteoFuncionarios = document.getElementById('conteo_funcionarios');
    barraFuncionarios = document.getElementById('barra_funcionarios');
    porcentajeFuncionarios = document.getElementById('subtitle_barra_funcionarios');
    conteoVisitantes =  document.getElementById('conteo_visitantes');
    barraVisitantes = document.getElementById('barra_visitantes');
    porcentajeVisitantes = document.getElementById('subtitle_barra_visitantes');
    conteoVigilantes = document.getElementById('conteo_vigilantes');
    barraVigilantes = document.getElementById('barra_vigilantes');
    porcentajeVigilantes = document.getElementById('subtitle_barra_vigilantes');
    conteoCarros = document.getElementById('conteo_carros');
    barraCarros = document.getElementById('barra_carros');
    porcentajeCarros = document.getElementById('subtitle_barra_carros');
    conteoMotos = document.getElementById('conteo_motos');
    barraMotos = document.getElementById('barra_motos');
    porcentajeMotos = document.getElementById('subtitle_barra_motos');

    if(document.getElementById('puerta')){
        modalSeleccionPuerta(urlBase);
    }

    dibujarConteoUsuarios();
    dibujarConteoVehiculos();

    setInterval(() => {
        dibujarConteoUsuarios();
        dibujarConteoVehiculos();
    }, 60000);
});
