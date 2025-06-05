import {consultarPropietarios, eliminarPropietarioVehiculo} from '../fetchs/vehiculos-fetch.js';

let contenedorModales;
let contenedorTabla;
let numeroPlaca;
let modalesExistentes;
let cuerpoTabla;
let urlBase;

function validarResolucion(){
    if(window.innerWidth > 1024){
        dibujarTablaPropietarios();
    }else{
        dibujarCardsPropietarios();
    }
}

async function modalPropietariosVehiculo(placa, url) {
    try {
        const response = await fetch(url+'app/views/inc/modales/modal-propietarios-vehiculo.php');

        if(!response.ok) throw new Error('Hubo un error en la solicitud');

        const contenidoModal = await response.text();
        const modal = document.createElement('div');
            
        modal.classList.add('contenedor-ppal-modal');
        modal.innerHTML = contenidoModal;
        contenedorModales = document.getElementById('contenedor-modales');
        contenedorModales.appendChild(modal);
        document.getElementById('titulo_modal').textContent = 'Propietarios Vehículo '+placa.toUpperCase();
        modalesExistentes = contenedorModales.getElementsByClassName('contenedor-ppal-modal');
        urlBase = url;
        contenedorTabla = document.getElementById('contenedor_tabla_propietarios');
        cuerpoTabla = '';
        numeroPlaca = placa;
         
        validarResolucion();
        eventoCerrarModal();

           
    } catch (error) {
        let respuesta = {
            titulo: 'Error Modal',
            mensaje: 'Error al cargar modal propietarios.'
        }
        
        alertaError(respuesta);
    }
    
}
export { modalPropietariosVehiculo };

function eventoCerrarModal(){
    document.getElementById('cerrar_modal_propietarios').addEventListener('click', ()=>{
        modalesExistentes[modalesExistentes.length-1].remove();
        contenedorModales.classList.remove('mostrar');
    });
}

function dibujarTablaPropietarios(){
    if(!cuerpoTabla){
        contenedorTabla.innerHTML = `
            <table class="table" id="tabla_propietarios">
                <thead class="head-table">
                    <tr>
                        <th>No. Documento</th>
                        <th>Nombre y Apellidos</th>
                        <th>Telefono</th>
                        <th>Correo Electrónico</th>
                        <th>Ubicación</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody class="body-table" id="cuerpo_tabla_propietarios">
                </tbody>
            </table>`;
        cuerpoTabla = document.getElementById('cuerpo_tabla_propietarios');
    }

    cuerpoTabla.innerHTML = '';
    consultarPropietarios(numeroPlaca, urlBase).then(respuesta=>{
        if(respuesta.tipo == 'OK'){
            console.log(cuerpoTabla);
            respuesta.propietarios.forEach(propietario => {
                cuerpoTabla.innerHTML += `
                    <tr class="propietarios">
                        <td>${propietario.numero_documento}</td>
                        <td>${propietario.nombres} ${propietario.apellidos}</td>
                        <td>${propietario.telefono}</td>
                        <td>${propietario.correo_electronico}</td>
                        <td>${propietario.ubicacion}</td>
                        <td class="contenedor-colum-acciones-ptr">
                            <a class="btn-cancelar-table" data-propietario="${propietario.numero_documento}">
                                <ion-icon name="trash-outline"></ion-icon>
                            </a>
                        </td>
                    </tr>`;
            });

            eventoEliminarPropietarioVehiculo();

        }else if(respuesta.tipo == 'ERROR'){
            if(respuesta.titulo == 'Sesión Expirada'){
                    window.location.replace(urlBase+'sesion-expirada');
            }else{
                cuerpoTabla.innerHTML = `
                    <tr class="propietarios">
                        <td colspan="6">${respuesta.mensaje}</td>
                    </tr>`;
            }
        }

        contenedorModales.classList.add('mostrar');
    });
}

function dibujarCardsPropietarios(){
    consultarPropietarios(numeroPlaca, urlBase).then(respuesta=>{
        if(respuesta.tipo == 'OK'){
            respuesta.propietarios.forEach(propietario => {
                contenedorTabla.innerHTML += `
                    <div class="document-card">
                        <div class="card-header">
                            <div>
                                <p class="document-title">${propietario.tipo_documento} ${propietario.numero_documento}</p>
                                <p class="document-meta">Nombres: ${propietario.nombres} ${propietario.apellidos}</p>
                            </div>
                            <span class="toggle-icon"><ion-icon name="chevron-down-outline"></ion-icon></span> 
                        </div>
                        
                        <div class="card-details">
                            <p><strong>Télefono: </strong>${propietario.telefono}</p>
                            <p><strong>Correo Electrónico: </strong>${propietario.correo_electronico}</p>
                            <p><strong>Ubicación: </strong>${propietario.ubicacion}</p>
                        </div>

                        <div class="contenedor-acciones">
                            <a class="btn-cancelar-table" data-propietario="${propietario.numero_documento}">
                                <ion-icon name="trash-outline"></ion-icon>
                            </a>
                        </div>
                    </div>`;
            });

            eventoEliminarPropietarioVehiculo();

        }else if(respuesta.tipo == 'ERROR'){
            if(respuesta.titulo == 'Sesión Expirada'){
                window.location.replace(urlBase+'sesion-expirada');
            }else{
                contenedor.innerHTML = `
                    <div class="document-card">
                        <div class="card-header">
                            <div>
                                <p class="document-meta">${respuesta.mensaje}</p>
                            </div>
                        </div>
                    </div>`;
            }
        }

        contenedorModales.classList.add('mostrar');
    });
}

function eventoEliminarPropietarioVehiculo(){
    const botonesEliminar = document.querySelectorAll('.btn-cancelar-table');

    botonesEliminar.forEach(boton => {
        let propietario = boton.getAttribute('data-propietario');
        boton.addEventListener('click', ()=>{
            let mensaje = {
                titulo: "Eliminar Propietario",
                mensaje: "¿Estas seguro que quieres eliminar este propietario?",
                propietario: propietario
            };
            alertaAdvertencia(mensaje);
        })
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
            eliminarPropietarioVehiculo(numeroPlaca, datos.propietario, urlBase).then(respuesta=>{
                if(respuesta.tipo == 'OK'){
                    alertaExito(respuesta);
                    validarResolucion();
                }else if(respuesta.tipo == 'ERROR'){
                    if(respuesta.titulo == 'Sesión Expirada'){
                        window.location.replace(urlBase+'sesion-expirada');
                    }else{
                        alertaError(respuesta);
                    }
                }
            })
        } 
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
