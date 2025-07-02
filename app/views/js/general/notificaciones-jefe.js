import { consultarNotificacionesUsuario } from "../fetchs/usuarios-fetch.js";
import { consultarNotificacionesVehiculo } from "../fetchs/vehiculos-fetch.js";
import { modalRegistroNovedadUsuario } from "../modales/modal-registro-novedad-usuario.js"
import { modalRegistroPermisoUsuario } from "../modales/modal-registro-permiso-usuario.js";
import { modalRegistroPermisoVehiculo } from "../modales/modal-registro-permiso-vehiculo.js";

let urlBase;
let contenedorModal;
let cuerpoModal;
let contadorNotificaciones;
let contadorNotificacionesMobile;

function dibujarNotificaciones(){
    consultarNotificacionesUsuario(urlBase).then(respuesta=>{
        if(respuesta.tipo == 'OK'){
            const notificacionesUsuario = respuesta.notificaciones_usuario;
            consultarNotificacionesVehiculo(urlBase).then(respuesta=>{
                if(respuesta.tipo == 'OK'){
                    const notificacionesVehiculo = respuesta.notificaciones_vehiculo;
                    contadorNotificaciones.textContent = notificacionesUsuario.length + notificacionesVehiculo.length;
                    contadorNotificacionesMobile.textContent = notificacionesUsuario.length + notificacionesVehiculo.length;

                    if(notificacionesUsuario.length > 0 || notificacionesVehiculo.length > 0){
                        cuerpoModal.innerHTML = '';

                        notificacionesUsuario.forEach(notificacion => {
                            cuerpoModal.innerHTML += `
                                <div class="contenedor-alerta">
                                    <div class="contenedor-mensaje-alerta">
                                        <h3>Permanencia Usuario</h3>
                                        <p>El usuario con número de documento <strong>${notificacion.numero_documento}</strong> lleva ${notificacion.horas_permanencia} horas dentro del CAB</p>
                                        <div id="contenedor_btns_notificacion">
                                            <button class="btn-permiso-usuario" data-usuario="${notificacion.numero_documento}" data-estado-permiso="${notificacion.estado_permiso}">Solicitar permiso</button>
                                            <button class="btn-novedad" data-usuario="${notificacion.numero_documento}">Registrar novedad</button>
                                        </div>
                                    </div>
                                </div>`
                        });

                        notificacionesVehiculo.forEach(notificacion => {
                            cuerpoModal.innerHTML += `
                                <div class="contenedor-alerta">
                                    <div class="contenedor-mensaje-alerta">
                                        <h3>Permanencia Vehículo</h3>
                                        <p>El vehículo con número de placa <strong>${notificacion.numero_placa}</strong> lleva ${notificacion.horas_permanencia} horas dentro del CAB</p>
                                       <div id="contenedor_btns_notificacion">
                                            <button class="btn-permiso-vehiculo" data-vehiculo="${notificacion.numero_placa}" data-estado-permiso="${notificacion.estado_permiso}">Solicitar permiso</button>
                                        </div>
                                    </div>
                                </div>`
                        });

                        eventoRegistrarNovedadUsuario();
                        eventoSolicitarPermisoPermanenciaUsuario();
                        eventoSolicitarPermisoPermanenciaVehiculo();

                    }else if(notificacionesUsuario.length < 1 && notificacionesVehiculo.length < 1){
                        cuerpoModal.innerHTML = `<p id="mensaje_respuesta">No hay notificaciones en este momento.</p>`;
                    }
                }else if(respuesta.tipo == 'ERROR'){
                    cuerpoModal.innerHTML = `<p id="mensaje_respuesta">${respuesta.mensaje}</p>`;
                }
            })
        }else if(respuesta.tipo == 'ERROR'){
            cuerpoModal.innerHTML = `<p id="mensaje_respuesta">${respuesta.mensaje}</p>`;
        }
    })
}

