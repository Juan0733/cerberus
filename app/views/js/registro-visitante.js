

function motrarCampos(idModal) {
    let camposInvalidos = [];
    let inputs = document.querySelectorAll('.validacion-campo-'+idModal);
    let contador = 0
    
    inputs.forEach(input => {
        
        contador += 1
        if (contador > 3) {
            contador = 0
            return;
        }else{
            if (!input.checkValidity()) {
                input.classList.add('formatoInvalidado')
                camposInvalidos.push(input);
                input.focus();
                
                
            }else {
                if (input.nextElementSibling) {
                    input.classList.remove('formatoInvalidado');
                }
            }

        }
    });
    if (camposInvalidos.length > 0) {
       
        const nombreCampo = camposInvalidos[0].getAttribute('date');
        
        const tituloCampo = camposInvalidos[0].getAttribute('title');
        
        Swal.fire({
            icon: 'info',
            title: 'Formato Invalido',
            text: 'El campo ' + camposInvalidos[0].getAttribute('name') + ' no cumple con el formato solicitado. ' + tituloCampo,
            confirmButtonText: 'Aceptar',
            customClass: {
                popup: 'alerta-contenedor',
                confirmButton: 'btn-confirmar'
            }
        });
        camposInvalidos[0].focus();
        return; 
    }else{
    
        inputs.forEach(input => {
            if (input.checkValidity()) {
                input.classList.remove('formatoInvalidado')
            }
        });
        const caja02 = document.getElementById('caja_02_registro')
        const btnAtras = document.getElementById('btn_atras')
        caja02.style.display = "block"
        btnAtras.style.display = 'flex'
        document.querySelector('.caja_01_registro_'+idModal).style.display = "none";
        
        document.getElementById('tipo_doc_visitante').focus()
    
        document.querySelector('.btn-cancelar-'+idModal).style.display = "none";
        document.querySelector('.btn-siguiente-'+idModal).style.display = 'none'
        document.querySelector('.btn_registrarme-'+idModal).style.display ='flex'

    }
}



function volverCampos(idModal) {
    const caja01 = document.querySelector('.caja_01_registro_'+idModal)
    const btnAtras = document.querySelector('.btn_atras_'+idModal)
    caja01.style.display = "block"
    btnAtras.style.display = 'none'
    document.querySelector('.caja_02_registro_'+idModal).style.display = "none";
    

    document.querySelector('.btn-cancelar-'+idModal).style.display = "flex";
    document.querySelector('.btn-siguiente-'+idModal).style.display = 'block'
    document.querySelector('.btn_registrarme-'+idModal).style.display ='none'
}



function enviaFormulario(idFormulario) {
    const formularios_modales = document.querySelector(".formulario_modal_"+idFormulario);
    if (idFormulario == '06') {
        
        var idPersona = document.getElementById('persona-identificacion-informes').value;
        var fechaInicio = document.getElementById('fecha_inicio_input-modal').value;
        alert(document.getElementById('fecha_inicio_input-modal').getAttribute('title'))
        var fechaFinal = document.getElementById('fecha_final_input-modal').value;

        // Verificar cuáles campos están vacíos
        var camposFaltantes = [];
        if (!idPersona) {
            alert(document.getElementById('persona-identificacion-informes').value)
            camposFaltantes.push('Identificación de la persona');
        }
        if (!fechaInicio) {
            camposFaltantes.push('Fecha de inicio');
        }
        if (!fechaFinal) {
            camposFaltantes.push('Fecha final');
        }

        if (camposFaltantes.length > 0) {
            alert('Los siguientes campos son obligatorios: \n' + camposFaltantes.join('\n'));
            return;
        }

        var url = document.getElementById('url_informe').value
        url = url + `?id_persona=${idPersona}&fecha_inicio=${fechaInicio}&fecha_final=${fechaFinal}`;
        window.open(url, 'Imprimir factura', 'width=820,height=720,top=0,left=100,menubar=NO,toolbar=YES');
    }else{ 
        Swal.fire({
            title: '¿Estás seguro?',
            text: "Quieres realizar la acción solicitada",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Si, realizar',
            cancelButtonText: 'No, cancelar',
            customClass: {
                popup: 'alerta-contenedor',
                confirmButton: 'btn-confirmar',
                cancelButton: 'btn-cancelar'
            }
        }).then((result) => {
            if (result.isConfirmed) {
                let data = new FormData(formularios_modales);
                let method = formularios_modales.getAttribute("method");
                let action = formularios_modales.getAttribute("action");
    
                let encabezados = new Headers();
    
                let config = {
                    method: method,
                    headers: encabezados,
                    mode: 'cors',
                    cache: 'no-cache',
                    body: data
                };
    
                fetch(action, config)
                    .then(respuesta => respuesta.json())
                    .then(respuesta => {
                        if (idFormulario == '03') {
                            let paginaActual = 1
                            getDataVehiculo(paginaActual)
                        }
                        if (respuesta.codigo == "MDFEX") {
                            var botonCancelar = document.querySelector( '.btn-cancelar-'+idFormulario);
                            botonCancelar.click();
                        }
                        manejo_de_alertas(respuesta)
                    })
                    .catch((error) => {
                        console.error('Hubo un problema con la solicitud fetch:', error);
                        Swal.fire({
                            icon: 'info',
                            title: 'Error',
                            text: 'Ocurrió un error al procesar la solicitud.',
                            confirmButtonText: 'Aceptar',
                            customClass: {
                                popup: 'alerta-contenedor',
                                confirmButton: 'btn-confirmar'
                            }
                        });
                    });
            }
        });
    

    }
   



    
}

