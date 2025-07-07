import { consultarFuncionario } from '../fetchs/funcionarios-fetch.js';

let contenedorModales;
let modalesExistentes;
let documentoFuncionario;
let botonCerrarModal;
let urlBase;

const contenedorSpinner = document.getElementById('contenedor_spinner');

async function modalDetalleFuncionario(funcionario, url) {
    try {
        contenedorSpinner.classList.add("mostrar_spinner");
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
        contenedorSpinner.classList.remove("mostrar_spinner");
        
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
            const datosFuncionario = respuesta.datos_funcionario
            document.getElementById('tipo_documento').textContent = datosFuncionario.tipo_documento
            document.getElementById('numero_documento').textContent = datosFuncionario.numero_documento;
            document.getElementById('nombres').textContent = datosFuncionario.nombres;
            document.getElementById('apellidos').textContent = datosFuncionario.apellidos;
            document.getElementById('telefono').textContent = datosFuncionario.telefono;
            document.getElementById('correo_electronico').textContent = datosFuncionario.correo_electronico;
            document.getElementById('rol').textContent = formatearString(datosFuncionario.rol);
            document.getElementById('brigadista').textContent = formatearString(datosFuncionario.brigadista);
            document.getElementById('tipo_contrato').textContent = formatearString(datosFuncionario.tipo_contrato);
            
            if(datosFuncionario.tipo_contrato == 'CONTRATISTA'){
                document.getElementById('fecha_fin_contrato').textContent = formatearFecha(datosFuncionario.fecha_fin_contrato);
            }else{
                document.getElementById('caja_fecha_fin_contrato').style.display='none';;
            }
            
            contenedorSpinner.classList.remove("mostrar_spinner");
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

function formatearString(cadena) { 
    cadena = cadena.toLowerCase();
    cadena = cadena.charAt(0).toUpperCase() + cadena.slice(1);
    return cadena; 
}

function formatearFecha(fecha){
    const fechaDividida = fecha.split('-');
    const objetoFecha = new Date(parseInt(fechaDividida[0]), parseInt(fechaDividida[1]) - 1, parseInt(fechaDividida[2]));

    const opciones = { day: 'numeric', month: 'long', year: 'numeric' }
    const fechaEspañol = objetoFecha.toLocaleDateString('es-CO', opciones);

    return fechaEspañol;
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

