import { aprobarPermisoUsuario, consultarPermisosUsuarios, desaprobarPermisoUsuario} from '../fetchs/permisos-usuarios-fetch.js';
import { dibujarNotificaciones } from '../general/notificaciones-subdirector.js';
import { modalDetallePermisoUsuario } from '../modales/modal-detalle-permiso-usuario.js';

let urlBase;
let codigoPermiso;
let contenedorTabla;
let cuerpoTabla;

const parametros = {
    codigo_permiso: '',
    tipo_permiso: '',
    estado: '',
    fecha: '',
    documento: ''
};

function validarResolucion(){
    if(window.innerWidth >= 1024){
        dibujarTablaPermisos();
    }else{
        dibujarCardsPermisos();
    }
}

function dibujarTablaPermisos(){
    if(!cuerpoTabla){
        contenedorTabla.innerHTML = `
            <table class="table" id="tabla_permisos_usuario">
                <thead class="head-table">
                    <tr>
                        <th>Fecha y Hora</th>
                        <th>Tipo Permiso</th>
                        <th>Tipo Doc.</th>
                        <th>Número Doc.</th>
                        <th>Nombres</th>
                        <th>Apellidos</th>
                        <th>Estado Permiso</th>
                        <th>Usuario Sistema</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody class="body-table" id="cuerpo_tabla_permisos_usuario">
                </tbody>
            </table>`;

        cuerpoTabla = document.getElementById('cuerpo_tabla_permisos_usuario');
    }
   
    consultarPermisosUsuarios(parametros, urlBase).then(respuesta=>{
        if(respuesta.tipo == 'OK'){
            cuerpoTabla.innerHTML = '';
            respuesta.permisos_usuarios.forEach(permiso => { 
                let acciones = `<ion-icon name="eye" class="ver-permiso" data-permiso="${permiso.codigo_permiso}"></ion-icon>`;
                if(permiso.tipo_permiso == 'PERMANENCIA' && permiso.estado_permiso == 'PENDIENTE'){
                    acciones += `
                        <ion-icon name="checkmark-circle" class="aprobar-permiso" data-permiso="${permiso.codigo_permiso}"></ion-icon>
                        <ion-icon name="close-circle" class="desaprobar-permiso" data-permiso="${permiso.codigo_permiso}"></ion-icon>`;
                }

                cuerpoTabla.innerHTML += `
                    <tr>
                        <td>${permiso.fecha_registro}</td>
                        <td>${permiso.tipo_permiso}</td>
                        <td>${permiso.tipo_documento}</td>
                        <td>${permiso.fk_usuario}</td>
                        <td>${permiso.nombres}</td>
                        <td>${permiso.apellidos}</td>
                         <td>${permiso.estado_permiso}</td>
                        <td>${permiso.fk_usuario_sistema}</td>
                        <td class="contenedor-colum-acciones">
                            ${acciones}
                        </td>
                    </tr>`;
            });

            eventoVerPermiso();
            eventoAprobarPermiso();
            eventoDesaprobarPermiso();

        }else if(respuesta.tipo == 'ERROR'){
            if(respuesta.titulo == 'Sesión Expirada'){
                    window.location.replace(urlBase+'sesion-expirada');
            }else{
                cuerpoTabla.innerHTML = `
                    <tr>
                        <td colspan="9">${respuesta.mensaje}</td>
                    </tr>`;
                    
                if(respuesta.titulo != 'Datos No Encontrados'){
                    alertaError(respuesta);
                }
            }
        }
    })
}

