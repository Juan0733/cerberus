import { consultarFuncionario } from '../fetchs/funcionarios-fetch.js';

let contenedorModales;
let modalesExistentes;
let documentoFuncionario;
let botonCerrarModal;
let urlBase;

async function modalDetalleFuncionario(funcionario, url) {
    try {
        const response = await fetch(url+'app/views/inc/modales/modal-detalle-funcionario.php');

        if(!response.ok) throw new Error('Hubo un error en la solicitud');

        const contenidoModal = await response.text();
        const modal = document.createElement('div');
            
        modal.classList.add('contenedor-ppal-modal');
        modal.id = 'modal_detalle_funcionario';
        modal.innerHTML = contenidoModal;
        contenedorModales = document.getElementById('contenedor_modales');
        
        modalesExistentes = contenedorModales.getElementsByClassName('contenedor-ppal-modal');
        if(modalesExistentes.length > 0){
           for (let i = 0; i < modalesExistentes.length; i++) {
                modalesExistentes[i].remove();
            }
        }

        contenedorModales.appendChild(modal);

        documentoFuncionario = funcionario;
        urlBase = url;
         
        eventoCerrarModal();
        dibujarFuncionario();

    } catch (error) {
        if(botonCerrarModal){
            botonCerrarModal.click();
        }
        
        console.error('Hubo un error:', error);
        alertaError({
            titulo: 'Error Modal',
            mensaje: 'Error al cargar modal detalle funcionario.'
        });
    }
}
export{modalDetalleFuncionario}

function eventoCerrarModal(){
    botonCerrarModal = document.getElementById('cerrar_modal_detalle_funcionario');

    botonCerrarModal.addEventListener('click', ()=>{
        modalesExistentes[modalesExistentes.length-1].remove();
        contenedorModales.classList.remove('mostrar');
    });
}

function dibujarFuncionario() {
    consultarFuncionario(documentoFuncionario, urlBase).then(respuesta=>{
        if(respuesta.tipo == 'OK'){
            document.getElementById('tipo_documento').textContent = respuesta.datos_funcionario.tipo_documento
            document.getElementById('numero_documento').textContent = respuesta.datos_funcionario.numero_documento;
            document.getElementById('nombres').textContent = respuesta.datos_funcionario.nombres;
            document.getElementById('apellidos').textContent = respuesta.datos_funcionario.apellidos;
            document.getElementById('telefono').textContent = respuesta.datos_funcionario.telefono;
            document.getElementById('correo_electronico').textContent = respuesta.datos_funcionario.correo_electronico;
            document.getElementById('rol').textContent = respuesta.datos_funcionario.rol;
            document.getElementById('brigadista').textContent = respuesta.datos_funcionario.brigadista;
            document.getElementById('tipo_contrato').textContent = respuesta.datos_funcionario.tipo_contrato;
            document.getElementById('fecha_fin_contrato').textContent = respuesta.datos_funcionario.fecha_fin_contrato_formateada;

            contenedorModales.classList.add('mostrar');

        }else if(respuesta.tipo == 'ERROR'){
            if(respuesta.titulo == 'Sesión Expirada'){
                window.location.replace(urlBase+'sesion-expirada');

            }else{
                botonCerrarModal.click();
                alertaError(respuesta);
                
            }
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