function enviaFormularioEditar(idFormulario) {
    const formularios_modales = document.querySelector(".formulario_modal_"+idFormulario);

    Swal.fire({
        title: '¿Estás seguro?',
        text: "Quieres realizar la acción solicitada",
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Si, realizar',
        cancelButtonText: 'No, cancelar',
        customClass: {
            popup: 'alerta-contenedor',
            confirmButton: 'btn-confirmar',
            cancelButton: 'btn-cancelar'
        }
    }).then((result) => {
        if (result.isConfirmed) {
            let data = new FormData(formularios_modales);
            let method = formularios_modales.getAttribute("method");
            let action = formularios_modales.getAttribute("action");

            let encabezados = new Headers();

            let config = {
                method: method,
                headers: encabezados,
                mode: 'cors',
                cache: 'no-cache',
                body: data
            };

            fetch(action, config)
                .then(respuesta => respuesta.json())
                .then(respuesta => {
                    if (idFormulario == '03') {
                        let paginaActual = 1

                        getDataVehiculo(paginaActual)
                    }
                    manejo_de_alertas(respuesta)
                    if (respuesta.icon == "sucess") {
                        closeModal()
                    }
                })
                .catch((error) => {
                    console.error('Hubo un problema con la solicitud fetch:', error);
                    Swal.fire({
                        icon: 'info',
                        title: 'Error',
                        text: 'Ocurrió un error al procesar la solicitud.',
                        confirmButtonText: 'Aceptar',
                        customClass: {
                            popup: 'alerta-contenedor',
                            confirmButton: 'btn-confirmar'
                        }
                    });
                });
        }
    });
    
}
    

function manejo_de_alertas(respuesta){
    if(respuesta.tipoMensaje =="normal"){

        Swal.fire({
            icon: respuesta.icono,
            title: respuesta.titulo,
            text: respuesta.mensaje,
            confirmButtonText: 'Aceptar',
            customClass: {
                popup: 'alerta-contenedor',
                confirmButton: 'btn-confirmar'
            }
        });

    }else if(respuesta.tipoMensaje == "confirmado"){

        Swal.fire({
            icon: respuesta.icono,
            title: respuesta.titulo,
            text: respuesta.mensaje,
            timer: 2000,
            confirmButtonText: 'Aceptar',
            customClass: {
                popup: 'alerta-contenedor',
                confirmButton: 'btn-confirmar',
                icon: 'icon-alert'
            }
        });

    }else if(respuesta.tipoMensaje =="recargar"){
        Swal.fire({
            icon: respuesta.icono,
            title: respuesta.titulo,
            text: respuesta.mensaje,
            confirmButtonText: 'Aceptar'
        }).then((result) => {
            if(result.isConfirmed){
                location.reload();
            }
        });

    }else if(respuesta.tipoMensaje =="limpiar"){

        Swal.fire({
            icon: respuesta.icono,
            title: respuesta.titulo,
            text: respuesta.mensaje,
            confirmButtonText: 'Aceptar'
        }).then((result) => {
            if(result.isConfirmed){
                document.querySelector(".Formulario-fetch").reset();
            }
        });

    }else if(respuesta.tipoMensaje =="normal_redireccion"){

        Swal.fire({
            icon: respuesta.icono,
            title: respuesta.titulo,
            text: respuesta.mensaje,
            showCancelButton: true,
            confirmButtonText: 'Aceptar',
            cancelButtonText: 'Cancelar',
            customClass: {
                popup: 'alerta-contenedor',
                confirmButton: 'btn-confirmar',
                cancelButton: 'btn-cancelar' 
            }
        }).then((result) => {
            if (result.isConfirmed) {
                openModal(respuesta.tituloModal, respuesta.url, respuesta.adaptar ) 
            } 
        });
    }else if(respuesta.tipoMensaje =="redireccionar"){

        Swal.fire({
            icon: respuesta.icono,
            title: respuesta.titulo,
            text: respuesta.mensaje,
            confirmButtonText: 'Aceptar'
        }).then((result) => {
            if(result.isConfirmed){
                    window.location.href=respuesta.url;
            }
        });
    }
}
