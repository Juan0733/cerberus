import {registrarVisitante} from '../fetchs/visitantes-fetch.js';

let contenedorModales;
let modalesExistentes;

async function modalRegistroVisitante(urlBase, documento=false) {
    try {
        const response = await fetch(urlBase+'app/views/inc/modales/modal-registro-visitante.php');

        if(!response.ok) throw new Error('Hubo un error en la solicitud');

        const contenidoModal = await response.text();
        const modal = document.createElement('div');
            
        modal.classList.add('contenedor-ppal-modal');
        modal.innerHTML = contenidoModal;
        contenedorModales = document.getElementById('contenedor-modales');
        contenedorModales.appendChild(modal);

        if(documento){
            let inputDocumento = document.getElementById('documento_visitante'); 
            inputDocumento.value = documento;
            inputDocumento.setAttribute('readonly', '');
        }
        
        modalesExistentes = contenedorModales.getElementsByClassName('contenedor-ppal-modal');
        if (modalesExistentes.length > 1) {
            modalesExistentes[modalesExistentes.length-2].style.display = 'none';
        }else{
            contenedorModales.classList.add('mostrar');
        } 
       
        eventoBotonCerrarModal();
        eventoFormularioVisitante(urlBase);

           
    } catch (error) {
        console.error('Error al cargar el modal:', error);
    }
    
}
export { modalRegistroVisitante };

function cerrarModal(){
   
    modalesExistentes[modalesExistentes.length-1].remove();
    if(modalesExistentes.length > 0) {
        modalesExistentes[modalesExistentes.length-1].style.display = 'block';
    }else{
        contenedorModales.classList.remove('mostrar');
    }
}

function eventoBotonCerrarModal(){
    document.getElementById('cerrar_modal_visitante').addEventListener('click', ()=>{
        cerrarModal();
    });

    document.getElementById('btn-cancelar').addEventListener('click', ()=>{
        cerrarModal();
    });
}



function eventoFormularioVisitante(UrlBase){
    let formularioVisitante = document.getElementById('forma_acceso_04');
    formularioVisitante.addEventListener('submit', (e)=>{
        e.preventDefault();
        let formData = new FormData(formularioVisitante);
        formData.append('operacion', 'registrar_visitante');

        registrarVisitante(formData, UrlBase).then(respuesta=>{
            if(respuesta.tipo == "ERROR" ){
                alertaError(respuesta);
                
            }else if(respuesta.tipo == "OK"){
                console.log(respuesta);
                alertaExito(respuesta);
                cerrarModal();
            }
        });
    })
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





