import { consultarFuncionarios, inhabilitarFuncionario } from '../fetchs/funcionarios-fetch.js';
import { modalHabilitacionFuncionario } from '../modales/modal-habilitacion-funcionario.js';
import { modalDetalleFuncionario } from '../modales/modal-detalle-funcionario.js';
import { modalRegistroFuncionario } from '../modales/modal-registro-funcionario.js';
import { modalActualizacionFuncionario } from '../modales/modal-actualizacion-funcionario.js';

let urlBase;
let contenedorTabla;
let cuerpoTabla;

const parametros = {
    documento: '',
    brigadista: '',
    ubicacion: '',
    rol: ''
};

function validarResolucion(){
    if(window.innerWidth >= 1024){
        dibujarTablaFuncionarios();
    }else{
        dibujarCardsFuncionarios();
    }
}

function dibujarTablaFuncionarios(){
    if(!cuerpoTabla){
        contenedorTabla.innerHTML = `
            <table class="table" id="tabla_funcionarios">
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
                <tbody class="body-table" id="cuerpo_tabla_funcionarios">
                </tbody>
            </table>`;

        cuerpoTabla = document.getElementById('cuerpo_tabla_funcionarios');
    }
   
    consultarFuncionarios(parametros, urlBase).then(respuesta=>{
        if(respuesta.tipo == 'OK'){
            cuerpoTabla.innerHTML = '';
            respuesta.funcionarios.forEach(funcionario => {
                let acciones = `<ion-icon name="eye" class="ver-funcionario" data-funcionario="${funcionario.numero_documento}"></ion-icon>`

                if(funcionario.rol != 'SUBDIRECTOR'){
                    acciones += `<ion-icon name="create" class="editar-funcionario" data-funcionario="${funcionario.numero_documento}"></ion-icon>`;

                    if(funcionario.rol == 'COORDINADOR' || funcionario.rol == 'INSTRUCTOR'){
                        if(funcionario.estado_usuario == 'ACTIVO'){
                        acciones += `<ion-icon name="lock-closed" class="inhabilitar-funcionario" data-funcionario="${funcionario.numero_documento}"></ion-icon>` 

                        }else if(funcionario.estado_usuario == 'INACTIVO'){
                            acciones += `<ion-icon name="lock-open" class="habilitar-funcionario" data-funcionario="${funcionario.numero_documento}"></ion-icon>`
                        }
                    }
                }

                cuerpoTabla.innerHTML += `
                    <tr>
                        <td>${funcionario.tipo_documento}</td>
                        <td>${funcionario.numero_documento}</td>
                        <td>${funcionario.nombres}</td>
                        <td>${funcionario.apellidos}</td>
                        <td>${formatearNumeroTelefono(funcionario.telefono)}</td>
                        <td>${funcionario.ubicacion}</td>
                        <td class="contenedor-colum-acciones">
                            ${acciones}
                        </td>
                    </tr>`;
            });
            eventoVerFuncionario();
            eventoEditarFuncionario();
            eventoInhabilitarFuncionario();
            eventoHabilitarFuncionario();

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

function dibujarCardsFuncionarios(){
    cuerpoTabla = '';
    consultarFuncionarios(parametros, urlBase).then(respuesta=>{
        contenedorTabla.innerHTML = '';
        if(respuesta.tipo == 'OK'){
            respuesta.funcionarios.forEach(funcionario => {
                let acciones = `<ion-icon name="eye" class="ver-funcionario" data-funcionario="${funcionario.numero_documento}"></ion-icon>`

                if(funcionario.rol != 'SUBDIRECTOR'){
                    acciones += `<ion-icon name="create" class="editar-funcionario" data-funcionario="${funcionario.numero_documento}"></ion-icon>`;

                    if(funcionario.rol == 'COORDINADOR' || funcionario.rol == 'INSTRUCTOR'){
                        if(funcionario.estado_usuario == 'ACTIVO'){
                        acciones += `<ion-icon name="lock-closed" class="inhabilitar-funcionario" data-funcionario="${funcionario.numero_documento}"></ion-icon>` 

                        }else if(funcionario.estado_usuario == 'INACTIVO'){
                            acciones += `<ion-icon name="lock-open" class="habilitar-funcionario" data-funcionario="${funcionario.numero_documento}"></ion-icon>`
                        }
                    }
                }

                contenedorTabla.innerHTML += `
                    <div class="document-card-funcionario">
                        <div class="card-header">
                            <div>
                                <p class="document-title">${funcionario.nombres} ${funcionario.apellidos}</p>
                                <p class="document-meta">${funcionario.tipo_documento}: ${funcionario.numero_documento}</p>
                            </div>
                            <span class="toggle-icon"><ion-icon name="chevron-down-outline"></ion-icon></span> 
                        </div>
                        <div class="card-details">
                            <p><strong>Teléfono: </strong>${formatearNumeroTelefono(funcionario.telefono)}</p>
                            <p><strong>Ubicación: </strong>${funcionario.ubicacion}</p>
                        </div>
                        <div class="contenedor-acciones">
                            ${acciones}
                        </div>
                    </div>`;
            });
            toggleCard();
            eventoVerFuncionario();
            eventoEditarFuncionario();
            eventoInhabilitarFuncionario();
            eventoHabilitarFuncionario();

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

function eventoVerFuncionario(){
    const botonesVerFuncionario = document.querySelectorAll('.ver-funcionario');
    
    botonesVerFuncionario.forEach(boton => {
        let documento = boton.getAttribute('data-funcionario');
        boton.addEventListener('click', ()=>{
            modalDetalleFuncionario(documento, urlBase);
        });
    });
}

function eventoEditarFuncionario(){
    const botonesEditarFuncionario = document.querySelectorAll('.editar-funcionario');

    botonesEditarFuncionario.forEach(boton=>{
        let documento = boton.getAttribute('data-funcionario');
        boton.addEventListener('click', ()=>{
            modalActualizacionFuncionario(documento, validarResolucion, urlBase);
        })
    })
}

function eventoHabilitarFuncionario(){
    const botonesHabilitarFuncionario = document.querySelectorAll('.habilitar-funcionario');

    botonesHabilitarFuncionario.forEach(boton => {
        let documento = boton.getAttribute('data-funcionario');
        boton.addEventListener('click', ()=>{
           modalHabilitacionFuncionario(documento, validarResolucion, urlBase);
        });
    })
}

function eventoInhabilitarFuncionario(){
    const botonesInhabilitarFuncionario = document.querySelectorAll('.inhabilitar-funcionario');

    botonesInhabilitarFuncionario.forEach(boton => {
        let documento = boton.getAttribute('data-funcionario');
        boton.addEventListener('click', ()=>{
            alertaAdvertencia({
                titulo: 'Inhabilitar Usuario',
                mensaje: '¿Estás seguro que deseas inhabilitar a este usuario?',
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
    
    inputDocumento.addEventListener('input', ()=>{
        if(inputDocumento.value.length == 0 || inputDocumento.value.length > 5){
            parametros.documento = inputDocumento.value;
            validarResolucion();
        }
    })
}

function eventoCrearFuncionario(){
    const botonCrearFuncionario = document.getElementById('btn_crear_funcionario');

    botonCrearFuncionario.addEventListener('click', ()=>{
        modalRegistroFuncionario(validarResolucion, urlBase);
    })

    document.getElementById('btn_crear_funcionario_mobile').addEventListener('click', ()=>{
        botonCrearFuncionario.click();
    })
}

function toggleCard() {
    const cards = document.querySelectorAll('.document-card-funcionario');
    
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

function formatearNumeroTelefono(numeroTelefono){
    let telefonoFormateado = '';

    for (let i = 0; i < numeroTelefono.length; i++) {
        telefonoFormateado += numeroTelefono[i];
        if(i == 2 || i == 5 || i == 7 ){
            telefonoFormateado += '-';
        }
    }

    return telefonoFormateado;
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
                inhabilitarFuncionario(respuesta.documento, urlBase).then(datos=>{
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
    eventoCrearFuncionario();
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