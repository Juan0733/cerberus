import {actualizarFuncionario, consultarFuncionario} from '../fetchs/funcionarios-fetch.js';

let contenedorModales;
let modalesExistentes;
let botonCerrarModal;
let funcionCallback;
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
let seccion01;
let seccion02;
let seccion03;
let botonAtras;
let botonCancelar;
let botonRegistrar;
let botonSiguiente;
let urlBase;

async function modalActualizacionFuncionario(funcionario, callback, url) {
    try {
        const response = await fetch(url+'app/views/inc/modales/modal-funcionario.php');

        if(!response.ok) throw new Error('Hubo un error en la solicitud');

        const contenidoModal = await response.text();
        const modal = document.createElement('div');
            
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
        seccion01 = document.getElementsByClassName('seccion-01');
        seccion02 = document.getElementsByClassName('seccion-02');
        seccion03 = document.getElementsByClassName('seccion-03');
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
        eventoSelectContrato();
        dibujarFuncionario();
        validarConfirmacionContrasena();
        mostrarCampos();
        volverCampos();
        eventoActualizarFuncionario();

        setTimeout(()=>{
           selectTipoDocumento.focus();
        }, 250)

    } catch (error) {
        if(botonCerrarModal){
            botonCerrarModal.click();
        }

        console.error('Hubo un error:', error);
        alertaError({
            titulo: 'Error Modal',
            mensaje: 'Error al cargar modal actualización funcionario.'
        });
    }
}
export { modalActualizacionFuncionario };

function eventoCerrarModal(){
    botonCerrarModal = document.getElementById('cerrar_modal_funcionario');

    botonCerrarModal.addEventListener('click', ()=>{
        modalesExistentes[modalesExistentes.length-1].remove();
        contenedorModales.classList.remove('mostrar');
        
    });

    document.getElementById('btn_cancelar_funcionario').addEventListener('click', ()=>{
        botonCerrarModal.click();
    });
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
            eventoSelectRol();

            if(datosFuncionario.tipo_contrato == 'contratista'){
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

        if(selectTipoContrato.value == 'contratista'){
            formData.append('fecha_fin_contrato', inputFechaContrato.value);
        }

        if(selectRol.value == 'coordinador'){
            formData.append('contrasena', inputContrasena.value)
        }

        actualizarFuncionario(formData, urlBase).then(respuesta=>{
            if(respuesta.tipo == "OK" ){
                alertaExito(respuesta);
                botonCerrarModal.click();
                funcionCallback();
                
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

function validarConfirmacionContrasena(){
    let temporizador;
    let primeraValidacion = true;

    inputConfirmacion.addEventListener('keyup', ()=>{
        clearTimeout(temporizador);
        temporizador = setTimeout(()=>{
            if (inputContrasena.value != inputConfirmacion.value){
                if(primeraValidacion){
                    inputConfirmacion.setCustomValidity("Las contraseña no coinciden");
                    inputConfirmacion.reportValidity();
                    primeraValidacion = false;
                }

            }else {
                inputConfirmacion.setCustomValidity(""); 
                primeraValidacion = true;
            }
        }, 1000);
    })
}

function eventoSelectRol(){
    const cajasContrasena = document.getElementsByClassName('input-caja-contrasena');

    selectRol.addEventListener('change', ()=>{
        if(selectRol.value == 'coordinador'){
            for(const caja of cajasContrasena){
                caja.style.display = 'block';
                caja.classList.add('seccion-03');
            };

            if(rolActual != 'coordinador'){
                inputContrasena.required = true;
                inputConfirmacion.required = true;
            }

        }else{
            for(const caja of cajasContrasena){
                caja.style.display = 'none';
                caja.classList.remove('seccion-03');
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
            inputFechaContrato.classList.add('campo-seccion-02');
            cajaFecha.style.display = 'block';
            cajaFecha.classList.add('seccion-02');

        }else{
            inputFechaContrato.required = false;
            inputFechaContrato.classList.remove('campo-seccion-02');
            cajaFecha.style.display = 'none';
            cajaFecha.classList.remove('seccion-02');
        }
    })
}

function mostrarCampos(){
    const inputsSeccion01 = document.getElementsByClassName('campo-seccion-01');
    const inputsSeccion02 = document.getElementsByClassName('campo-seccion-02');

    botonSiguiente.addEventListener('click', ()=>{
        let validos = true;

        if(seccion01[0].style.display != 'none'){
            for(const input of inputsSeccion01) {
                if(!input.checkValidity()){
                    input.reportValidity();
                    validos = false;
                    break;
                }
            };

            if(validos){
                for(const caja of seccion01){
                    caja.style.display = 'none';
                }
            
                for(const caja of seccion02){
                    caja.style.display = 'block';
                }

                inputCorreo.focus();

                botonCancelar.style.display = 'none';
                botonAtras.style.display = 'flex';
            }
            
        }else if(seccion02[0].style.display == 'block'){
            for(const input of inputsSeccion02) {
                if(!input.checkValidity()){
                    input.reportValidity();
                    validos = false;
                    break;
                }
            };

            if(validos){
                for(const caja of seccion02){
                    caja.style.display = 'none';
                }
            
                for(const caja of seccion03){
                    caja.style.display = 'block';
                }

                selectRol.focus();

                botonSiguiente.style.display = 'none';
                botonRegistrar.style.display = 'flex';
            }
        }
    })
}

function volverCampos(){
    botonAtras.addEventListener('click', ()=>{
        if(seccion02[0].style.display == 'block'){

            for(const caja of seccion02){
                caja.style.display = 'none';
            }
           
            for(const caja of seccion01){
                caja.style.display = 'block';
            }

            selectTipoDocumento.focus();
            
            botonAtras.style.display = 'none';
            botonCancelar.style.display = 'flex';

        }else if(seccion03[0].style.display == 'block'){
             for(const caja of seccion03){
                caja.style.display = 'none';
            }
           
            for(const caja of seccion02){
                caja.style.display = 'block';
            }

            inputCorreo.focus();

            botonRegistrar.style.display = 'none';
            botonSiguiente.style.display = 'flex';
        }
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