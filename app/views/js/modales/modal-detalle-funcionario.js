import { consultarFuncionario } from '../fetchs/funcionarios-fetch.js';
import { consultarModalDetalleFuncionario } from '../fetchs/modales-fetch.js';

let contenedorModales;
let modalesExistentes;
let documentoFuncionario;
let botonCerrarModal;
let urlBase;

function modalDetalleFuncionario(funcionario, url) {
    consultarModalDetalleFuncionario(url).then(respuesta=>{
        if(respuesta.tipo == 'OK'){
            const contenidoModal = respuesta.modal;
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

        }else if(respuesta.tipo == 'ERROR'){
            alertaError(respuesta);
        }
    }) 
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
            const datosFuncionario = respuesta.datos_funcionario;
            if(datosFuncionario.tipo_contrato == 'CONTRATISTA'){
                document.getElementById('fecha_fin_contrato').textContent = formatearFecha(datosFuncionario.fecha_fin_contrato);
            }else{
                document.getElementById('caja_fecha_fin_contrato').style.display='none';;
            }

            if(datosFuncionario.nombres_responsable != 'N/A'){
                document.getElementById('responsable_registro').textContent = formatearString(datosFuncionario.rol_responsable)+' -  '+datosFuncionario.nombres_responsable+' '+datosFuncionario.apellidos_responsable;

            }else{
                document.getElementById('caja_responsable_registro').style.display = 'none';
            }

            document.getElementById('tipo_documento').textContent = datosFuncionario.tipo_documento;
            document.getElementById('numero_documento').textContent = datosFuncionario.numero_documento;
            document.getElementById('nombres').textContent = datosFuncionario.nombres;
            document.getElementById('apellidos').textContent = datosFuncionario.apellidos;
            document.getElementById('telefono').textContent = formatearNumeroTelefono(datosFuncionario.telefono);
            document.getElementById('correo_electronico').textContent = datosFuncionario.correo_electronico;
            document.getElementById('rol').textContent = formatearString(datosFuncionario.rol);
            document.getElementById('brigadista').textContent = formatearString(datosFuncionario.brigadista);
            document.getElementById('tipo_contrato').textContent = formatearString(datosFuncionario.tipo_contrato);
            
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

