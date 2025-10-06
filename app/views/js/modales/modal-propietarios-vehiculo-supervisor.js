import { consultarModalPropietariosVehiculo } from '../fetchs/modal-fetch.js';
import {consultarPropietarios, eliminarPropietarioVehiculo} from '../fetchs/vehiculos-fetch.js';

let contenedorModales;
let botonCerrarModal;
let contenedorInformacion;
let numeroPlaca;
let modalesExistentes;
let cuerpoTabla;
let urlBase;

function validarResolucion(){
    if(window.innerWidth >= 1024){
        dibujarTablaPropietarios();
    }else{
        dibujarCardsPropietarios();
    }
}

function modalPropietariosVehiculo(placa, url) {
    consultarModalPropietariosVehiculo(url).then(respuesta=>{
        if(respuesta.tipo == 'OK'){
            const contenidoModal = respuesta.modal;
            const modal = document.createElement('div');
                
            modal.classList.add('contenedor-ppal-modal');
            modal.id = 'modal_propietarios';
            modal.innerHTML = contenidoModal;
            contenedorModales = document.getElementById('contenedor_modales');

            modalesExistentes = contenedorModales.getElementsByClassName('contenedor-ppal-modal');
            if(modalesExistentes.length > 0){
            for (let i = 0; i < modalesExistentes.length; i++) {
                    modalesExistentes[i].remove();
                }
            }

            contenedorModales.appendChild(modal);

            document.getElementById('titulo_modal').textContent = 'Propietarios Vehículo '+placa.toUpperCase();
            contenedorInformacion = document.getElementById('cont_info_modales');
            urlBase = url;
            cuerpoTabla = '';
            numeroPlaca = placa;
            
            eventoCerrarModal(); 
            validarResolucion();

        }else if(respuesta.tipo == 'ERROR'){
            alertaError(respuesta);
        }
    })
}
export { modalPropietariosVehiculo };

function eventoCerrarModal(){
    botonCerrarModal = document.getElementById('cerrar_modal_propietarios');
    
    botonCerrarModal.addEventListener('click', ()=>{
        modalesExistentes[modalesExistentes.length-1].remove();
        contenedorModales.classList.remove('mostrar');
    });
}

function dibujarTablaPropietarios(){
    if(!cuerpoTabla){
        contenedorInformacion.innerHTML = `
            <table class="table" id="tabla_propietarios">
                <thead class="head-table">
                    <tr>
                        <th>No. Documento</th>
                        <th>Nombres</th>
                        <th>Teléfono</th>
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
            respuesta.propietarios.forEach(propietario => {
                cuerpoTabla.innerHTML += `
                    <tr class="propietarios">
                        <td>${propietario.numero_documento}</td>
                        <td>${propietario.nombres} ${propietario.apellidos}</td>
                        <td>${formatearNumeroTelefono(propietario.telefono)}</td>
                        <td>${propietario.ubicacion}</td>
                        <td class="contenedor-colum-acciones-ptr">
                            <ion-icon name="trash" class="eliminar-propietario" data-propietario="${propietario.numero_documento}"></ion-icon>
                        </td>
                    </tr>`;
            });

            eventoEliminarPropietarioVehiculo();

            contenedorModales.classList.add('mostrar');
            
        }else if(respuesta.tipo == 'ERROR'){
            if(respuesta.titulo == 'Sesión Expirada'){
                window.location.replace(urlBase+'sesion-expirada');

            }else{
                botonCerrarModal.click();
                alertaError(respuesta);
            }
        }
    });
}

function dibujarCardsPropietarios(){
    cuerpoTabla = '';
    consultarPropietarios(numeroPlaca, urlBase).then(respuesta=>{
        if(respuesta.tipo == 'OK'){
            contenedorInformacion.innerHTML = '';
            respuesta.propietarios.forEach(propietario => {
                contenedorInformacion.innerHTML += `
                    <div class="document-card-propietario">
                        <div class="card-header">
                            <div>
                                <p class="document-title">${propietario.nombres} ${propietario.apellidos}</p>
                                <p class="document-meta">${propietario.tipo_documento}. ${propietario.numero_documento}</p>
                            </div>
                            <span class="toggle-icon"><ion-icon name="chevron-down-outline"></ion-icon></span> 
                        </div>
                        
                        <div class="card-details">
                            <p><strong>Teléfono: </strong>${formatearNumeroTelefono(propietario.telefono)}</p>
                            <p><strong>Ubicación: </strong>${propietario.ubicacion}</p>
                        </div>

                        <div class="contenedor-acciones">
                            <ion-icon name="trash" class="eliminar-propietario" data-propietario="${propietario.numero_documento}"></ion-icon>
                        </div>
                    </div>`;
            });

            toggleCard();
            eventoEliminarPropietarioVehiculo();

            contenedorModales.classList.add('mostrar');

        }else if(respuesta.tipo == 'ERROR'){
            if(respuesta.titulo == 'Sesión Expirada'){
                window.location.replace(urlBase+'sesion-expirada');

            }else{
                botonCerrarModal.click();
                alertaError(respuesta);
            }
        }
    });
}

function toggleCard() {
    const cards = document.querySelectorAll('.document-card-propietario');
    
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

function eventoEliminarPropietarioVehiculo(){
    const botonesEliminar = document.querySelectorAll('.eliminar-propietario');

    botonesEliminar.forEach(boton => {
        let propietario = boton.getAttribute('data-propietario');
        boton.addEventListener('click', ()=>{
            let mensaje = {
                titulo: "Eliminar Propietario",
                mensaje: "¿Estás seguro que quieres eliminar este propietario?",
                propietario: propietario
            };
            alertaAdvertencia(mensaje);
        })
    })
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

window.addEventListener('resize', ()=>{
    setTimeout(()=>{
        if(window.innerWidth >= 1024 && document.querySelector('.document-card-propietario')){
            validarResolucion();

        }else if(window.innerWidth < 1024 && cuerpoTabla){
            validarResolucion();
        }
    }, 250)
});
