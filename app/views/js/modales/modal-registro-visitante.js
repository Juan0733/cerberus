import {registrarVisitante} from '../fetchs/visitantes-fetch.js';

let contenedorModales;
let modalesExistentes;
let botonCerrarModal;
let funcionCallback;
let urlBase;

async function modalRegistroVisitante(url, documento=false, callback=false) {
    try {
        const response = await fetch(url+'app/views/inc/modales/modal-visitante.php');

        if(!response.ok) throw new Error('Hubo un error en la solicitud');

        const contenidoModal = await response.text();
        const modal = document.createElement('div');
            
        modal.classList.add('contenedor-ppal-modal');
        modal.innerHTML = contenidoModal;
        contenedorModales = document.getElementById('contenedor-modales');
        contenedorModales.appendChild(modal);

        if(documento){
            let documentoVisitante = document.getElementById('documento_visitante'); 
            documentoVisitante.value = documento;
            documentoVisitante.setAttribute('readonly', '');
        }

        if(callback){
            funcionCallback = callback;
        }

        urlBase = url;
        
        modalesExistentes = contenedorModales.getElementsByClassName('contenedor-ppal-modal');
        if (modalesExistentes.length > 1) {
            modalesExistentes[modalesExistentes.length-2].style.display = 'none';
        }else{
            contenedorModales.classList.add('mostrar');
        } 

        setTimeout(()=>{
            document.getElementById('nombres').focus();
        }, 250)
       
        eventoBotonCerrarModal();
        eventoFormularioVisitante();

           
    } catch (error) {
        let respuesta = {
            titulo: 'Error Modal',
            mensaje: 'Error al cargar el modal de registro de visitante'
        }

        alertaError(respuesta);
    }
    
}
export { modalRegistroVisitante };

function eventoBotonCerrarModal(){
    botonCerrarModal = document.getElementById('cerrar_modal_visitante');

    botonCerrarModal.addEventListener('click', ()=>{
        modalesExistentes[modalesExistentes.length-1].remove();
        if(modalesExistentes.length > 0) {
            modalesExistentes[modalesExistentes.length-1].style.display = 'block';
        }else{
            contenedorModales.classList.remove('mostrar');
        }
    });

    document.getElementById('btn_cancelar_visitante').addEventListener('click', ()=>{
        botonCerrarModal.click();
    });
}



function eventoFormularioVisitante(){
    let formularioVisitante = document.getElementById('forma_acceso_04');
    formularioVisitante.addEventListener('submit', (e)=>{
        e.preventDefault();
        let formData = new FormData(formularioVisitante);
        formData.append('operacion', 'registrar_visitante');

        registrarVisitante(formData, urlBase).then(respuesta=>{
            if(respuesta.tipo == "ERROR" ){
                alertaError(respuesta);
                
            }else if(respuesta.tipo == "OK"){
                alertaExito(respuesta);
                botonCerrarModal.click();

                if(funcionCallback){
                    funcionCallback(respuesta);
                }
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





