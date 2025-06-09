import {registrarNovedadUsuario} from '../fetchs/novedades-usuarios-fetch.js';

let contenedorModales;
let modalesExistentes;
let botonCerrarModal;
let funcionCallback;
let urlBase;

async function modalRegistroNovedadUsuario(url, novedad, documento, callback=false) {
    try {
        const response = await fetch(url+'app/views/inc/modales/modal-novedad-usuario.php');

        if(!response.ok) throw new Error('Hubo un error en la solicitud');

        const contenidoModal = await response.text();
        const modal = document.createElement('div');
            
        modal.classList.add('contenedor-ppal-modal');
        modal.innerHTML = contenidoModal;
        contenedorModales = document.getElementById('contenedor-modales');
        contenedorModales.appendChild(modal);

        let documentoInvolucrado = document.getElementById('documento_involucrado'); 
        let tipoNovedad = document.getElementById('tipo_novedad');

        documentoInvolucrado.value = documento;
        documentoInvolucrado.setAttribute('readonly', '');
        tipoNovedad.value = novedad;
        tipoNovedad.setAttribute('readonly', '');

        if(callback){
            funcionCallback = callback;
        }

        urlBase = url;

        modalesExistentes = contenedorModales.getElementsByClassName('contenedor-ppal-modal');
        if(modalesExistentes.length > 1){
            modalesExistentes[modalesExistentes.length-2].style.display = 'none';
        }else{
            contenedorModales.classList.add('mostrar');
        }
       
        eventoCerrarModal();
        eventoRegistrarNovedadUsuario();

           
    } catch (error) {
        if(botonCerrarModal){
            botonCerrarModal.click();
        }

        let respuesta = {
            titulo: 'Error Modal',
            mensaje: 'Error al cargar modal de registro de novedad'
        }
        
        alertaError(respuesta);
    }
    
}
export { modalRegistroNovedadUsuario };

function eventoCerrarModal(){
    botonCerrarModal = document.getElementById('cerrar_modal_novedad_usuario');

    botonCerrarModal.addEventListener('click', ()=>{
        modalesExistentes[modalesExistentes.length-1].remove();
        if(modalesExistentes.length > 0) {
            modalesExistentes[modalesExistentes.length-1].style.display = 'block';
        }else{
            contenedorModales.classList.remove('mostrar');
        }
    });

    document.getElementById('btn_cancelar_novedad').addEventListener('click', ()=>{
        botonCerrarModal.click();
    });
}

function eventoRegistrarNovedadUsuario(){
    let formularioNovedad = document.getElementById('forma_acceso_05');
    formularioNovedad.addEventListener('submit', (e)=>{
        e.preventDefault();
        let formData = new FormData(formularioNovedad);
        formData.append('operacion', 'registrar_novedad_usuario');

        registrarNovedadUsuario(formData, urlBase).then(respuesta=>{
            if(respuesta.tipo == "OK" ){
                alertaExito(respuesta);
                botonCerrarModal.click();
                if(funcionCallback){
                    funcionCallback();
                }
                
            }else if(respuesta.tipo == "ERROR"){
                if(respuesta.titulo == 'Sesión Expirada'){
                    window.location.replace(urlBase+'sesion-expirada');

                }else{
                    alertaError(respuesta);
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



