import { consultarPermisosUsuarios} from '../fetchs/permisos-usuarios-fetch.js';
import { modalDetallePermisoUsuario } from '../modales/modal-detalle-permiso-usuario.js';
import { modalRegistroPermisoUsuario } from '../modales/modal-registro-permiso-usuario.js';

let urlBase;
let contenedorTabla;
let cuerpoTabla;
let codigoPermiso;

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
                           <ion-icon name="eye" class="ver-permiso" data-permiso="${permiso.codigo_permiso}"></ion-icon>
                        </td>
                    </tr>`;
            });

            eventoVerPermiso();

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
                            <ion-icon name="eye" class="ver-permiso" data-permiso="${permiso.codigo_permiso}"></ion-icon>
                        </div>
                    </div>`;
            });
            toggleCard();
            eventoVerPermiso();

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

function eventoTipoPermiso(){
    const selectTipoPermiso = document.getElementById('tipo_permiso_filtro');

    selectTipoPermiso.addEventListener('change', ()=>{
        parametros.tipo_permiso = selectTipoPermiso.value;
        validarResolucion();
    })
}

function eventoBuscarDocumento(){
    const inputDocumento = document.getElementById('buscador_documento');
    
    inputDocumento.addEventListener('input', ()=>{
        if(inputDocumento.value.length == 0 || inputDocumento.value.length > 5){
            parametros.documento = inputDocumento.value;
            validarResolucion();
        }
       
    })
}

function eventoCrearPermisoUsuario(){
    const botonCrearPermiso = document.getElementById('btn_crear_permiso_usuario');

    botonCrearPermiso.addEventListener('click', ()=>{
        modalRegistroPermisoUsuario(urlBase, '', '', validarResolucion);
    })

    document.getElementById('btn_crear_permiso_usuario_mobile').addEventListener('click', ()=>{
        botonCrearPermiso.click();
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

    eventoBuscarDocumento();
    eventoTipoPermiso();
    eventoFecha();
    eventoEstadoPermiso();
    eventoCrearPermisoUsuario();
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