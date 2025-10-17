import {consultarBrigadistas, consultarFuncionarios} from '../fetchs/funcionarios-fetch.js';
import { consultarModalBrigadistas } from '../fetchs/modales-fetch.js';

let contenedorModales;
let modalesExistentes;
let botonCerrarModal;
let urlBase;

async function modalBrigadistas(url) {
   consultarModalBrigadistas(url).then(respuesta=>{
        if(respuesta.tipo == 'OK'){
            const contenidoModal = respuesta.modal;
            const modal = document.createElement('div');
                
            modal.classList.add('contenedor-ppal-modal');
            modal.id = 'modal_brigadistas';
            modal.innerHTML = contenidoModal;
            contenedorModales = document.getElementById('contenedor_modales');

            modalesExistentes = contenedorModales.getElementsByClassName('contenedor-ppal-modal');
            if(modalesExistentes.length > 0){
            for (let i = 0; i < modalesExistentes.length; i++) {
                    modalesExistentes[i].remove();
                }
            }

            contenedorModales.appendChild(modal);

            urlBase = url;
            
            eventoCerrarModal();
            dibujarBrigadistas();

        }else if(respuesta.tipo == 'ERROR'){
            alertaError(respuesta);
        } 
    })
}
export { modalBrigadistas };

function eventoCerrarModal(){
    botonCerrarModal = document.getElementById('cerrar_modal_brigadista');
    
    botonCerrarModal.addEventListener('click', ()=>{
        modalesExistentes[modalesExistentes.length-1].remove();
        contenedorModales.classList.remove('mostrar');
    });
}

function dibujarBrigadistas(){
    consultarBrigadistas(urlBase).then(respuesta=>{
        const contenedor = document.getElementById('cont_info_modales');
        if(respuesta.tipo == 'OK'){
            respuesta.brigadistas.forEach(brigadista => {
                contenedor.innerHTML += `
                    <div class="document-card-brigadista">
                        <div class="card-header">
                            <div>
                                <p class="document-title">${brigadista.nombres} ${brigadista.apellidos}</p>
                                <p class="document-meta">${formatearNumeroTelefono(brigadista.telefono)}</p>
                            </div>
                        </div>
                    </div>`;
            });

            contenedorModales.classList.add('mostrar');

        }else if(respuesta.tipo == 'ERROR'){
            if(respuesta.titulo == 'Datos No Encontrados'){
                contenedor.innerHTML = `<p id="mensaje_respuesta">No hay brigadistas dentro del CAB</p>`;

                contenedorModales.classList.add('mostrar');

            }else if(respuesta.titulo == 'Sesión Expirada'){
                window.location.replace(urlBase+'sesion-expirada');

            }else{
                botonCerrarModal.click();
                alertaError(respuesta);
            }
        }
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
