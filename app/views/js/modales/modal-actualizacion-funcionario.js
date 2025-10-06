import {actualizarFuncionario, consultarFuncionario} from '../fetchs/funcionarios-fetch.js';
import { consultarModalFuncionario } from '../fetchs/modal-fetch.js';

let contenedorModales;
let modalesExistentes;
let botonCerrarModal;
let modal;
let contenedorCajas;
let seccionIndividual01;
let seccionIndividual02;
let seccionIndividual03;
let rolActual;
let documentoFuncionario;
let selectTipoDocumento;
let inputDocumento;
let inputNombres;
let inputApellidos;
let inputTelefono;
let inputCorreo;
let selectBrigadista;
let selectTipoContrato;
let selectRol;
let inputContrasena;
let inputConfirmacion;
let inputFechaContrato;
let botonAtras;
let botonCancelar;
let botonRegistrar;
let botonSiguiente;
let funcionCallback;
let urlBase;

function modalActualizacionFuncionario(funcionario, callback, url) {
    consultarModalFuncionario(url).then(respuesta=>{
        if(respuesta.tipo == 'OK'){
            const contenidoModal = respuesta.modal;
            modal = document.createElement('div');
                
            modal.classList.add('contenedor-ppal-modal');
            modal.id = 'modal_funcionario';
            modal.innerHTML = contenidoModal;
            contenedorModales = document.getElementById('contenedor_modales');

            modalesExistentes = contenedorModales.getElementsByClassName('contenedor-ppal-modal');
            if(modalesExistentes.length > 0){
            for (let i = 0; i < modalesExistentes.length; i++) {
                    modalesExistentes[i].remove();
                }
            }

            contenedorModales.appendChild(modal);

            contenedorCajas = document.getElementById('contenedor_cajas_funcionario');
            seccionIndividual01 = document.getElementsByClassName('seccion-individual-01');
            seccionIndividual02 = document.getElementsByClassName('seccion-individual-02');
            seccionIndividual03 = document.getElementsByClassName('seccion-individual-03');
            selectTipoDocumento = document.getElementById('tipo_documento');
            inputDocumento = document.getElementById('numero_documento');
            inputNombres =  document.getElementById('nombres');
            inputApellidos = document.getElementById('apellidos');
            inputTelefono = document.getElementById('telefono');
            inputCorreo =  document.getElementById('correo_electronico');
            selectBrigadista = document.getElementById('brigadista');
            selectRol = document.getElementById('rol');
            selectTipoContrato = document.getElementById('tipo_contrato');
            inputFechaContrato = document.getElementById('fecha_fin_contrato');
            inputContrasena = document.getElementById('contrasena');
            inputConfirmacion = document.getElementById('confirmacion_contrasena');
            botonCancelar = document.getElementById('btn_cancelar_funcionario');
            botonAtras = document.getElementById('btn_atras_funcionario');
            botonSiguiente = document.getElementById('btn_siguiente_funcionario');
            botonRegistrar = document.getElementById('btn_registrar_funcionario');
            
            botonRegistrar.textContent = 'Actualizar';
            document.getElementById('titulo_modal_funcionario').textContent = 'Actualizar Funcionario';
            
            documentoFuncionario = funcionario;
            funcionCallback = callback;
            urlBase = url;

            eventoCerrarModal();
            mostrarSeccionIndividual();
            eventoSelectContrato();
            eventoSelectRol();
            validarConfirmacionContrasena();
            eventoInputContrasena();
            mostrarCampos();
            volverCampos();
            eventoActualizarFuncionario();
            dibujarFuncionario();

            setTimeout(()=>{
            selectTipoDocumento.focus();
            }, 250)
        }
    })
      

}
export { modalActualizacionFuncionario };

function eventoCerrarModal(){
    botonCerrarModal = document.getElementById('cerrar_modal_funcionario');

    botonCerrarModal.addEventListener('click', ()=>{
        modalesExistentes[modalesExistentes.length-1].remove();
        contenedorModales.classList.remove('mostrar');
        
    });

    botonCancelar.addEventListener('click', ()=>{
        botonCerrarModal.click();
    });
}

