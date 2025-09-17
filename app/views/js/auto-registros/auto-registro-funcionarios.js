import { autoRegistrarFuncionario} from '../fetchs/funcionarios-fetch.js';

let urlBase;
let caja01;
let caja02;
let botonAtras;
let botonSiguiente;
let botonRegistrar;

function eventoAutoRegistrarFuncionario(){
    const formulariFuncionario = document.getElementById('formulario_funcionario');
    formulariFuncionario.addEventListener('submit', (e)=>{
        e.preventDefault();
        let formData = new FormData(formulariFuncionario);
        formData.append('operacion', 'auto_registrar_funcionario');

        autoRegistrarFuncionario(formData, urlBase).then(respuesta=>{
            if(respuesta.tipo == "OK"){
                respuesta.mensaje = "Te has registrado correctamente, ¡Bienvenido al CAB!"
                alertaExito(respuesta);

            }else if(respuesta.tipo == "ERROR"){ 
                alertaError(respuesta);
            }
        });
    })
}

function eventoSelectTipoContrato(){
    const selectTipoContrato = document.getElementById('tipo_contrato');
    const cajafechaContrato = document.getElementById('input_caja_fecha');
   
    selectTipoContrato.addEventListener('change', ()=>{
        if(selectTipoContrato.value == 'CONTRATISTA'){
            cajafechaContrato.style.display = 'flex';

        }else{
            cajafechaContrato.style.display = 'none';
        }
    })
}

function motrarCampos() {
    const inputsSeccion01 = document.getElementsByClassName('campo-seccion-01');
    const inputTelefono = document.getElementById('telefono');

    botonSiguiente.addEventListener('click', ()=>{
        let validos = true;

        for(const input of inputsSeccion01) {
            if(!input.checkValidity()){
                input.reportValidity();
                validos = false;
                break;
            }
        };

        if(validos){
            caja01.style.display = 'none';
            botonSiguiente.style.display = 'none';
            caja02.style.display = 'flex';
            botonRegistrar.style.display = 'flex';
            botonAtras.style.display = 'flex';

            inputTelefono.focus();
        }
    })
}

function volverCampos() {
    const inputTipoDocumento = document.getElementById('tipo_documento');

    botonAtras.addEventListener('click', ()=>{
        caja02.style.display = 'none';
        botonAtras.style.display = 'none';
        botonRegistrar.style.display = 'none'
        caja01.style.display = 'flex';
        botonSiguiente.style.display = 'flex';

        inputTipoDocumento.focus();
    })
}

function alertaExito(respuesta){
    Swal.fire({
        iconHtml: `<img src="${urlBase}app/views/img/logo-sena-verde-png-sin-fondo.webp" width="75" height="75">`,
        color: '#F3F4F4',
        title: respuesta.titulo,
        text: respuesta.mensaje,
        confirmButtonText: 'Aceptar',
        customClass: {
            popup: 'alerta-contenedor',
            confirmButton: 'btn-confirmar',
            icon: 'icono-exito-sena'
        }
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.replace(urlBase+'auto-registro-funcionarios');
        } 
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

document.addEventListener('DOMContentLoaded', ()=>{
    urlBase = document.getElementById('url_base').value;
    caja01 = document.getElementById('caja_01');
    caja02 = document.getElementById('caja_02');
    botonAtras = document.getElementById('btn_atras_funcionario');
    botonSiguiente = document.getElementById('btn_siguiente_funcionario');
    botonRegistrar = document.getElementById('btn_registrarme_funcionario');

    eventoSelectTipoContrato();
    motrarCampos();
    volverCampos();
    eventoAutoRegistrarFuncionario();
})