function dibujarCardsPermisos(){
    cuerpoTabla = '';
    consultarPermisosUsuarios(parametros, urlBase).then(respuesta=>{
        contenedorTabla.innerHTML = '';
        if(respuesta.tipo == 'OK'){
            respuesta.permisos_usuarios.forEach(permiso => {
                let acciones = `<ion-icon name="eye" class="ver-permiso" data-permiso="${permiso.codigo_permiso}"></ion-icon>`;
                if(permiso.estado_permiso == 'PENDIENTE'){
                    acciones += `
                        <ion-icon name="checkmark-circle" class="aprobar-permiso" data-permiso="${permiso.codigo_permiso}"></ion-icon>
                        <ion-icon name="close-circle" class="desaprobar-permiso" data-permiso="${permiso.codigo_permiso}"></ion-icon>`;
                }

                contenedorTabla.innerHTML += `
                    <div class="document-card-permiso-usuario">
                        <div class="card-header">
                            <div>
                                <p class="document-title">${permiso.nombres} ${permiso.apellidos}</p>
                                <p class="document-meta">${permiso.tipo_documento}: ${permiso.fk_usuario} | ${permiso.tipo_permiso}</p>
                            </div>
                            <span class="toggle-icon"><ion-icon name="chevron-down-outline"></ion-icon></span> 
                        </div>
                        <div class="card-details">
                            <p><strong>Fecha y Hora: </strong>${permiso.fecha_registro}</p>
                            <p><strong>Estado: </strong>${permiso.estado_permiso}</p>
                            <p><strong>${formatearString(permiso.rol_usuario_sistema)}: </strong>${permiso.fk_usuario_sistema}</p>
                        </div>
                        <div class="contenedor-acciones">
                            ${acciones}
                        </div>
                    </div>`;
            });
            toggleCard();
            eventoVerPermiso();
            eventoAprobarPermiso();
            eventoDesaprobarPermiso();

        }else if(respuesta.tipo == 'ERROR'){
            if(respuesta.titulo == 'Sesión Expirada'){
                window.location.replace(urlBase+'sesion-expirada');

            }else{
                contenedorTabla.innerHTML = `<p id="mensaje_respuesta">${respuesta.mensaje}</p>`;
                
                if(respuesta.titulo != 'Datos No Encontrados'){
                    alertaError(respuesta);
                }
            }
        }
    })
}

function eventoVerPermiso(){
    const botonesVerPermiso = document.querySelectorAll('.ver-permiso');
    
    botonesVerPermiso.forEach(boton => {
        let permiso = boton.getAttribute('data-permiso');
        boton.addEventListener('click', ()=>{
            modalDetallePermisoUsuario(permiso, urlBase);
        });
    });
}

function eventoAprobarPermiso(){
    const botonesAprobarPermiso = document.querySelectorAll('.aprobar-permiso');
    
    botonesAprobarPermiso.forEach(boton => {
        let permiso = boton.getAttribute('data-permiso');
        boton.addEventListener('click', ()=>{
            alertaAdvertencia({
                titulo: 'Aprobar Permiso',
                mensaje: '¿Estas seguro que deseas aprobar este permiso?',
                codigo_permiso: permiso
            });
        });
    });
}

function eventoDesaprobarPermiso(){
    const botonesDesaprobarPermiso = document.querySelectorAll('.desaprobar-permiso');
    
    botonesDesaprobarPermiso.forEach(boton => {
        let permiso = boton.getAttribute('data-permiso');
        boton.addEventListener('click', ()=>{
            alertaAdvertencia({
                titulo: 'Desaprobar Permiso',
                mensaje: '¿Estas seguro que deseas desaprobar este permiso?',
                codigo_permiso: permiso
            });
        });
    });
}

function eventoEstadoPermiso(){
    const selectEstado = document.getElementById('estado_permiso_filtro');

    selectEstado.addEventListener('change', ()=>{
        parametros.estado = selectEstado.value;
        validarResolucion();
    })
}

function eventoFecha(){
    const inputFecha = document.getElementById('fecha');

    inputFecha.addEventListener('change', ()=>{
        parametros.fecha = inputFecha.value;
        validarResolucion();
    })
}

