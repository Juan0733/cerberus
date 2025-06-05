import {consultarFuncionarios} from '../fetchs/funcionarios-fetch.js';

let contenedorModales;
let modalesExistentes;
let urlBase;

async function modalFuncionariosBrigadistas(url) {
    try {
        const response = await fetch(url+'app/views/inc/modales/modal-funcionarios-brigadistas.php');

        if(!response.ok) throw new Error('Hubo un error en la solicitud');

        const contenidoModal = await response.text();
        const modal = document.createElement('div');
            
        modal.classList.add('contenedor-ppal-modal');
        modal.id = 'modal_brigadistas';
        modal.innerHTML = contenidoModal;
        contenedorModales = document.getElementById('contenedor-modales');
        contenedorModales.appendChild(modal);
        modalesExistentes = contenedorModales.getElementsByClassName('contenedor-ppal-modal');
        urlBase = url;
         
        eventoCerrarModal();
        dibujarBrigadistas();

           
    } catch (error) {
        let respuesta = {
            titulo: 'Error Modal',
            mensaje: 'Error al cargar modal brigadistas.'
        }
        
        alertaError(respuesta);
    }
    
}
export { modalFuncionariosBrigadistas };

function eventoCerrarModal(){
    document.getElementById('cerrar_modal_brigadista').addEventListener('click', ()=>{
        modalesExistentes[modalesExistentes.length-1].remove();
        contenedorModales.classList.remove('mostrar');
    });
}

function dibujarBrigadistas(){
    consultarFuncionarios('SI', 'DENTRO', '', urlBase).then(respuesta=>{
        const contenedor = document.getElementById('cont_info_modales');
        if(respuesta.tipo == 'OK'){
            respuesta.funcionarios.forEach(funcionario => {
                let telefonoFormateado = '';
                for (let i = 0; i < funcionario.telefono.length; i++) {
                    telefonoFormateado += funcionario.telefono[i];
                    if(i == 2 || i == 4 || i == 6 || i == 8){
                        telefonoFormateado += '-';
                    }
                }

                funcionario.telefono = telefonoFormateado;
                contenedor.innerHTML += `
                    <div class="document-card">
                        <div class="card-header">
                            <div>
                                <p class="document-title">${funcionario.nombres} ${funcionario.apellidos}</p>
                                <p class="document-meta">${funcionario.telefono}</p>
                            </div>
                        </div>
                    </div>`;
            });

        }else if(respuesta.tipo == 'ERROR'){
            if(respuesta.titulo == 'Datos No Encontrados'){
               contenedor.innerHTML = `
                    <div class="document-card">
                        <div class="card-header">
                            <div>
                                <p class="document-meta">No hay brigadistas dentro del CAB</p>
                            </div>
                        </div>
                    </div>`;
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
