import { consultarVigilantes, inhabilitarVigilante } from '../fetchs/vigilantes-fetch.js';
import { modalHabilitacionVigilante } from '../modales/modal-habilitacion-vigilante.js';
import { modalDetalleVigilante } from '../modales/modal-detalle-vigilante.js';
import { modalRegistroVigilante } from '../modales/modal-registro-vigilante.js';
import { modalActualizacionVigilante } from '../modales/modal-actualizacion-vigilante.js';

let urlBase;
let contenedorTabla;
let cuerpoTabla;

const parametros = {
    documento: '',
    ubicacion: '',
    rol: ''
};

function validarResolucion(){
    if(window.innerWidth >= 1024){
        dibujarTablaVigilantes();
    }else{
        dibujarCardsVigilantes();
    }
}

function dibujarTablaVigilantes(){
    if(!cuerpoTabla){
        contenedorTabla.innerHTML = `
            <table class="table" id="tabla_vigilantes">
                <thead class="head-table">
                    <tr>
                        <th>Tipo Doc.</th>
                        <th>Número Doc.</th>
                        <th>Nombres</th>
                        <th>Apellidos</th>
                        <th>Teléfono</th>
                        <th>Ubicación</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody class="body-table" id="cuerpo_tabla_vigilantes">
                </tbody>
            </table>`;

        cuerpoTabla = document.getElementById('cuerpo_tabla_vigilantes');
    }
   
    cuerpoTabla.innerHTML = '';
    consultarVigilantes(parametros, urlBase).then(respuesta=>{
        if(respuesta.tipo == 'OK'){
            respuesta.vigilantes.forEach(vigilante => {
                let acciones = `<ion-icon name="eye" class="ver-vigilante" data-vigilante="${vigilante.numero_documento}"></ion-icon>`

                if(vigilante.rol == 'VIGILANTE RASO'){
                    acciones += `<ion-icon name="create" class="editar-vigilante" data-vigilante="${vigilante.numero_documento}"></ion-icon>`;

                    if(vigilante.estado_usuario == 'ACTIVO'){
                        acciones += `<ion-icon name="lock-closed" class="inhabilitar-vigilante" data-vigilante="${vigilante.numero_documento}"></ion-icon>` 

                    }else if(vigilante.estado_usuario == 'INACTIVO'){
                        acciones += `<ion-icon name="lock-open" class="habilitar-vigilante" data-vigilante="${vigilante.numero_documento}"></ion-icon>`
                    }
                }

                cuerpoTabla.innerHTML += `
                    <tr>
                        <td>${vigilante.tipo_documento}</td>
                        <td>${vigilante.numero_documento}</td>
                        <td>${vigilante.nombres}</td>
                        <td>${vigilante.apellidos}</td>
                        <td>${vigilante.telefono}</td>
                        <td>${vigilante.ubicacion}</td>
                        <td class="contenedor-colum-acciones">
                            ${acciones}
                        </td>
                    </tr>`;
            });
            eventoVerVigilante();
            eventoEditarVigilante();
            eventoInhabilitarVigilante();
            eventoHabilitarVigilante();

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

function dibujarCardsVigilantes(){
    cuerpoTabla = '';
    consultarVigilantes(parametros, urlBase).then(respuesta=>{
        contenedorTabla.innerHTML = '';
        if(respuesta.tipo == 'OK'){
            respuesta.vigilantes.forEach(vigilante => {
                let acciones = `<ion-icon name="eye" class="ver-vigilante" data-vigilante="${vigilante.numero_documento}"></ion-icon>`

                if(vigilante.rol == 'VIGILANTE RASO'){
                    acciones += `<ion-icon name="create" class="editar-vigilante" data-vigilante="${vigilante.numero_documento}"></ion-icon>`;

                    if(vigilante.estado_usuario == 'ACTIVO'){
                    acciones += `<ion-icon name="lock-closed" class="inhabilitar-vigilante" data-vigilante="${vigilante.numero_documento}"></ion-icon>` 

                    }else if(vigilante.estado_usuario == 'INACTIVO'){
                        acciones += `<ion-icon name="lock-open" class="habilitar-vigilante" data-vigilante="${vigilante.numero_documento}"></ion-icon>`
                    }
                }

                contenedorTabla.innerHTML += `
                    <div class="document-card-vigilante">
                        <div class="card-header">
                            <div>
                                <p class="document-title">${vigilante.nombres} | ${vigilante.apellidos}</p>
                                <p class="document-meta">${vigilante.tipo_documento}: ${vigilante.numero_documento}</p>
                            </div>
                            <span class="toggle-icon"><ion-icon name="chevron-down-outline"></ion-icon></span> 
                        </div>
                        <div class="card-details">
                            <p><strong>Teléfono: </strong>${vigilante.telefono}</p>
                            <p><strong>Ubicación:</strong>${vigilante.ubicacion}</p>
                        </div>
                        <div class="contenedor-acciones">
                            ${acciones}
                        </div>
                    </div>`;
            });
            toggleCard();
            eventoVerVigilante();
            eventoEditarVigilante();
            eventoInhabilitarVigilante();
            eventoHabilitarVigilante();

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

function eventoVerVigilante(){
    const botonesVerVigilante = document.querySelectorAll('.ver-vigilante');
    
    botonesVerVigilante.forEach(boton => {
        let documento = boton.getAttribute('data-vigilante');
        boton.addEventListener('click', ()=>{
            modalDetalleVigilante(documento, urlBase);
        });
    });
}

function eventoEditarVigilante(){
    const botonesEditarVigilante = document.querySelectorAll('.editar-vigilante');

    botonesEditarVigilante.forEach(boton=>{
        let documento = boton.getAttribute('data-vigilante');
        boton.addEventListener('click', ()=>{
            modalActualizacionVigilante(documento, validarResolucion, urlBase);
        })
    })
}

function eventoHabilitarVigilante(){
    const botonesHabilitarVigilante = document.querySelectorAll('.habilitar-vigilante');

    botonesHabilitarVigilante.forEach(boton => {
        let documento = boton.getAttribute('data-vigilante');
        boton.addEventListener('click', ()=>{
           modalHabilitacionVigilante(documento, validarResolucion, urlBase);
        });
    })
}

function eventoInhabilitarVigilante(){
    const botonesInhabilitarVigilante = document.querySelectorAll('.inhabilitar-vigilante');

    botonesInhabilitarVigilante.forEach(boton => {
        let documento = boton.getAttribute('data-vigilante');
        boton.addEventListener('click', ()=>{
            alertaAdvertencia({
                titulo: 'Inhabilitar Usuario',
                mensaje: '¿Estas seguro que deseas inhabilitar a este usuario?',
                documento: documento
            });
        });
    })
}

function eventoRol(){
    let selectRol = document.getElementById('rol_filtro');

    selectRol.addEventListener('change', ()=>{
        parametros.rol = selectRol.value;
        validarResolucion();
    })
}

function eventoUbicacion(){
    let selectUbicacion = document.getElementById('ubicacion');

    selectUbicacion.addEventListener('change', ()=>{
        parametros.ubicacion = selectUbicacion.value;
        validarResolucion();
    })
}

function eventoBuscarDocumento(){
    let inputDocumento = document.getElementById('buscador_documento');
    let temporizador;
    
    inputDocumento.addEventListener('input', ()=>{
        clearTimeout(temporizador);
        temporizador = setTimeout(()=>{
            parametros.documento = inputDocumento.value;
            validarResolucion();
        }, 500)
    })
}

function eventoCrearVigilante(){
    const botonCrearVigilante = document.getElementById('btn_crear_vigilante');

    botonCrearVigilante.addEventListener('click', ()=>{
        modalRegistroVigilante(validarResolucion, urlBase);
    })

    document.getElementById('btn_crear_vigilante_mobile').addEventListener('click', ()=>{
        botonCrearVigilante.click();
    })
}

function toggleCard() {
    const cards = document.querySelectorAll('.document-card-vigilante');
    
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

function alertaExito(respuesta){
    Swal.fire({
        toast: true, 
        position: 'top-end', 
        icon: 'success',
        iconColor: "#2db910",
        color: '#F3F4F4',
        background: '#001629',
        timer: 5000,
        timerProgressBar: true,
        title: respuesta.mensaje,
        showConfirmButton: false,   
        customClass: {
            popup: 'alerta-contenedor',
        },
        didOpen: (toast) => {
            toast.addEventListener('click', () => {
                Swal.close();
            });
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

function alertaAdvertencia(respuesta){
    Swal.fire({
        icon: "warning",
        iconColor: "#feb211",
        title: respuesta.titulo,
        text: respuesta.mensaje,
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
            if(respuesta.titulo == "Inhabilitar Usuario"){
                inhabilitarVigilante(respuesta.documento, urlBase).then(datos=>{
                    if(datos.tipo == 'OK'){
                        alertaExito(datos);
                        validarResolucion();
                    }else if(datos.tipo == 'ERROR'){
                        alertaError(datos);
                    }
                });
                
            }
        } 
    });
}

document.addEventListener('DOMContentLoaded', ()=>{
    urlBase = document.getElementById('url_base').value;
    contenedorTabla = document.getElementById('contenedor_tabla_cards');
    
    eventoBuscarDocumento();
    eventoUbicacion();
    eventoRol();
    eventoCrearVigilante();
    validarResolucion();
    
    window.addEventListener('resize', ()=>{
        if(window.innerWidth >= 1024 && document.querySelector('.document-card-vigilante')){
            validarResolucion();

        }else if(window.innerWidth < 1024 && cuerpoTabla){
            validarResolucion();
        }
    });
})