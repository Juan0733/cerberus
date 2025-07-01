import { consultarPermisosVehiculos} from '../fetchs/permisos-vehiculos-fetch.js';
import { modalDetallePermisoVehiculo } from '../modales/modal-detalle-permiso-vehiculo.js';

let urlBase;
let codigoPermiso;
let contenedorTabla;
let cuerpoTabla;
let inputFecha;
let selectTipoPermiso;

const parametros = {
    codigo_permiso: '',
    tipo_permiso: '',
    estado: '',
    fecha: '',
    placa: ''
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
            <table class="table" id="tabla_permisos_vehiculo">
                <thead class="head-table">
                    <tr>
                        <th>Fecha y Hora</th>
                        <th>Tipo Permiso</th>
                        <th>Tipo Vehículo</th>
                        <th>Placa Vehículo</th>
                        <th>Tipo Doc.</th>
                        <th>Número Doc.</th>
                        <th>Nombres</th>
                        <th>Apellidos</th>
                        <th>Estado Permiso</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody class="body-table" id="cuerpo_tabla_permisos_vehiculo">
                </tbody>
            </table>`;

        cuerpoTabla = document.getElementById('cuerpo_tabla_permisos_vehiculo');
    }
   
    cuerpoTabla.innerHTML = '';
    consultarPermisosVehiculos(parametros, urlBase).then(respuesta=>{
        if(respuesta.tipo == 'OK'){
            respuesta.permisos_vehiculos.forEach(permiso => { 

                cuerpoTabla.innerHTML += `
                    <tr>
                        <td>${permiso.fecha_registro}</td>
                        <td>${permiso.tipo_permiso}</td>
                        <td>${permiso.tipo_vehiculo}</td>
                        <td>${permiso.fk_vehiculo}</td>
                        <td>${permiso.tipo_documento}</td>
                        <td>${permiso.fk_usuario}</td>
                        <td>${permiso.nombres}</td>
                        <td>${permiso.apellidos}</td>
                         <td>${permiso.estado_permiso}</td>
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
                        <td colspan="10">${respuesta.mensaje}</td>
                    </tr>`;
            }
        }
    })
}

function dibujarCardsPermisos(){
    consultarPermisosVehiculos(parametros, urlBase).then(respuesta=>{
        contenedorTabla.innerHTML = '';
        if(respuesta.tipo == 'OK'){
            respuesta.permisos_vehiculos.forEach(permiso => {
                
                contenedorTabla.innerHTML += `
                    <div class="document-card-permiso-vehiculo">
                        <div class="card-header">
                            <div>
                                <p class="document-title">${permiso.tipo_vehiculo} ${permiso.fk_vehiculo}</p>
                                <p class="document-meta">${permiso.tipo_documento}: ${permiso.fk_usuario} | ${permiso.tipo_permiso}</p>
                            </div>
                            <span class="toggle-icon"><ion-icon name="chevron-down-outline"></ion-icon></span> 
                        </div>
                        <div class="card-details">
                            <p><strong>Fecha y Hora: </strong>${permiso.fecha_registro}</p>
                            <p><strong>Nombres: </strong>${permiso.nombres}</p>
                            <p><strong>Apellidos: </strong>${permiso.apellidos}</p>
                            <p><strong>Estado: </strong>${permiso.estado_permiso}</p>
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
            }
        }
    })
}

function eventoVerPermiso(){
    const botonesVerPermiso = document.querySelectorAll('.ver-permiso');
    
    botonesVerPermiso.forEach(boton => {
        let permiso = boton.getAttribute('data-permiso');
        boton.addEventListener('click', ()=>{
            modalDetallePermisoVehiculo(permiso, urlBase);
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
    fecha.addEventListener('change', ()=>{
        parametros.fecha = inputFecha.value;
        validarResolucion();
    })
}

function eventoTipoPermiso(){
    selectTipoPermiso.addEventListener('change', ()=>{
        parametros.tipo_permiso = selectTipoPermiso.value;
        validarResolucion();
    })
}

function eventoBuscarPlaca(){
    const inputPlaca = document.getElementById('buscador_placa');
    let temporizador;
    
    inputPlaca.addEventListener('input', ()=>{
        clearTimeout(temporizador);
        temporizador = setTimeout(()=>{
            parametros.placa = inputPlaca.value;
            validarResolucion();
        }, 500)
    })
}

function eventoCrearPermisoVehiculo(){
    const botonCrearPermiso = document.getElementById('btn_crear_vehiculo_permiso');

    botonCrearPermiso.addEventListener('click', ()=>{
        modalRegistroPermisoVehiculo(urlBase, '', '', validarResolucion);
    })

    document.getElementById('btn_crear_permiso_vehiculo_mobile').addEventListener('click', ()=>{
        botonCrearAgenda.click();
    })
}

function toggleCard() {
    const cards = document.querySelectorAll('.document-card-permiso-vehiculo');
    
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

document.addEventListener('DOMContentLoaded', ()=>{
    urlBase = document.getElementById('url_base').value;
    contenedorTabla = document.getElementById('contenedor_tabla_cards');
    inputFecha = document.getElementById('fecha');
    selectTipoPermiso = document.getElementById('tipo_permiso_filtro');
    codigoPermiso = document.getElementById('codigo_permiso');
    parametros.fecha = inputFecha.value;
    parametros.tipo_permiso = selectTipoPermiso.value;

    if(codigoPermiso){
        parametros.codigo_permiso = codigoPermiso.value;
        modalDetallePermisoVehiculo(codigoPermiso.value, urlBase);
    }

    eventoBuscarPlaca();
    eventoTipoPermiso();
    eventoFecha();
    eventoEstadoPermiso();
    eventoCrearPermisoVehiculo();
    validarResolucion();
})