function eventoBuscarDocumento(){
    const inputDocumento = document.getElementById('buscador_documento');
    
    inputDocumento.addEventListener('input', ()=>{
        if(inputDocumento.value.length == 0 || inputDocumento.value.length > 5)
            parametros.documento = inputDocumento.value;
            validarResolucion();
       
    })
}

function toggleCard() {
    const cards = document.querySelectorAll('.document-card-permiso-usuario');
    
    cards.forEach(card => {
        card.addEventListener('click', function() {
            if(card.classList.contains('active')){
                card.classList.remove('active');
            }else{
                document.querySelector('.active')?.classList.remove('active');
                card.classList.toggle('active');
            }
        });
    });
}

function formatearString(cadena) { 
    cadena = cadena.toLowerCase();
    cadena = cadena.charAt(0).toUpperCase() + cadena.slice(1);
    return cadena; 
}

function alertaExito(respuesta){
    Swal.fire({
        toast: true, 
        position: 'bottom-end', 
        icon: 'success',
        iconColor: "#2db910",
        color: '#F3F4F4',
        background: '#001629',
        timer: 5000,
        timerProgressBar: true,
        title: respuesta.mensaje,
        showConfirmButton: false,   
        customClass: {
            popup: 'alerta-contenedor exito',
        },
        didOpen: (toast) => {
            toast.addEventListener('click', () => {
                Swal.close();
            });
        }
    })
}

function alertaAdvertencia(datos){
    Swal.fire({
        icon: "warning",
        iconColor: "#feb211",
        title: datos.titulo,
        text: datos.mensaje,
        showCancelButton: true,
        confirmButtonText: 'Aceptar',
        cancelButtonText: 'Cancelar',
        customClass: {
            popup: 'alerta-contenedor',
            confirmButton: 'btn-confirmar',
            cancelButton: 'btn-cancelar' 
        }
    }).then((result) => {
        if (result.isConfirmed) {
            if(datos.titulo == "Aprobar Permiso"){
                aprobarPermisoUsuario(datos.codigo_permiso, urlBase).then(respuesta=>{
                    if(respuesta.tipo == 'OK'){
                        alertaExito(respuesta);
                        dibujarNotificaciones();
                        validarResolucion();

                    }else if(respuesta.tipo == 'ERROR'){
                        if(respuesta.titulo == 'Sesión Expirada'){
                            window.location.replace(urlBase+'sesion-expirada');
                        }else{
                            alertaError(respuesta);
                        }
                    }
                });   
            }else if(datos.titulo == 'Desaprobar Permiso'){
                desaprobarPermisoUsuario(datos.codigo_permiso, urlBase).then(respuesta=>{
                    if(respuesta.tipo == 'OK'){
                        alertaExito(respuesta);
                        dibujarNotificaciones();
                        validarResolucion();

                    }else if(respuesta.tipo == 'ERROR'){
                        if(respuesta.titulo == 'Sesión Expirada'){
                            window.location.replace(urlBase+'sesion-expirada');
                        }else{
                            alertaError(respuesta);
                        }
                    }
                }); 
            }
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
    contenedorTabla = document.getElementById('contenedor_tabla_cards');
    codigoPermiso = document.getElementById('codigo_permiso');

    if(codigoPermiso){
        parametros.codigo_permiso = codigoPermiso.value;
        modalDetallePermisoUsuario(codigoPermiso.value, urlBase);
    }

    const selectTipoPermiso = document.getElementById('tipo_permiso_filtro');
    parametros.tipo_permiso = selectTipoPermiso.value;

    eventoBuscarDocumento();
    eventoFecha();
    eventoEstadoPermiso();
    validarResolucion();

    window.addEventListener('resize', ()=>{
        setTimeout(()=>{
            if(window.innerWidth >= 1024 && !cuerpoTabla){
                validarResolucion();

            }else if(window.innerWidth < 1024 && cuerpoTabla){
                validarResolucion();
            }
        }, 250)
    });
})