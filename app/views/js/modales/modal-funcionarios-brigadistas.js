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
        modal.innerHTML = contenidoModal;
        contenedorModales = document.getElementById('contenedor-modales');
        contenedorModales.appendChild(modal);
        modalesExistentes = contenedorModales.getElementsByClassName('contenedor-ppal-modal');
        urlBase = url;
         
        eventoCerrarModal();

        if(window.innerWidth > 1024){
            dibujarTablaBrigadistas();
        }else{
            dibujarCardBrigadistas();
        }

           
    } catch (error) {
        let respuesta = {
            titulo: 'Error Modal',
            mensaje: 'Error al cargar el modal de brigadistas.'
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

function dibujarTablaBrigadistas(){
    
    consultarFuncionarios('SI', 'DENTRO', '', urlBase).then(respuesta=>{
        document.getElementById('cont_info_modales').innerHTML = `
            <table class="table">
                <thead class="head-table">
                    <tr>
                        <th>No. Documento</th>
                        <th>Nombres</th>
                        <th>Apellidos</th>
                        <th>Cargo</th>
                        <th>Telefono</th>
                        <th>Correo Electronico</th>
                    </tr>
                </thead>
                <tbody class="body-table" id="cuerpo_tabla_brigadistas">
                </tbody>
            </table>`;

        const cuerpoTabla = document.getElementById('cuerpo_tabla_brigadistas');

        if(respuesta.tipo == 'OK'){
            respuesta.funcionarios.forEach(funcionario => {
                cuerpoTabla.innerHTML += `
                    <tr class="propietarios">
                        <td>${funcionario.numero_documento}</td>
                        <td>${funcionario.nombres}</td>
                        <td>${funcionario.apellidos}</td>
                        <td>${funcionario.rol}</td>
                        <td>${funcionario.telefono}</td>
                        <td>${funcionario.correo_electronico}</td>
                    </tr>
                `
            });
         
            contenedorModales.classList.add('mostrar');

        }else if(respuesta.tipo == 'ERROR'){
            if(respuesta.titulo == 'Datos No Encontrados'){
                cuerpoTabla.innerHTML = `
                    <tr>
                        <td colspan="6">No hay brigadistas dentro del CAB</td>
                    </tr>`;

                contenedorModales.classList.add('mostrar');
            }else{
                alertaError(respuesta);
                modalesExistentes[modalesExistentes.length-1].remove();
            }
        }
    })
}

function dibujarCardBrigadistas(){
    consultarFuncionarios('SI', 'DENTRO', '', urlBase).then(respuesta=>{
        const contenedor = document.getElementById('cont_info_modales');
        if(respuesta.tipo == 'OK'){
            respuesta.funcionarios.forEach(funcionario => {
                contenedor.innerHTML += `
                    <div class="document-card">
                        <div class="card-header">
                            <div>
                                <p class="document-title">${funcionario.nombres} ${funcionario.apellidos}</p>
                                <p class="document-meta">Cargo: ${funcionario.rol}</p>
                            </div>
                            <span class="toggle-icon"><ion-icon name="chevron-down-outline"></ion-icon></span> 
                        </div>
                        
                        <div class="card-details">
                            <p><strong>No.Documento: </strong>${funcionario.numero_documento}</p>
                            <p><strong>Telefono: </strong>${funcionario.telefono}</p>
                            <p><strong>Correo Electronico: </strong>${funcionario.correo_electronico}</p>
                        </div>
                    </div>'`;

                toggleCard();
            });

            contenedorModales.classList.add('mostrar');

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
                contenedorModales.classList.add('mostrar');
            }else{
                alertaError(respuesta);
                modalesExistentes[modalesExistentes.length-1].remove();
            }
        }
    });
}

function toggleCard() {
    const Cards = document.querySelectorAll('.document-card');
    
    Cards.forEach(cardEvento => {
        cardEvento.addEventListener('click', function() {
            Cards.forEach(card => {
                if(card !== cardEvento) {
                    card.classList.remove('active');
                }
            });
            cardEvento.classList.toggle('active');
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
