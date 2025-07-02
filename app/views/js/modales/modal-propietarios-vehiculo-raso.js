import {consultarPropietarios} from '../fetchs/vehiculos-fetch.js';

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

async function modalPropietariosVehiculo(placa, url) {
    try {
        const response = await fetch(url+'app/views/inc/modales/modal-propietarios-vehiculo.php');

        if(!response.ok) throw new Error('Hubo un error en la solicitud');

        const contenidoModal = await response.text();
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
        
    } catch (error) {
        if(botonCerrarModal){
            botonCerrarModal.click();
        }
        
        console.error('Hubo un error:', error);
        alertaError({
            titulo: 'Error Modal',
            mensaje: 'Error al cargar modal propietarios.'
        });
    }
    
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
                        <td>${propietario.ubicacion}</td>
                    </tr>`;
            });

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
    consultarPropietarios(numeroPlaca, urlBase).then(respuesta=>{
        if(respuesta.tipo == 'OK'){
            respuesta.propietarios.forEach(propietario => {
                contenedorInformacion.innerHTML += `
                    <div class="document-card-propietario">
                        <div class="card-header">
                            <div>
                                <p class="document-title">${propietario.tipo_documento} ${propietario.numero_documento}</p>
                                <p class="document-meta">Nombres: ${propietario.nombres} ${propietario.apellidos}</p>
                            </div>
                            <span class="toggle-icon"><ion-icon name="chevron-down-outline"></ion-icon></span> 
                        </div>
                        
                        <div class="card-details">
                            <p><strong>Teléfono: </strong>${propietario.telefono}</p>
                            <p><strong>Ubicación: </strong>${propietario.ubicacion}</p>
                        </div>
                    </div>`;
            });

            toggleCard();

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
