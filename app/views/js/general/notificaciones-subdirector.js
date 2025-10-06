import { consultarNotificacionesPermisosUsuario } from "../fetchs/permisos-usuarios-fetch.js";
import { consultarNotificacionesPermisosVehiculo } from "../fetchs/permisos-vehiculos-fetch.js";

let urlBase;
let contenedorModal;
let cuerpoModal;
let contadorNotificaciones;
let contadorNotificacionesMobile;

function dibujarNotificaciones(){
    consultarNotificacionesPermisosUsuario(urlBase).then(respuesta=>{
        if(respuesta.tipo == 'OK'){
            const notificacionesPermisosUsuario = respuesta.notificaciones_permisos_usuario;
            consultarNotificacionesPermisosVehiculo(urlBase).then(respuesta=>{
                if(respuesta.tipo == 'OK'){
                    const notificacionesPermisosVehiculo = respuesta.notificaciones_permisos_vehiculo;
                    contadorNotificaciones.textContent = notificacionesPermisosUsuario.length + notificacionesPermisosVehiculo.length;
                    contadorNotificacionesMobile.textContent = notificacionesPermisosUsuario.length + notificacionesPermisosVehiculo.length;

                    if(notificacionesPermisosUsuario.length > 0 || notificacionesPermisosVehiculo.length > 0){
                        cuerpoModal.innerHTML = '';

                        notificacionesPermisosUsuario.forEach(notificacion => {
                            cuerpoModal.innerHTML += `
                                <div class="contenedor-alerta">
                                    <div class="contenedor-mensaje-alerta">
                                        <h3>Solicitud Permiso Usuario</h3>
                                        <p>Se ha solicitado un permiso de tipo ${formatearString(notificacion.tipo_permiso)}, para el usuario con número de documento <strong>${notificacion.fk_usuario}</strong></p>
                                        <div id="contenedor_btns_notificacion">
                                            <button class="btn-ver-permiso-usuario" data-permiso="${notificacion.codigo_permiso}">Ver detalle</button>
                                        </div>
                                    </div>
                                </div>`
                        });

                        notificacionesPermisosVehiculo.forEach(notificacion => {
                            cuerpoModal.innerHTML += `
                                <div class="contenedor-alerta">
                                    <div class="contenedor-mensaje-alerta">
                                        <h3>Solicitud Permiso Vehículo</h3>
                                        <p>Se ha solicitado un permiso de tipo ${formatearString(notificacion.tipo_permiso)}, para el vehículo con número de placa <strong>${notificacion.fk_vehiculo}</strong></p>
                                        <div id="contenedor_btns_notificacion">
                                            <button class="btn-ver-permiso-vehiculo" data-permiso="${notificacion.codigo_permiso}" >Ver detalle</button>
                                        </div>
                                    </div>
                                </div>`
                        });

                        eventoVerPermisoUsuario();
                        eventoVerPermisoVehiculo();

                    }else if(notificacionesPermisosUsuario.length < 1 && notificacionesPermisosVehiculo.length < 1){
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
export{dibujarNotificaciones}

function formatearString(cadena) { 
    cadena = cadena.toLowerCase();
    cadena = cadena.charAt(0).toUpperCase() + cadena.slice(1);
    return cadena; 
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