function mostrarSeccionIndividual(){
    const seccionPrincipal = document.getElementsByClassName('seccion-principal');
    const seccionIndividual = document.getElementsByClassName('seccion-individual');
    const inputsSeccionIndividual = document.getElementsByClassName('campo-individual');

    for(const caja of seccionPrincipal){
        caja.style.display = 'none';
    };

    if(window.innerWidth >= 768){
        for(const caja of seccionIndividual){
            caja.style.display = 'block';
        };

        modal.style.width = 'clamp(550px, 50%, 980px)';
        contenedorCajas.style.gridTemplateColumns = 'repeat(2, 1fr)';

        botonSiguiente.style.display = 'none';
        botonRegistrar.style.display = 'flex';

    }else if(window.innerWidth <= 767){
        for(const caja of seccionIndividual01){
            caja.style.display = 'block';
        };
    }

    for(const input of inputsSeccionIndividual){
        input.required = true;
    };
}

function dibujarFuncionario(){
    consultarFuncionario(documentoFuncionario, urlBase).then(respuesta=>{
        if(respuesta.tipo == 'OK'){
            const datosFuncionario = respuesta.datos_funcionario;
            selectTipoDocumento.value = datosFuncionario.tipo_documento;
            selectTipoDocumento.disabled = true;
            inputDocumento.value = datosFuncionario.numero_documento;
            inputDocumento.readOnly = true;
            inputNombres.value = datosFuncionario.nombres;
            inputApellidos.value = datosFuncionario.apellidos;
            inputTelefono.value = datosFuncionario.telefono;
            inputCorreo.value = datosFuncionario.correo_electronico;
            selectBrigadista.value = datosFuncionario.brigadista;
            selectTipoContrato.value = datosFuncionario.tipo_contrato;
            selectRol.value = datosFuncionario.rol;

            rolActual = datosFuncionario.rol;

            if(datosFuncionario.tipo_contrato == 'CONTRATISTA'){
                inputFechaContrato.value = datosFuncionario.fecha_fin_contrato;
            }

            selectRol.dispatchEvent(new Event("change", { bubbles: true }));
            selectTipoContrato.dispatchEvent(new Event("change", { bubbles: true }));

            contenedorModales.classList.add('mostrar');

        }else if(respuesta.tipo == 'ERROR'){
            if(respuesta.titulo == 'Sesión Expirada'){
                window.location.replace(urlBase+'sesion-expirada');
                
            }else{
                botonCerrarModal.click();
                alertaError (respuesta);
            } 
        }
    })
}

function validarConfirmacionContrasena(){
    inputConfirmacion.addEventListener('keyup', ()=>{
        inputConfirmacion.setCustomValidity("");

        if(inputConfirmacion.checkValidity()){
            if (inputContrasena.value != inputConfirmacion.value){
                inputConfirmacion.setCustomValidity("Las contraseña no coinciden");
                inputConfirmacion.reportValidity();
                
            }
        }
    })
}

function eventoInputContrasena(){
    inputContrasena.addEventListener('keyup', ()=>{
        if(inputContrasena.value.length > 7 && inputConfirmacion.required != true){
            inputConfirmacion.required = true;

        }else if(inputContrasena.value.length < 8 && inputContrasena.required != true){ 
            inputConfirmacion.required = false;
        }
    })
}

function eventoSelectRol(){
    const cajasContrasena = document.getElementsByClassName('input-caja-contrasena');

    selectRol.addEventListener('change', ()=>{
        if(selectRol.value == 'COORDINADOR' || selectRol.value == 'INSTRUCTOR'){
            for(const caja of cajasContrasena){
                if(window.innerWidth < 768){
                    caja.classList.add('seccion-individual-03');

                    if(caja.style.display == 'none'){
                        caja.style.display = 'block';
                    }

                }else{
                    caja.style.display = 'block';
                }
            };

            if(rolActual != 'COORDINADOR' && rolActual != 'INSTRUCTOR'){
                inputContrasena.required = true;
                inputConfirmacion.required = true;
            }

        }else{
            for(const caja of cajasContrasena){
                caja.style.display = 'none';
                caja.classList.remove('seccion-individual-03');
            };
            inputContrasena.required = false;
            inputConfirmacion.required = false;
        }
    })
}