function eventoAbrirModal(){
    document.getElementById('btn_notificaciones').addEventListener('click', ()=>{
        contenedorModal.classList.add('mostrar');
    })

    document.getElementById('btn_notificaciones_mobile').addEventListener('click', ()=>{
        contenedorModal.classList.add('mostrar');
    })
}

function eventoCerrarModal(){
    const botonCerrarModal = document.getElementById('cerrar_modal_notificacion');

    botonCerrarModal.addEventListener('click', ()=>{
        contenedorModal.classList.remove('mostrar');
    })

    contenedorModal.addEventListener('click', ()=>{
        botonCerrarModal.click();
    })
}

function eventoRegistrarNovedadUsuario(){
    const botonesNovedad = contenedorModal.querySelectorAll('.btn-novedad');

    botonesNovedad.forEach(boton => {
        let usuario = boton.getAttribute('data-usuario');
        boton.addEventListener('click', ()=>{
            modalRegistroNovedadUsuario(urlBase, 'SALIDA NO REGISTRADA', usuario, dibujarNotificaciones);
        })
    });
}

function eventoSolicitarPermisoPermanenciaUsuario(){
    const botonesPermiso = contenedorModal.querySelectorAll('.btn-permiso-usuario');

    botonesPermiso.forEach(boton => {
        let usuario = boton.getAttribute('data-usuario');
        let estadoPermiso = boton.getAttribute('data-estado-permiso');
        boton.addEventListener('click', ()=>{
            if(estadoPermiso != 'PENDIENTE' && estadoPermiso != 'DESAPROBADO'){
                modalRegistroPermisoUsuario(urlBase, 'PERMANENCIA', usuario, dibujarNotificaciones);

            }else if(estadoPermiso == 'PENDIENTE'){
                alertaError({
                    titulo: 'Permiso Pendiente',
                    mensaje: 'Lo sentimos, pero este usuario ya tiene una solictud de permanencia en estado pendiente.'
                })

            }else if(estadoPermiso == 'DESAPROBADO'){
                alertaError({
                    titulo: 'Permiso Desaprobado',
                    mensaje: 'Lo sentimos, pero la solicitud de permanencia de este usuario previamente solicitada, ha sido desaprobada.'
                })
            }
           
        })
    });
}

function eventoSolicitarPermisoPermanenciaVehiculo(){
    const botonesPermiso = contenedorModal.querySelectorAll('.btn-permiso-vehiculo');

    botonesPermiso.forEach(boton => {
        let vehiculo = boton.getAttribute('data-vehiculo');
        let estadoPermiso = boton.getAttribute('data-estado-permiso');
        boton.addEventListener('click', ()=>{
            if(estadoPermiso != 'PENDIENTE' && estadoPermiso != 'DESAPROBADO'){
                modalRegistroPermisoVehiculo(urlBase, 'PERMANENCIA', vehiculo, dibujarNotificaciones);

            }else if(estadoPermiso == 'PENDIENTE'){
                alertaError({
                    titulo: 'Permiso Pendiente',
                    mensaje: 'Lo sentimos, pero este vehículo ya tiene una solictud de permanencia en estado pendiente.'
                })

            }else if(estadoPermiso == 'DESAPROBADO'){
                alertaError({
                    titulo: 'Permiso Desaprobado',
                    mensaje: 'Lo sentimos, pero la solicitud de permanencia de este vehículo previamente solicitada, ha sido desaprobada.'
                })
            }
           
        })
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
    contenedorModal = document.getElementById('contenedor_notificaciones');
    cuerpoModal = document.getElementById('cuerpo_modal_notificaciones')
    contadorNotificaciones = document.getElementById('contador_notificaciones');
    contadorNotificacionesMobile = document.getElementById('contador_notificaciones_mobile');
     
    eventoAbrirModal();
    eventoCerrarModal();
    dibujarNotificaciones();

    setInterval(() => {
        dibujarNotificaciones();
    }, 60000);
})