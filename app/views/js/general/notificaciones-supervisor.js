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
                            let acciones;

                            if(notificacion.estado_permiso == 'PENDIENTE' || notificacion.estadoPermiso == 'DESAPROBADO'){
                                acciones = `
                                    <button class="btn-ver-permiso-usuario" data-permiso="${notificacion.codigo_permiso}">Ver solicitud permiso</button>
                                    <button class="btn-novedad" data-usuario="${notificacion.numero_documento}">Registrar novedad</button>`;

                            }else{
                                acciones = `
                                    <button class="btn-permiso-usuario" data-usuario="${notificacion.numero_documento}">Solicitar permiso</button>
                                    <button class="btn-novedad" data-usuario="${notificacion.numero_documento}">Registrar novedad</button>`;
                            }

                            cuerpoModal.innerHTML += `
                                <div class="contenedor-alerta">
                                    <div class="contenedor-mensaje-alerta">
                                        <h3>Permanencia Usuario</h3>
                                        <p>El ${formatearString(notificacion.tipo_usuario)} con número de documento <strong>${notificacion.numero_documento}</strong> lleva ${notificacion.horas_permanencia} horas dentro del CAB</p>
                                        <div id="contenedor_btns_notificacion">
                                            ${acciones}
                                        </div>
                                    </div>
                                </div>`
                        });

                        notificacionesVehiculo.forEach(notificacion => {
                            let acciones;

                            if(notificacion.estado_permiso == 'PENDIENTE' || notificacion.estado_permiso == 'DESAPROBADO'){
                                acciones = `<button class="btn-ver-permiso-vehiculo" data-permiso="${notificacion.codigo_permiso}">Ver solicitud permiso</button>`;

                            }else{
                                acciones = `<button class="btn-permiso-vehiculo" data-vehiculo="${notificacion.numero_placa}">Solicitar permiso</button>`;
                            }

                            cuerpoModal.innerHTML += `
                                <div class="contenedor-alerta">
                                    <div class="contenedor-mensaje-alerta">
                                        <h3>Permanencia Vehículo</h3>
                                        <p>El vehículo con número de placa <strong>${notificacion.numero_placa}</strong> lleva ${notificacion.horas_permanencia} horas dentro del CAB</p>
                                       <div id="contenedor_btns_notificacion">
                                            ${acciones}
                                        </div>
                                    </div>
                                </div>`
                        });

                        eventoRegistrarNovedadUsuario();
                        eventoSolicitarPermisoPermanenciaUsuario();
                        eventoSolicitarPermisoPermanenciaVehiculo();
                        eventoVerPermisoUsuario();
                        eventoVerPermisoVehiculo();

                    }else if(notificacionesUsuario.length < 1 && notificacionesVehiculo.length < 1){
                        cuerpoModal.innerHTML = `<p id="mensaje_respuesta">No hay notificaciones actualmente.</p>`;
                    }

                }else if(respuesta.tipo == 'ERROR'){
                    if(respuesta.titulo == 'Sesión Expirada'){
                        window.location.replace(urlBase+'sesion-expirada');
                    }else{
                        cuerpoModal.innerHTML = `<p id="mensaje_respuesta">${respuesta.mensaje}</p>`;
                    }
                }
            })
            
        }else if(respuesta.tipo == 'ERROR'){
            if(respuesta.titulo == 'Sesión Expirada'){
                window.location.replace(urlBase+'sesion-expirada');
            }else{
                cuerpoModal.innerHTML = `<p id="mensaje_respuesta">${respuesta.mensaje}</p>`;
            }
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
    document.getElementById('cerrar_modal_notificacion').addEventListener('click', ()=>{
        contenedorModal.classList.remove('mostrar');
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
        boton.addEventListener('click', ()=>{
            modalRegistroPermisoUsuario(urlBase, 'PERMANENCIA', usuario, dibujarNotificaciones);
        })
    });
}

function eventoSolicitarPermisoPermanenciaVehiculo(){
    const botonesPermiso = contenedorModal.querySelectorAll('.btn-permiso-vehiculo');

    botonesPermiso.forEach(boton => {
        let vehiculo = boton.getAttribute('data-vehiculo');
        boton.addEventListener('click', ()=>{
            modalRegistroPermisoVehiculo(urlBase, 'PERMANENCIA', vehiculo, dibujarNotificaciones);
        })
    });
}

function eventoVerPermisoUsuario(){
    const botonesVerPermisoUsuario = contenedorModal.querySelectorAll('.btn-ver-permiso-usuario');

    botonesVerPermisoUsuario.forEach(boton => {
        let permiso = boton.getAttribute('data-permiso');
        boton.addEventListener('click', ()=>{
            window.location.replace(urlBase+`permisos-usuario/${permiso}`);
        })
    });
}

function eventoVerPermisoVehiculo(){
    const botonesVerPermisoVehiculo = contenedorModal.querySelectorAll('.btn-ver-permiso-vehiculo');

    botonesVerPermisoVehiculo.forEach(boton => {
        let permiso = boton.getAttribute('data-permiso');
        boton.addEventListener('click', ()=>{
            window.location.replace(urlBase+`permisos-vehiculo/${permiso}`);
        })
    });
}

function formatearString(cadena) { 
    cadena = cadena.toLowerCase();
    cadena = cadena.charAt(0).toUpperCase() + cadena.slice(1);
    return cadena; 
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