function eventoSelectContrato(){
    const cajaFecha = document.getElementById('input_caja_fecha');

    selectTipoContrato.addEventListener('change', ()=>{
        if(selectTipoContrato.value == 'CONTRATISTA'){
            inputFechaContrato.required = true;
            inputFechaContrato.classList.add('campo-individual-02');
            cajaFecha.style.display = 'block';
            cajaFecha.classList.add('seccion-individual-02');

        }else{
            inputFechaContrato.required = false;
            inputFechaContrato.classList.remove('campo-individual-02');
            cajaFecha.style.display = 'none';
            cajaFecha.classList.remove('seccion-individual-02');
        }
    })
}

function eventoActualizarFuncionario(){
    let formularioFuncionario = document.getElementById('formulario_funcionario');
    formularioFuncionario.addEventListener('submit', (e)=>{
        e.preventDefault();

        let formData = new FormData();
        formData.append('operacion', 'actualizar_funcionario');
        formData.append('numero_documento', inputDocumento.value);
        formData.append('nombres', inputNombres.value);
        formData.append('apellidos', inputApellidos.value);
        formData.append('telefono', inputTelefono.value);
        formData.append('correo_electronico', inputCorreo.value);
        formData.append('brigadista', selectBrigadista.value);
        formData.append('tipo_contrato', selectTipoContrato.value);
        formData.append('rol', selectRol.value);

        if(selectTipoContrato.value == 'CONTRATISTA'){
            formData.append('fecha_fin_contrato', inputFechaContrato.value);
        }

        if(selectRol.value == 'COORDINADOR' || selectRol.value == 'INSTRUCTOR'){
            formData.append('contrasena', inputContrasena.value)
        }

        actualizarFuncionario(formData, urlBase).then(respuesta=>{
            if(respuesta.tipo == "OK" ){
                alertaExito(respuesta);
                funcionCallback();
                botonCerrarModal.click();
                
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

function mostrarCampos(){
    const inputsSeccionIndividual01 = document.getElementsByClassName('campo-individual-01');
    const inputsSeccionIndividual02 = document.getElementsByClassName('campo-individual-02');

    botonSiguiente.addEventListener('click', ()=>{
        let camposValidos = true;

        if(seccionIndividual01[0].style.display != 'none'){
            for(const input of inputsSeccionIndividual01) {
                if(!input.checkValidity()){
                    input.reportValidity();
                    camposValidos = false;
                    break;
                }
            };

            if(camposValidos){
                for(const caja of seccionIndividual01){
                    caja.style.display = 'none';
                }
            
                for(const caja of seccionIndividual02){
                    caja.style.display = 'block';
                }

                botonCancelar.style.display = 'none';
                botonAtras.style.display = 'flex';

                inputCorreo.focus();
            }
            
        }else if(seccionIndividual02[0].style.display == 'block'){
            for(const input of inputsSeccionIndividual02) {
                if(!input.checkValidity()){
                    input.reportValidity();
                    camposValidos = false;
                    break;
                }
            };

            if(camposValidos){
                for(const caja of seccionIndividual02){
                    caja.style.display = 'none';
                }
            
                for(const caja of seccionIndividual03){
                    caja.style.display = 'block';
                }

                botonSiguiente.style.display = 'none';
                botonRegistrar.style.display = 'flex';

                selectRol.focus();
            }
        }
    })
}

function volverCampos(){
    botonAtras.addEventListener('click', ()=>{
        if(seccionIndividual02[0].style.display == 'block'){

            for(const caja of seccionIndividual02){
                caja.style.display = 'none';
            }
           
            for(const caja of seccionIndividual01){
                caja.style.display = 'block';
            }
            
            botonAtras.style.display = 'none';
            botonCancelar.style.display = 'flex';

            selectTipoDocumento.focus();

        }else if(seccionIndividual03[0].style.display == 'block'){
            for(const caja of seccionIndividual03){
                caja.style.display = 'none';
            }
           
            for(const caja of seccionIndividual02){
                caja.style.display = 'block';
            }

            botonRegistrar.style.display = 'none';
            botonSiguiente.style.display = 'flex';

            inputCorreo.focus();
        }
    })
}

function alertaExito(respuesta){
    Swal.fire({
        toast: true, 
        position: 'bottom-end', 
        icon: 'success',
        iconColor: "#2db910",
        color: '#F3F4F4',
        background: '#001629',
        timer: 5000,
        timerProgressBar: true,
        title: respuesta.mensaje,
        showConfirmButton: false,   
        customClass: {
            popup: 'alerta-contenedor exito',
        },
        didOpen: (toast) => {
            toast.addEventListener('click', () => {
                Swal.close();
            });
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